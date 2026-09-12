<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Capture MOV - DSWD</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Figtree', sans-serif;
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
            padding: 24px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .badge {
            font-size: 11px;
            font-weight: 700;
            color: #0038a8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        h1 {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            margin: 8px 0 4px;
        }
        p.subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 20px;
        }
        .capture-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px 20px;
            margin-bottom: 16px;
        }
        input[type="file"] {
            display: none;
        }
        .btn {
            display: inline-block;
            background: #0038a8;
            color: white;
            font-weight: 700;
            font-size: 14px;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .btn:disabled {
            background: #94a3b8;
        }
        #preview {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 16px;
            display: none;
        }
        .status {
            font-size: 13px;
            margin-top: 12px;
        }
        .status--success { color: #16a34a; font-weight: 700; }
        .status--error { color: #dc2626; font-weight: 700; }
    </style>
</head>
<body>
    <div class="card" id="mainCard">
        <p class="badge">DSWD Verification</p>
        <h1>Capture MOV</h1>
        <p class="subtitle">Client: {{ $client->first_name }} {{ $client->last_name }}</p>

        <form id="uploadForm">
            <div class="capture-area">
                <img id="preview" alt="Preview">
                <label for="fileInput" class="btn" id="captureBtn">
                    📷 Take Photo
                </label>
                <input type="file" id="fileInput" name="file" accept="image/*" capture="environment">
            </div>

            <button type="submit" class="btn" id="submitBtn" disabled>Upload Photo</button>
        </form>

        <p class="status" id="statusMsg"></p>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const submitBtn = document.getElementById('submitBtn');
        const statusMsg = document.getElementById('statusMsg');
        const form = document.getElementById('uploadForm');
        const mainCard = document.getElementById('mainCard');

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (!file) return;

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            submitBtn.disabled = false;
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            if (!fileInput.files[0]) return;

            submitBtn.disabled = true;
            submitBtn.textContent = 'Uploading...';
            statusMsg.textContent = '';

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);

            fetch(window.location.href, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        Accept: 'application/json',
                    },
                })
                .then(async (response) => {
                    const text = await response.text();

                    if (!response.ok) {
                        throw new Error(`Upload failed (${response.status}): ${text}`);
                    }

                    return JSON.parse(text);
                })
                .then((data) => {
                    if (!data.success) {
                        throw new Error('Upload failed');
                    }

                    mainCard.innerHTML = `
                        <div style="font-size: 56px; margin-bottom: 12px;">✅</div>
                        <h1 style="color: #16a34a; font-size: 22px;">Upload Complete!</h1>
                        <p class="subtitle" style="margin-top: 8px;">Thank you! You may now close this page.</p>
                    `;
                })
                .catch((error) => {
                    console.error(error);
                    statusMsg.textContent = error.message;
                    statusMsg.className = 'status status--error';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Upload Photo';
                });
        });
    </script>
</body>
</html>