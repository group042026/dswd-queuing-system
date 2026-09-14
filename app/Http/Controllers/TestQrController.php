<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Zxing\QrReader;

class TestQrController extends Controller
{
    public function show()
    {
        return view('test.qr-scan');
    }

    public function decode(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
                'dimensions:max_width=4000,max_height=4000',
            ],
        ]);

        $path = $request->file('file')->store('temp-qr-tests', 'public');
        $fullPath = Storage::disk('public')->path($path);

        try {
            $decodedText = (new QrReader($fullPath))->text();

            return view('test.qr-scan', [
                'result' => $decodedText !== false ? $decodedText : null,
                'error' => $decodedText === false
                    ? 'Walang QR code na na-detect sa litrato.'
                    : null,
            ]);
        } catch (Throwable $exception) {
            return view('test.qr-scan', [
                'error' => 'Decoding failed. Gumamit ng mas maliit na image.',
            ]);
        } finally {
            Storage::disk('public')->delete($path);
        }
    }
}