<?php
include_once('../../../conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT * FROM `student` WHERE `STUDENTID` = :id");
    $stmt->bindParam(":id", $_POST["id"]);
    $stmt->execute();

    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        
        $fullname = explode(", ", $row['FIRSTNAME']);

        
        $data = [
            'id' => $row['STUDENTID'], 
            'first_name' => $fullname[1] ?? '', 
            'last_name' => $fullname[0] ?? '',
            'age' => $row['AGE'],
            'gender' => $row['GENDER'],
            'category' => $row['CATEGORY'],
            'department' => $row['DEPARTMENT'],
            'grade_level' => $row['GRADELEVEL'],
            'section' => $row['SECTION'],
        ];
    } else {
        $data = ['error' => 'No student found with the given ID.'];
    }

    
    header('Content-Type: application/json');
    echo json_encode($data);
}
