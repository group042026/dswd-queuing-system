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

    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js" integrity="sha384-GJqSu7vueQ9qN0E9yLPb3Wtpd7OrgK8KmYzC8T1IysG1bcvxvIO4qtYR/D3A991F" crossorigin="anonymous"></script>
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
        });

        function labeledValue(lines, labelPattern) {
            const index = lines.findIndex(line => labelPattern.test(line));
            if (index < 0) return null;

            const sameLine = lines[index]
                .replace(labelPattern, '')
                .replace(/^[\s:.-]+/, '')
                .trim();

            return sameLine || lines[index + 1] || null;
        }

        function toIsoDate(value) {
            if (!value) return null;

            const iso = value.match(/\b((?:19|20)\d{2})[-/.](\d{1,2})[-/.](\d{1,2})\b/);
            if (iso) {
                return `${iso[1]}-${iso[2].padStart(2, '0')}-${iso[3].padStart(2, '0')}`;
            }

            const numeric = value.match(/\b(\d{1,2})[/. -](\d{1,2})[/. -]((?:19|20)\d{2})\b/);
            if (numeric) {
                const first = Number(numeric[1]);
                const second = Number(numeric[2]);

                // Ambiguous numeric dates are left blank instead of guessed.
                if (first <= 12 && second <= 12) return null;

                const month = first > 12 ? second : first;
                const day = first > 12 ? first : second;

                return `${numeric[3]}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            }

            const named = value.match(/\b(\d{1,2})\s+([A-Za-z]{3,9})[,. ]+((?:19|20)\d{2})\b/);
            if (named) {
                const parsed = new Date(`${named[2]} ${named[1]}, ${named[3]}`);
                if (!Number.isNaN(parsed.getTime())) {
                    return `${parsed.getFullYear()}-${String(parsed.getMonth() + 1).padStart(2, '0')}-${String(parsed.getDate()).padStart(2, '0')}`;
                }
            }

            return null;
        }

        function extractFields(text, idType) {
            const lines = text.split(/\r?\n/).map(line => line.trim()).filter(Boolean);
            const joinedText = lines.join('\n');

            const birthdateText = labeledValue(
                lines,
                /\b(?:DATE OF BIRTH|BIRTHDATE|DATE OF BIRTH)\b/i
            );
            const sexText = labeledValue(lines, /\bSEX\b/i);

            const idPatterns = {
                'Philippine National ID': /\b\d{12}\b/,
                'SSS ID': /\b\d{2}[- ]\d{7}[- ]\d\b/,
                'PhilHealth ID': /\b\d{2}[- ]\d{9}[- ]\d\b/,
                "Driver's License": /\b[A-Z]\d{2}[- ]\d{2}[- ]\d{6}\b/i,
                'Passport': /\b[A-Z]\d{8}\b/i,
                'UMID ID': /\b\d{4}[- ]\d{7}[- ]\d\b/,
            };

            let idNumber = joinedText.match(idPatterns[idType] || /$^/)?.[0] || null;

            if (idNumber && ['SSS ID', 'PhilHealth ID', 'UMID ID'].includes(idType)) {
                const digits = idNumber.replace(/\D/g, '');
                const groups = idType === 'SSS ID' ? [2, 7, 1]
                    : idType === 'PhilHealth ID' ? [2, 9, 1] : [4, 7, 1];
                let offset = 0;
                idNumber = groups.map(size => {
                    const part = digits.slice(offset, offset + size);
                    offset += size;
                    return part;
                }).join('-');
            }

            if (!idNumber) {
                idNumber = labeledValue(lines, /\b(?:ID|PASSPORT|CRN)\s*(?:NUMBER|NO\.?)\b/i);
            }

            return {
                first_name: labeledValue(lines, /\b(?:FIRST|GIVEN)\s+NAMES?\b/i),
                middle_name: labeledValue(lines, /\bMIDDLE\s+NAME\b/i),
                last_name: labeledValue(lines, /\b(?:LAST|FAMILY)\s+NAME\b|\bSURNAME\b/i),
                suffix: labeledValue(lines, /\bSUFFIX\b/i),
                sex: sexText && /\bMALE\b/i.test(sexText) ? 'Male'
                    : sexText && /\bFEMALE\b/i.test(sexText) ? 'Female' : null,
                birthdate: toIsoDate(birthdateText),
                valid_id_number: idNumber,
                region: labeledValue(lines, /\bREGION\b/i),
                province: labeledValue(lines, /\bPROVINCE\b/i),
                municipality: labeledValue(lines, /\b(?:CITY|MUNICIPALITY)\b/i),
                barangay: labeledValue(lines, /\bBARANGAY\b/i),
            };
        }

        form.addEventListener('submit', async event => {
            event.preventDefault();

            const photo = photoInput.files[0];
            if (!photo) return;

            sendButton.disabled = true;
            sendButton.textContent = 'Reading ID...';
            statusMessage.textContent = 'Preparing OCR...';

            try {
                const result = await Tesseract.recognize(photo, 'eng', {
                    logger: progress => {
                        if (progress.status === 'recognizing text') {
                            statusMessage.textContent =
                                `Reading ID: ${Math.round(progress.progress * 100)}%`;
                        }
                    },
                });

                const fields = extractFields(result.data.text, @json($validIdType));
                const hasResult = Object.values(fields).some(value => Boolean(value));

                if (!hasResult) {
                    throw new Error('Walang malinaw na field na nabasa. Subukan ang mas malinaw na larawan.');
                }

                statusMessage.textContent = 'Sending recognized fields...';

                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ fields }),
                });

                const payload = await response.json();
                if (!response.ok) {
                    throw new Error(payload.message || 'Hindi naipadala ang OCR results.');
                }

                form.innerHTML = '';
                statusMessage.textContent = 'Naipadala na ang nabasang fields. Maaari nang suriin ng receptionist.';
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
