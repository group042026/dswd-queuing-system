<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class GeminiIdExtractor
{
    public function extract(UploadedFile $image): array
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model');

        if (blank($apiKey) || blank($model)) {
            throw new RuntimeException('Gemini is not configured.', 503);
        }

        $prompt = <<<'PROMPT'
Read the visible text from this identification card. Return only a JSON object with these keys:
first_name, middle_name, last_name, suffix, sex, birthdate, valid_id_number, region, province, municipality, barangay.

Rules:
- Transcribe only information that is clearly visible on the card. Do not guess or infer missing values.
- Use null for a field that is absent or unreadable.
- Split the printed name into the most appropriate name fields.
- Return sex as "Male", "Female", or null.
- Return birthdate as YYYY-MM-DD, or null if uncertain.
- Return address parts only when clearly printed. Do not derive one address part from another.
PROMPT;

        try {
            $response = Http::timeout(45)
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'contents' => [[
                            'parts' => [
                                ['text' => $prompt],
                                [
                                    'inline_data' => [
                                        'mime_type' => $image->getMimeType(),
                                        'data' => base64_encode($image->get()),
                                    ],
                                ],
                            ],
                        ]],
                        'generationConfig' => [
                            'responseMimeType' => 'application/json',
                        ],
                    ]
                );
        } catch (\Throwable) {
            throw new RuntimeException('Could not contact the ID-reading service.', 502);
        }

        if (! $response->successful()) {
            throw new RuntimeException('The ID-reading service could not process this photo.', 502);
        }

        $responseText = collect(data_get($response->json(), 'candidates.0.content.parts', []))
            ->pluck('text')
            ->filter()
            ->implode('');

        $extracted = json_decode($responseText, true);

        if (! is_array($extracted)) {
            throw new RuntimeException('Could not read the ID details. Try a clearer photo.', 422);
        }

        $validator = Validator::make($extracted, [
            'first_name' => ['nullable', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'sex' => ['nullable', 'in:Male,Female'],
            'birthdate' => ['nullable', 'date_format:Y-m-d'],
            'valid_id_number' => ['nullable', 'string', 'max:50'],
            'region' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            throw new RuntimeException('The ID result had an invalid format. Please try again.', 422);
        }

        return $validator->validated();
    }
}
