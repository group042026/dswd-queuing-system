<?php

namespace App\Http\Controllers;

use App\Events\MovUploaded;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Documents;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;


class MovController extends Controller
{
    public function showCaptureForm(Request $request, Client $client)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'This link has expired or is invalid.');
        }

        return view('mov.capture', [
            'client' => $client,
        ]);
    }

    public function upload(Request $request, Client $client)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'This link has expired or is invalid.');
        }

        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:20480'],
        ]);

        // Tanggalin ang lumang unverified MOV (kung meron), para hindi magdoble
        $oldMov = Documents::where('client_id', $client->id)
            ->where('document_name', 'Means of Verification (MOV)')
            ->where('verified', false)
            ->first();

        if ($oldMov) {
            Storage::disk('public')->delete($oldMov->file_path);
            $oldMov->delete();
        }

        $path = $request->file('file')->store('mov-uploads', 'public');

        $document = Documents::create([
            'client_id' => $client->id,
            'document_name' => 'Means of Verification (MOV)',
            'file_path' => $path,
            'verified' => false,
        ]);

        ActivityLog::record(
            'MOV Uploaded',
            "Means of Verification uploaded via QR scan for {$client->first_name} {$client->last_name}"
        );

        event(new MovUploaded(
            $client->id,
            $document->id,
            Storage::url($path),
            $document->document_name
        ));

        return response()->json(['success' => true]);
    }
    
    public function generateQr(Client $client)
    {
        Gate::authorize('access-receptionist');

        $signedUrl = URL::temporarySignedRoute(
            'mov.capture',
            now()->addMinutes(15),
            ['client' => $client->id]
        );

        $qrCode = new QrCode($signedUrl);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $base64 = base64_encode($result->getString());

        return response()->json([
            'qrImage' => "data:image/png;base64,{$base64}",
            'channel' => "mov-upload.{$client->id}",
        ]);
    }
}