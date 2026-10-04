<?php

namespace App\Http\Controllers;

use App\Events\ClientIdAutofillCompleted;
use App\Services\GeminiIdExtractor;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use RuntimeException;

class ClientIdAutofillController extends Controller
{
    private const SESSION_LIFETIME_MINUTES = 10;

    public function createSession(Request $request)
    {
        Gate::authorize('access-receptionist');

        $validated = $request->validate([
            'valid_id_type' => ['required', 'string', 'max:100'],
        ]);

        $scanSession = (string) Str::uuid();
        $token = Str::random(64);
        $expiresAt = now()->addMinutes(self::SESSION_LIFETIME_MINUTES);

        Cache::put($this->sessionKey($scanSession), [
            'user_id' => $request->user()->getAuthIdentifier(),
            'token_hash' => hash('sha256', $token),
            'valid_id_type' => $validated['valid_id_type'],
            'status' => 'pending',
        ], $expiresAt);

        $captureUrl = URL::temporarySignedRoute(
            'client-id-autofill.capture',
            $expiresAt,
            ['scanSession' => $scanSession, 'token' => $token]
        );

        $qrCode = new QrCode($captureUrl);
        $qrImage = (new PngWriter)->write($qrCode)->getString();

        return response()->json([
            'qrImage' => 'data:image/png;base64,'.base64_encode($qrImage),
            'channel' => "id-autofill.{$scanSession}",
            'expiresIn' => self::SESSION_LIFETIME_MINUTES * 60,
        ]);
    }

    public function capture(Request $request, string $scanSession, GeminiIdExtractor $extractor): View|JsonResponse
    {
        $sessionKey = $this->sessionKey($scanSession);
        $session = Cache::get($sessionKey);

        abort_unless($this->hasValidToken($request, $session), 410, 'This QR code has expired. Ask the receptionist to generate a new one.');

        if ($request->isMethod('get')) {
            abort_unless($session['status'] === 'pending', 410, 'This QR code has already been used.');

            return view('client-registration.id-capture', [
                'validIdType' => $session['valid_id_type'],
            ]);
        }

        $validated = $request->validate([
            'id_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $lock = Cache::lock("{$sessionKey}:lock", 60);

        if (! $lock->get()) {
            return response()->json(['message' => 'An ID photo is already being processed.'], 409);
        }

        try {
            $session = Cache::get($sessionKey);

            if (! $this->hasValidToken($request, $session) || $session['status'] !== 'pending') {
                return response()->json(['message' => 'This QR code has expired or has already been used.'], 410);
            }

            $session['status'] = 'processing';
            Cache::put($sessionKey, $session, now()->addMinutes(self::SESSION_LIFETIME_MINUTES));

            $fields = $extractor->extract($validated['id_photo']);
            $fields['valid_id_type'] = $session['valid_id_type'];

            $session['status'] = 'completed';
            Cache::put($sessionKey, $session, now()->addMinutes(self::SESSION_LIFETIME_MINUTES));

            event(new ClientIdAutofillCompleted($scanSession, $fields));

            return response()->json(['success' => true]);
        } catch (RuntimeException $exception) {
            $session = Cache::get($sessionKey);

            if (is_array($session)) {
                $session['status'] = 'pending';
                Cache::put($sessionKey, $session, now()->addMinutes(self::SESSION_LIFETIME_MINUTES));
            }

            $status = in_array($exception->getCode(), [422, 502, 503], true)
                ? $exception->getCode()
                : 502;

            return response()->json(['message' => $exception->getMessage()], $status);
        } finally {
            $lock->release();
        }
    }

    private function sessionKey(string $scanSession): string
    {
        return "client-id-autofill-session.{$scanSession}";
    }

    private function hasValidToken(Request $request, mixed $session): bool
    {
        $token = (string) $request->query('token');

        return is_array($session)
            && $token !== ''
            && hash_equals($session['token_hash'], hash('sha256', $token));
    }
}
