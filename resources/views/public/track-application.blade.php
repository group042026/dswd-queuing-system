<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Track Application - DSWD</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px 16px 40px;
            min-height: 100vh;
            background: #f1f5f9;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 480px;
            margin: 0 auto;
        }

        .header {
            padding: 22px 20px;
            border-radius: 14px 14px 0 0;
            color: white;
            background: linear-gradient(135deg, #0038a8, #1e40af 65%, #ce1126);
        }

        .header h1 {
            margin: 0 0 6px;
            font-size: 21px;
        }

        .header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .card {
            margin-bottom: 16px;
            padding: 20px;
            border-radius: 0 0 14px 14px;
            background: white;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        }

        .result-card {
            border-radius: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        input {
            width: 100%;
            margin-bottom: 14px;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #0038a8;
        }

        button {
            width: 100%;
            padding: 13px;
            border: 0;
            border-radius: 9px;
            color: white;
            background: #0038a8;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .error {
            margin-bottom: 14px;
            padding: 11px;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #b91c1c;
            background: #fef2f2;
            font-size: 13px;
        }

        .queue-number {
            margin: 12px 0;
            color: #0038a8;
            font-family: monospace;
            font-size: 48px;
            font-weight: 800;
            text-align: center;
        }

        .status {
            margin-bottom: 18px;
            padding: 11px;
            border-radius: 8px;
            color: #075985;
            background: #e0f2fe;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
        }

        .details {
            display: grid;
            gap: 11px;
        }

        .detail {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 9px;
            font-size: 13px;
        }

        .detail span:first-child {
            color: #64748b;
        }

        .detail span:last-child {
            color: #1e293b;
            font-weight: 700;
            text-align: right;
        }

        .back-link {
            display: block;
            margin-top: 16px;
            color: #0038a8;
            font-size: 13px;
            text-align: center;
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <h1>Track My Application</h1>
            <p>Enter your Control Number and Contact Number.</p>
        </div>

        <div class="card">
            @if($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('public.track.search') }}">
                @csrf

                <label for="control_number">Control Number</label>
                <input
                    id="control_number"
                    name="control_number"
                    type="text"
                    value="{{ old('control_number') }}"
                    placeholder="Example: CN-2026-00001"
                    required
                >

                <label for="contact_number">Contact Number</label>
                <input
                    id="contact_number"
                    name="contact_number"
                    type="text"
                    value="{{ old('contact_number') }}"
                    placeholder="Enter the same number used during registration"
                    required
                >

                <button type="submit">Track Application</button>
            </form>

            <a class="back-link" href="{{ route('public.register') }}">
                New applicant? Register here
            </a>
        </div>

        @isset($application)
            <div class="card result-card">
                <div class="status">{{ $statusLabel }}</div>

                <p style="margin: 0; color: #64748b; font-size: 13px; text-align: center;">
                    Your Queue Number
                </p>

                <div class="queue-number">
                    {{ $application->queue_number }}
                </div>

                <div class="details">
                    <div class="detail">
                        <span>Control Number</span>
                        <span>{{ $application->client->control_number }}</span>
                    </div>

                    <div class="detail">
                        <span>Applicant</span>
                        <span>
                            {{ $application->client->first_name }}
                            {{ $application->client->last_name }}
                        </span>
                    </div>

                    <div class="detail">
                        <span>Application Date</span>
                        <span>{{ $application->client->date_registered?->format('M d, Y h:i A') }}</span>
                    </div>

                    <div class="detail">
                        <span>Priority</span>
                        <span>{{ $application->priority ? 'Priority' : 'Regular' }}</span>
                    </div>
                </div>

                <p style="margin: 18px 0 0; color: #64748b; font-size: 12px; line-height: 1.5;">
                    Please present your Control Number and original valid ID when you arrive at the DSWD office.
                </p>
            </div>
        @endisset
    </main>
</body>
</html>