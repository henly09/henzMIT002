<?php
include_once('../conn.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    switch ($_SESSION['role']) {
        case "college":
            $library = "College";
            break;
        case "senior_high":
            $library = "SHS";
            break;
        case "junior_high":
            $library = "JHS";
            break;
        case "elementary":
            $library = "Elementary";
            break;
        default:
            $library = "admin";
            break;
    }

    $pass = new stdClass();
    $stmt = $conn->prepare("SELECT * FROM student WHERE STUDENTID = :id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if (count($data) != 0) {
        $getDate = date('Y-m-d');
        $getTime = date('h:i:sa');
        $stmt = $conn->prepare("SELECT * FROM attendance WHERE LIBRARY = :library AND STUDENTID = :id AND LOGDATE = :date ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':library', $library);
        $stmt->bindParam(':id', $data[0]['STUDENTID']);
        $stmt->bindParam(':date', $getDate);
        $stmt->execute();
        $status = $stmt->fetchAll();
        $s = 0;

        if (count($status) == 0 || $status[0]['STATUS'] == 1) {
            try {
                $stmt = $conn->prepare("INSERT INTO attendance (STUDENTID, LIBRARY, TIMEIN, LOGDATE, STATUS) 
                VALUES (:id, :library, :time, :date, :status)");
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->bindParam(':library', $library);
                $stmt->bindParam(':time', $getTime);
                $stmt->bindParam(':date', $getDate);
                $stmt->bindParam(':status', $s);
                $stmt->execute();

                // Insert into description table for activity tracking
                $activity = isset($_POST['activity']) && !empty(trim($_POST['activity'])) ? $_POST['activity'] : 'N/A';
                $student_name = $data[0]['FIRSTNAME'];
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

                $pass->message = "Time in successful!";
                $pass->user = $data;
                $pass->status = TRUE;
                $pass->time = TRUE;
                echo json_encode($pass);
            } catch (PDOException $e) {
                $pass->message = "Time in failed!";
                $pass->status = FALSE;
                echo json_encode($pass);
            }
        } else if ($status[0]['STATUS'] == 0) {
            try {
                $stmt = $conn->prepare("UPDATE attendance SET TIMEOUT = :time, STATUS = 1 WHERE LIBRARY = :library AND STUDENTID = :id ORDER BY id DESC LIMIT 1");
                $stmt->bindParam(':library', $library);
                $stmt->bindParam(':time', $getTime);
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->execute();

                // Update description table for timeout
                $activity = isset($_POST['activity']) && !empty(trim($_POST['activity'])) ? $_POST['activity'] : 'N/A';
                $timeout_activity = $activity . ' - Timeout';
                $student_name = $data[0]['FIRSTNAME'];
                $updated_at = date('Y-m-d H:i:s');

                $stmt_desc = $conn->prepare("INSERT INTO description (stud_id, activity, student_name, created_at, updated_at) 
                VALUES (:stud_id, :activity, :student_name, :created_at, :updated_at)");
                $stmt_desc->bindParam(':stud_id', $_POST['id']);
                $stmt_desc->bindParam(':activity', $timeout_activity);
                $stmt_desc->bindParam(':student_name', $student_name);
                $stmt_desc->bindParam(':created_at', $updated_at);
                $stmt_desc->bindParam(':updated_at', $updated_at);
                $stmt_desc->execute();

                $pass->message = "Time out successful!";
                $pass->user = $data;
                $pass->status = TRUE;
                $pass->time = FALSE;
                echo json_encode($pass);
            } catch (PDOException $e) {
                $pass->message = "Time out failed!";
                $pass->status = FALSE;
                echo json_encode($pass);
            }
        } else {
            $pass->message = "Time failed!";
            $pass->status = FALSE;
            echo json_encode($pass);
        }
    } else {
        $pass->message = "ID not found!";
        $pass->status = FALSE;
        echo json_encode($pass);
    }
}
