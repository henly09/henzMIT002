<?php
include_once('../../../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE `admin` 
                            SET id = :id,
                                username = :username, 
                                password = :password, 
                                role = :role
                            WHERE id = :id");

    // Bind parameters
    $stmt->bindParam(":username", $_POST['username']);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":role", $_POST['role']);
    $stmt->bindParam(":id", $_POST['id']);

    // Execute the query
    $stmt->execute();

    // Respond with success
    echo json_encode([
        "success" => true,
        "message" => "Staff record updated successfully!"
    ]);
}
