<?php
include_once('../../../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("SELECT * FROM student WHERE `STUDENTID` = :id");
    $stmt->bindParam('id', $_POST['id']);
    $stmt->execute();
    if (!((int)$stmt->fetchAll())) {
        $fullname = $_POST['last_name'] . ", " . $_POST['first_name'];
        $stmt = $conn->prepare("INSERT INTO student (STUDENTID, FIRSTNAME, AGE, GENDER, CATEGORY, DEPARTMENT, GRADELEVEL, SECTION) VALUES (:id, :full_name, :age, :gender, :category, :department, :grade_level, :section)");
        $stmt->bindParam('id', $_POST['id']);
        $stmt->bindParam('full_name', $fullname);
        $stmt->bindParam('age', $_POST['age']);
        $stmt->bindParam('gender', $_POST['gender']);
        $stmt->bindParam('category', $_POST['category']);
        $stmt->bindParam('department', $_POST['department']);
        $stmt->bindParam('grade_level', $_POST['grade_level']);
        $stmt->bindParam('section', $_POST['section']);
        $stmt->execute();
        echo TRUE;
    } else {
        echo FALSE;
    }
}
