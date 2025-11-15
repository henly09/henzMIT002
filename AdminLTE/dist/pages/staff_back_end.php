<?php
include_once('../../../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT * FROM admin WHERE `username` = :username");
    $stmt->bindParam('username', $_POST['username']);
    $stmt->execute();
    if (!((int)$stmt->fetchAll())) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admin (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam('username', $_POST['username']);
        $stmt->bindParam('password', $password);
        $stmt->bindParam('role', $_POST['role']);
        $stmt->execute();
        echo TRUE;
    } else {
        echo FALSE;
    }
}
