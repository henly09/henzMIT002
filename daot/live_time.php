<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['student_id']) || !isset($_SESSION['department'])) {
    // If no session data exists, redirect to the login page
    header("Location: confirmation.php");
    exit();
}

$studentId = $_SESSION['student_id'];
$department = $_SESSION['department'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Live Date and Time</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-top: 50px;
        }

        .logo {
            width: 150px;
            display: block;
            margin: 0 auto 30px;
        }

        h2 {
            font-size: 2rem;
            color: #0056b3;
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-primary:hover {
            background-color: #004085;
            border-color: #003366;
        }

        .text-center {
            text-align: center;
        }

        .live-info {
            font-size: 1.2rem;
            margin-top: 20px;
            text-align: center;
        }

        .time {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="images/logo.png" alt="Assumption College of Davao Logo" class="logo">
        <h2>Welcome, <?php echo $department; ?> Department!</h2>

        <div class="live-info">
            <p><strong>Student ID:</strong> <?php echo $studentId; ?></p>
            <p><strong>Department:</strong> <?php echo $department; ?></p>
        </div>

        <div class="live-info">
            <p class="time" id="live-time">Loading live time...</p>
        </div>

        <div class="text-center">
            <a href="logout.php" class="btn btn-primary">Log Out</a>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString();
            document.getElementById('live-time').textContent = `Current Date and Time: ${timeString}`;
        }

        // Update the live time every second
        setInterval(updateTime, 1000);
    </script>
</body>

</html>
