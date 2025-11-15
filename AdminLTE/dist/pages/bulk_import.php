<?php
include_once('../../../conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $filename = $_FILES["file"]["tmp_name"];

  if ($_FILES["file"]["size"] > 0) {
    $file = fopen($filename, "r");

    while (($column = fgetcsv($file, 10000, ",")) !== False) {
      $sql = "INSERT INTO `student`
      (`STUDENTID`, `FIRSTNAME`, `AGE`, `GENDER`, `CATEGORY`, `DEPARTMENT`, `GRADELEVEL`, `SECTION`)
      VALUES ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "')
      ON DUPLICATE KEY UPDATE
        `FIRSTNAME`=VALUES(`FIRSTNAME`),
        `AGE`=VALUES(`AGE`),
        `GENDER`=VALUES(`GENDER`),
        `CATEGORY`=VALUES(`CATEGORY`),
        `DEPARTMENT`=VALUES(`DEPARTMENT`),
        `GRADELEVEL`=VALUES(`GRADELEVEL`),
        `SECTION`=VALUES(`SECTION`)";
      $res = $conn->query($sql);
    }
    if (!empty($res)) {
      echo json_encode(array("status" => "success", "message" => "Data Imported Successfully"));
    } else {
      echo json_encode(array("status" => "error", "message" => "Error in Importing Data"));
    }
  }
}
