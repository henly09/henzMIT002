<?php
include_once('../../../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Combine first and last name
    $full_name = $_POST['last_name'] . ", " . $_POST['first_name'];

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE `student` 
                            SET STUDENTID = :id, 
                                FIRSTNAME = :full_name, 
                                AGE = :age, 
                                GENDER = :gender, 
                                CATEGORY = :category, 
                                DEPARTMENT = :department, 
                                GRADELEVEL = :grade_level, 
                                SECTION = :section 
                            WHERE STUDENTID = :id");

    // Bind parameters
    $stmt->bindParam(":id", $_POST['id']);
    $stmt->bindParam(":full_name", $full_name);
    $stmt->bindParam(":age", $_POST['age']);
    $stmt->bindParam(":gender", $_POST['gender']);
    $stmt->bindParam(":category", $_POST['category']);
    $stmt->bindParam(":department", $_POST['department']);
    $stmt->bindParam(":grade_level", $_POST['grade_level']);
    $stmt->bindParam(":section", $_POST['section']);

    // Execute the query
    $stmt->execute();

    // Respond with success
    echo json_encode([
        "success" => true,
        "message" => "Student record updated successfully!"
    ]);
}
