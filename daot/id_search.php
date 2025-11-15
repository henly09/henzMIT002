<?php
    $idInput = false;
    $user['ID'] = "";
    $user['First Name'] = "";
    $user['Last Name'] = "";
    $user['Program'] = "";
    $user['Year Level'] = "";
    if(isset($_POST['idInput'])) {
        $id = (int)$_POST['idInput'];
        $stmt = $conn->prepare("SELECT * FROM students WHERE ID = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $user = $stmt->fetchAll();
        if(count($user) == 0) {
            $idInput = false;
            $user['ID'] = "";
            $user['First Name'] = "";
            $user['Last Name'] = "";
            $user['Program'] = "";
            $user['Year Level'] = "";
        } else {
            $idInput = true;
            foreach($user as $user) {
            }
        }
    } else {
        $idInput = false;
    }
?>