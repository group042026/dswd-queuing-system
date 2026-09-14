<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Successful - DSWD</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, sans-serif;
            background: #0038a8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 32px 24px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .queue-number {
            font-size: 48px;
            font-weight: 800;
            color: #0038a8;
            font-family: monospace;
            margin: 12px 0;
        }
        p.note { font-size: 13px; color: #64748b; margin-top: 16px; line-height: 1.5; }
        .control-number { font-family: monospace; font-size: 13px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="card">
        <div style="font-size: 40px;">✅</div>
        <h1 style="font-size: 18px; margin-top: 8px;">Pre-Registration Successful!</h1>
        <p class="note">Your Queue Number:</p>
        <div class="queue-number">{{ $queueNumber }}</div>
        <p class="control-number">{{ $controlNumber }}</p>
        <p class="note">
            Please take a screenshot or write down your Control Number. Present this at the DSWD office when you arrive, along with your original valid ID.
        </p>
    </div>
</body>
</html>