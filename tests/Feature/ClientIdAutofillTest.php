<?php

namespace Tests\Feature;

use App\Events\ClientIdAutofillCompleted;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClientIdAutofillTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('access-receptionist', fn (): bool => true);
    }

    public function test_receptionist_can_generate_a_temporary_qr_code(): void
    {
        $this->actAsReceptionist();

        $response = $this->postJson(route('receptionist.clients.id-autofill-session'), [
            'valid_id_type' => 'Passport',
        ]);

        $response->assertOk()
            ->assertJsonPath('channel', fn (string $channel): bool => str_starts_with($channel, 'id-autofill.'))
            ->assertJsonPath('expiresIn', 600);

        $this->assertStringStartsWith('data:image/png;base64,', $response->json('qrImage'));
    }

    public function test_signed_phone_upload_broadcasts_extracted_fields_and_cannot_be_replayed(): void
    {
        config([
            'services.gemini.api_key' => 'test-api-key',
            'services.gemini.model' => 'gemini-test-model',
        ]);

        $user = $this->actAsReceptionist();

        $scanSession = (string) Str::uuid();
        $token = Str::random(64);
        $expiresAt = now()->addMinutes(10);

        Cache::put("client-id-autofill-session.{$scanSession}", [
            'user_id' => $user->getAuthIdentifier(),
            'token_hash' => hash('sha256', $token),
            'valid_id_type' => 'Passport',
            'status' => 'pending',
        ], $expiresAt);

        $signedUrl = URL::temporarySignedRoute(
            'client-id-autofill.capture',
            $expiresAt,
            ['scanSession' => $scanSession, 'token' => $token]
        );

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [[
                    'content' => [
                        'parts' => [[
                            'text' => json_encode([
                                'first_name' => 'Maria',
                                'middle_name' => null,
                                'last_name' => 'Santos',
                                'suffix' => null,
                                'sex' => 'Female',
                                'birthdate' => '1990-01-02',
                                'valid_id_number' => 'P12345678',
                                'region' => null,
                                'province' => null,
                                'municipality' => null,
                                'barangay' => null,
                            ]),
                        ]],
                    ],
                ]],
            ], 200),
        ]);

        Event::fake([ClientIdAutofillCompleted::class]);

        $this->post($signedUrl, [
            'id_photo' => UploadedFile::fake()->image('passport.jpg'),
        ])->assertOk()->assertJson(['success' => true]);

        Event::assertDispatched(ClientIdAutofillCompleted::class, function (ClientIdAutofillCompleted $event) use ($scanSession): bool {
            return $event->scanSession === $scanSession
                && $event->fields['first_name'] === 'Maria'
                && $event->fields['valid_id_type'] === 'Passport'
                && $event->fields['valid_id_number'] === 'P12345678';
        });

        $this->post($signedUrl, [
            'id_photo' => UploadedFile::fake()->image('passport-again.jpg'),
        ])->assertStatus(410);

        Http::assertSentCount(1);
    }

    public function test_phone_capture_rejects_an_invalid_signature(): void
    {
        $this->get('/client-id-autofill/'.Str::uuid().'?token=invalid')
            ->assertForbidden();
    }

    private function actAsReceptionist(): User
    {
        $user = new User;
        $user->setAttribute('id', 123);

        $this->actingAs($user);

        return $user;
    }
}
