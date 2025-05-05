<!DOCTYPE html>
<html>

<head>
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
        #reader {
            width: 100%;
            max-width: 400px;
            height: auto;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        #qr-file-input {
            display: block;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">QR Code Scanner</h2>

    <div id="reader"></div>

    <hr style="margin: 40px 0;">

    <h3 style="text-align: center;">Or Upload QR Code Image</h3>
    <input type="file" id="qr-file-input" accept="image/*" />

    <p style="text-align: center;">
        Scanned Data: <span id="scanned-result" style="font-weight: bold;"></span>
    </p>

    <script>
        const qrCodeRegionId = "reader";
        const html5QrCode = new Html5Qrcode(qrCodeRegionId);

        function redirectToBackend(decodedText) {
            const url = `/validate-qrcode?qr_data=${encodeURIComponent(decodedText)}`;
            window.location.href = url;
        }

        function onScanSuccess(decodedText, decodedResult) {
            redirectToBackend(decodedText);
        }

        Html5Qrcode.getCameras().then(devices => {
            if (devices.length) {
                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: {
                            width: 300,
                            height: 300
                        }
                    },
                    onScanSuccess
                );
            }
        });

        document.getElementById('qr-file-input').addEventListener('change', function(e) {
            if (e.target.files.length === 0) return;

            const file = e.target.files[0];

            html5QrCode.stop().then(() => {
                return html5QrCode.scanFile(file, true);
            }).then(decodedText => {
                document.getElementById('scanned-result').innerText = decodedText;
                redirectToBackend(decodedText); // ✅ Redirect after successful file scan
            }).catch(err => {
                alert("QR Code not found in image or failed to stop camera.");
                console.error(err);
            });
        });
    </script>
</body>

</html>
