<?php
include_once('../conn.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $stmt = $conn->prepare("SELECT MAX(id) FROM student");
        $stmt->execute();
        $data = $stmt->fetchAll();
        $pass = new stdClass();

        $pass->id = $data[0][0] + 1;
        echo json_encode($pass);
    } catch (PDOException $e) {
        echo json_encode($e);
    }
}