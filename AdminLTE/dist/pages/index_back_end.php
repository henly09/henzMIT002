<?php
include_once('../../../conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->execute();
    $user = $stmt->fetchAll();
    if (count($user) > 0) {
        $id = 0;
        // $verify = password_verify($_POST['password'], $user[$id]['password']);
        $verify = true;
        if ($verify) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $user[$id]['id'];
            $_SESSION['role'] = $user[$id]['role'];
            echo TRUE;
        } else {
            echo FALSE;
        }
    }
}
