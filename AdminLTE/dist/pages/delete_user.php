<?php
include_once('../../../conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conn->prepare("DELETE FROM `student` WHERE `STUDENTID` = :id");
  $stmt->bindParam(":id", $_POST["id"]);
  $stmt->execute();

  echo json_encode([
    "success" => true
  ]);
}
