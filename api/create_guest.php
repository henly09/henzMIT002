<?php
include_once('../conn.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $stmt = $conn->prepare("INSERT INTO student (STUDENTID, FIRSTNAME) 
        VALUES (:id, 'Guest')");
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();

        // Insert guest activity into description table
        $activity = isset($_POST['activity']) && !empty(trim($_POST['activity'])) ? $_POST['activity'] : 'N/A';
        $student_name = 'Guest';
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $stmt_desc = $conn->prepare("INSERT INTO description (stud_id, activity, student_name, created_at, updated_at) 
        VALUES (:stud_id, :activity, :student_name, :created_at, :updated_at)");
        $stmt_desc->bindParam(':stud_id', $_POST['id']);
        $stmt_desc->bindParam(':activity', $activity);
        $stmt_desc->bindParam(':student_name', $student_name);
        $stmt_desc->bindParam(':created_at', $created_at);
        $stmt_desc->bindParam(':updated_at', $updated_at);
        $stmt_desc->execute();

        $pass = new stdClass();
        $pass->status = TRUE;
        $pass->id = $_POST['id'];
        $pass->message = "Guest created successfully";
        echo json_encode($pass);
    } catch (PDOException $e) {
        echo json_encode($e);
    }
}