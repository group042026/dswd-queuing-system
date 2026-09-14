<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Feasibility Test</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, sans-serif;
            background: #f1f5f9;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        h1 { font-size: 18px; margin-bottom: 4px; }
        p.subtitle { font-size: 13px; color: #64748b; margin-bottom: 16px; }
        input[type="file"] { margin-top: 8px; }
        .btn {
            display: inline-block;
            background: #0038a8;
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-top: 12px;
        }
        .result {
            margin-top: 16px;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            word-break: break-all;
            white-space: pre-wrap;
        }
        .result--success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; }
        .result--error { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🔍 QR Feasibility Test (Server-Side)</h1>
        <p class="subtitle">Mag-upload ng litrato ng QR code (National ID, Driver's License, atbp.)</p>

        <form method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept="image/*" required>
            <br>
            <button type="submit" class="btn">🔍 I-decode</button>
        </form>

        @if(isset($result))
            <div class="result result--success">
                <strong>✅ Decoded Content:</strong>

                {{ $result }}
            </div>
        @endif

        @if(isset($error))
            <div class="result result--error">
                <strong>❌ Error:</strong> {{ $error }}
            </div>
        @endif
    </div>
</body>
</html>