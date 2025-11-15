<?php
// Get data from query string
$guestID = htmlspecialchars($_GET['guestID'] ?? '');
$action = htmlspecialchars($_GET['action'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Log Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            color: #333; /* Dark text color for readability */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff; /* White background for the content box */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 20px;
            text-align: center;
        }
        h1 {
            text-align: center;
            color: #0056b3; /* Blue heading */
            margin-top: 10px;
        }
        p {
            font-size: 1.1em;
            line-height: 1.5;
            margin: 10px 0;
        }
        .logo {
            width: 100px; /* Adjust the size as needed */
            height: auto;
            margin-bottom: 10px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        button {
            background-color: #0056b3; /* Blue button */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #003d80; /* Darker blue on hover */
        }
        a {
            text-decoration: none;
            color: #0056b3;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Function to update the live time and date
        function updateDateTime() {
            const now = new Date();
            const formattedTime = now.toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true,
            });
            document.getElementById('live-time').textContent = formattedTime;
        }

        // Update the time every second
        setInterval(updateDateTime, 1000);

        // Initialize the time on page load
        document.addEventListener('DOMContentLoaded', updateDateTime);
    </script>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <img src="images/logo.png" alt="Assumption College of Davao Logo" class="logo">
        
        <?php if (!empty($guestID)): ?>
            <h1>Welcome, Guest!</h1>
            <p><strong>Guest ID:</strong> <?= $guestID ?></p>
            <p><strong>Action:</strong> <?= $action ?></p>
            <p><strong>Current Date and Time:</strong> <span id="live-time"></span></p>
        <?php else: ?>
            <h1>Error</h1>
            <p>Missing Guest ID or Action!</p>
        <?php endif; ?>

        <div class="button-container">
            <!-- Only the "Log Out" button remains -->
            <form method="POST" action="time_action.php" style="display: inline;">
                <input type="hidden" name="guestID" value="<?= htmlspecialchars($guestID) ?>">
                <input type="hidden" name="action" value="Log Out">
                <button type="submit">Log Out</button>
            </form>
        </div>

        <div class="button-container">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
