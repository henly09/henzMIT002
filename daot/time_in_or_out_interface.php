<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['guestID'])) {
    $action = $_POST['action']; // "IN" or "OUT"
    $guestID = $_POST['guestID'];

    $stmt = $conn->prepare("INSERT INTO guest_logs (guest_id, action) VALUES (?, ?)");
    $stmt->bind_param("ss", $guestID, $action);

    if ($stmt->execute()) {
        echo "Guest $action successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
