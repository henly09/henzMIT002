<?php
include_once('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $guestID = htmlspecialchars($_POST['guestID'] ?? '');

    if (!empty($username) && !empty($password)) {
        try {
            // Prepare the SQL query
            $stmt = $conn->prepare("SELECT * FROM users WHERE (username = :username OR email = :username)");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            // Execute the query
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                echo "<h1>Welcome, " . htmlspecialchars($user['name']) . "!</h1>";
                echo "<p>You logged in as Guest ID: $guestID</p>";
                echo '<a href="dashboard.php">Go to Dashboard</a>';
            } else {
                // Invalid credentials
                echo "<h1>Login Failed</h1>";
                echo "<p>Invalid username or password. Please try again.</p>";
                echo '<a href="logged_info.php">Back</a>';
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "<h1>Error: Missing data</h1>";
        echo '<a href="logged_info.php">Back</a>';
    }
}
?>
    