<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Scan ID - DSWD</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            padding: 20px;
            display: grid;
            place-items: center;
            background: #eef2f7;
            color: #172033;
            font-family: Arial, sans-serif;
        }
        .capture-panel {
            width: min(100%, 440px);
            padding: 24px;
            background: #fff;
            border: 1px solid #d8e0eb;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .1);
        }
        .eyebrow {
            margin: 0 0 8px;
            color: #0038a8;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        h1 { margin: 0; font-size: 22px; }
        .description { margin: 10px 0 20px; color: #5f6b7a; line-height: 1.5; font-size: 14px; }
        .photo-frame {
            min-height: 190px;
            margin-bottom: 14px;
            padding: 18px;
            display: grid;
            place-items: center;
            border: 1px dashed #9aabc0;
            border-radius: 10px;
            background: #f8fafc;
        }
        #photo-preview {
            display: none;
            max-width: 100%;
            max-height: 320px;
            object-fit: contain;
            border-radius: 6px;
        }
        input[type="file"] { position: absolute; width: 1px; height: 1px; opacity: 0; }
        .button {
            width: 100%;
            min-height: 46px;
            padding: 12px 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 8px;
            background: #0038a8;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }
        .button:disabled { background: #94a3b8; cursor: wait; }
        .button-secondary { margin-bottom: 10px; background: #e8effa; color: #0038a8; }
        .status { min-height: 22px; margin: 14px 0 0; color: #526174; font-size: 13px; line-height: 1.45; }
        .status--error { color: #b42318; }
        .status--success { color: #067647; }
    </style>
</head>
<body>
    <main class="capture-panel">
        <p class="eyebrow">DSWD client registration</p>
        <h1>Take a photo of the ID</h1>
        <p class="description">
            ID type: <strong>{{ $validIdType }}</strong>. Place the ID on a flat surface with all text visible.
            The photo is sent for reading and is not saved by this scan flow.
        </p>

        <form id="id-capture-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="photo-frame">
                <img id="photo-preview" alt="ID photo preview">
                <span id="photo-placeholder">Photo preview will appear here</span>
            </div>

            <label class="button button-secondary" for="id-photo">Take or choose photo</label>
            <input id="id-photo" name="id_photo" type="file" accept="image/jpeg,image/png" capture="environment" required>
            <button id="send-photo" class="button" type="submit" disabled>Send for reading</button>
        </form>

        <p id="capture-status" class="status" aria-live="polite"></p>
    </main>

    <script>
        const form = document.getElementById('id-capture-form');
        const photoInput = document.getElementById('id-photo');
        const preview = document.getElementById('photo-preview');
        const placeholder = document.getElementById('photo-placeholder');
        const sendButton = document.getElementById('send-photo');
        const statusMessage = document.getElementById('capture-status');
        let previewUrl = null;

        photoInput.addEventListener('change', () => {
            const photo = photoInput.files[0];

            if (!photo) return;

            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = URL.createObjectURL(photo);
            preview.src = previewUrl;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            sendButton.disabled = false;
            statusMessage.textContent = 'Check that the text is sharp and fully visible before sending.';
            statusMessage.className = 'status';
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!photoInput.files[0]) return;

            sendButton.disabled = true;
            sendButton.textContent = 'Reading ID...';
            statusMessage.textContent = 'Reading the ID. Keep this page open for a moment.';
            statusMessage.className = 'status';

            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: { Accept: 'application/json' },
                    body: new FormData(form),
                });
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Could not read this photo. Try again with a clearer image.');
                }

                form.innerHTML = '';
                statusMessage.textContent = 'ID sent successfully. The receptionist can now review the extracted details.';
                statusMessage.className = 'status status--success';
            } catch (error) {
                statusMessage.textContent = error.message;
                statusMessage.className = 'status status--error';
                sendButton.disabled = false;
                sendButton.textContent = 'Send for reading';
            }
        });
    </script>
</body>
</html>
