<?php
include_once('../../../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];

  // Prepared statement
  $stmt = $conn->prepare("SELECT * FROM admin WHERE TRIM(`id`) = :id");
  $stmt->bindParam('id', $id, PDO::PARAM_STR);

  // Enable error mode for debugging
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt->execute();

  // Fetch the result
  $r = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($r) {
    echo json_encode($r);
  } else {
    echo json_encode(['Staff ID not found.' => $id]);
  }
}
