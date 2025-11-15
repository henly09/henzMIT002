<!DOCTYPE html>
<html lang="en">

<head>
    <title>Confirmation Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9fafc;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333333;
        }

        .container {
            max-width: 800px;
            margin: 60px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
        }

        .header img {
            width: 150px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 1.8rem;
            margin: 0;
            color: #004b8d;
            font-weight: 600;
        }

        .content {
            padding: 40px;
        }

        .content h5 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #004b8d;
            margin-bottom: 20px;
        }

        .info-card {
            background: #f8fafc;
            border: 1px solid #d1e7f5;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-card p {
            font-size: 1.1rem;
            margin: 5px 0;
        }

        .info-card strong {
            color: #0056b3;
        }

        .buttons {
            text-align: center;
            margin-top: 30px;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #004080;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .btn-secondary:hover {
            background-color: #495057;
        }

        #logoutMessage {
            margin-top: 20px;
            display: none;
        }

        .footer {
            background-color: #f1f3f5;
            color: #6c757d;
            text-align: center;
            padding: 15px 0;
            font-size: 0.9rem;
        }

        #currentDateTime {
            font-weight: bold;
            font-size: 1rem;
            color: #333333;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="images/logo.png" alt="Assumption College of Davao Logo">
            <h1>Assumption College of Davao</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h5>Student Confirmation Details</h5>
            <div class="info-card">
                <p><strong>Student ID:</strong> <?php echo isset($_GET['studentId']) ? htmlspecialchars($_GET['studentId']) : 'Not Provided'; ?></p>
                <p><strong>Department:</strong> <?php echo isset($_GET['department']) ? htmlspecialchars($_GET['department']) : 'Not Provided'; ?></p>
                <p><strong>Current Date and Time:</strong> <span id="currentDateTime"></span></p>
            </div>

            <div id="logoutMessage" class="alert alert-success">You have successfully logged out.</div>

            <!-- Buttons -->
            <div class="buttons">
                <button id="logoutButton" class="btn btn-primary me-3" onclick="logout()">Log Out</button>
                <a href="index.php" class="btn btn-secondary">Home</a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; 2025 Assumption College of Davao. All Rights Reserved.
        </div>
    </div>

    <script>
        // Update live date and time
        function updateDateTime() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleString('en-US', options);
        }

        setInterval(updateDateTime, 1000); // Update every second
        updateDateTime(); // Initial call

        // Log Out functionality
        function logout() {
            const logoutMessage = document.getElementById('logoutMessage');
            logoutMessage.style.display = 'block'; // Show message
            const logoutButton = document.getElementById('logoutButton');
            logoutButton.disabled = true; // Disable button
            logoutButton.textContent = "Logged Out"; // Update button text
        }
    </script>
</body>

</html>
