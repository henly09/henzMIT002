<?php
include_once('conn.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $student_id = $input['student_id'] ?? '';
    $department = $input['department'] ?? '';
    $timestamp = date('Y-m-d H:i:s');

    if ($student_id && $department) {
        try {
            $sql = "INSERT INTO time_logs (student_id, department, timestamp) VALUES (:student_id, :department, :timestamp)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':department', $department);
            $stmt->bindParam(':timestamp', $timestamp);
            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Time-in/out logged successfully."]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
