<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f9fd;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container-custom {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 40px;
            max-width: 800px;
            margin-top: 50px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 150px;
            height: auto;
            margin-bottom: 15px;
        }

        .header span {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .scanner-container {
            text-align: center;
            margin-bottom: 30px;
        }

        video {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 10px;
            border: 2px solid #0d6efd;
        }

        .instructions {
            font-size: 1.2rem;
            color: #0d6efd;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #666;
        }

        /* Button styles */
        .btn-custom {
            background-color: #0d6efd;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #0a58ca;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex justify-content-center py-5">
        <div class="container-custom">
            <div class="header">
                <!-- Logo -->
                <img src="images/logo.png" alt="Assumption College of Davao Logo">
                <span>Barcode Scanner</span>
            </div>

            <div class="scanner-container">
                <!-- Video feed for the barcode scanner -->
                <video id="scanner" autoplay></video>
            </div>

            <div class="instructions">
                <p>Point your camera at a barcode to scan it. The camera feed will automatically detect and decode the barcode.</p>
                <button class="btn-custom" onclick="window.location.href='index.php'">Go Back</button>
            </div>
        </div>
    </div>

    <footer class="footer">
        &copy; 2025 Assumption College of Davao. All Rights Reserved.
    </footer>

    <script>
        const video = document.getElementById('scanner');

        // Start video stream for barcode scanner
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(function (stream) {
                    video.srcObject = stream;
                })
                .catch(function (error) {
                    alert("Error accessing camera: " + error);
                });
        }
    </script>
</body>

</html>
