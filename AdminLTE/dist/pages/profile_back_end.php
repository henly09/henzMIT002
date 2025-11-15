<?php
include_once('../../../conn.php');
if (isset($_POST['log_out'])) {
    $_SESSION['loggedin'] = FALSE;
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE admin SET username = :username, password = :password WHERE id = :id");
    $stmt->bindParam('id', $_SESSION['id']);
    $stmt->bindParam('username', $_POST['username']);
    $stmt->bindParam('password', $hash);
    $execute = $stmt->execute();
}
