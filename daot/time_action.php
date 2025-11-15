<?php
include_once('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guestID = htmlspecialchars($_POST['guestID']);
    $action = htmlspecialchars($_POST['action']);

    if (!empty($guestID) && !empty($action)) {
        try {
            // Prepare the SQL query
            $stmt = $conn->prepare("INSERT INTO guest_logs (guest_id, action) VALUES (?, ?)");

            // Bind the parameters
            $stmt->bindValue(1, $guestID, PDO::PARAM_STR);
            $stmt->bindValue(2, $action, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to the display page with query parameters
                header("Location: logged_info.php?guestID=" . urlencode($guestID) . "&action=" . urlencode($action));
                exit; // Prevent further script execution
            } else {
                echo "Error: " . $stmt->errorInfo()[2];  // Displaying detailed error
            }

            $stmt->closeCursor();  // Close the cursor to release resources
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Invalid input. Please provide all required fields.";
    }
}
?>
