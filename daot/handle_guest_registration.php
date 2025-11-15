<?php
include_once('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guestName'], $_POST['guestID'])) {
    $guestName = $_POST['guestName'];
    $guestID = $_POST['guestID'];

    $stmt = $conn->prepare("INSERT INTO guests (guest_id, name) VALUES (?, ?)");
    $stmt->bind_param("ss", $guestID, $guestName);

    if ($stmt->execute()) {
        echo "Guest registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
