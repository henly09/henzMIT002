<?php
include_once('../../../conn.php');

$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];
$orderColumn = $_POST['order'][0]['column'];
$orderDir = $_POST['order'][0]['dir'];

$columns = ['id' ,'username', 'password', 'role'];

// Explicitly cast STUDENTID to a string
$query = "SELECT id, username, `password`, `role` FROM `admin` WHERE `role` != 'superadmin'";

if (!empty($searchValue)) {
    $query .= " AND (username LIKE :search OR `role` LIKE :search)";
}

$query .= " ORDER BY " . $columns[$orderColumn] . " " . $orderDir;
$query .= " LIMIT :start, :length";

$stmt = $conn->prepare($query);

if (!empty($searchValue)) {
    $stmt->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($data as &$row) {
    // Process each row if needed
}

// Total records
$totalQuery = "SELECT COUNT(*) FROM `admin` WHERE `role` != 'superadmin'";
$totalRecords = $conn->query($totalQuery)->fetchColumn();

// Total filtered records
$totalFilteredQuery = "SELECT COUNT(*) FROM `admin` WHERE `role` != 'superadmin'";
if (!empty($searchValue)) {
    $totalFilteredQuery .= " AND (username LIKE :search OR role LIKE :search)";
}
$totalFilteredStmt = $conn->prepare($totalFilteredQuery);
if (!empty($searchValue)) {
    $totalFilteredStmt->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
}
$totalFilteredStmt->execute();
$totalFilteredRecords = $totalFilteredStmt->fetchColumn();

// Response
$response = [
    'draw' => intval($draw),
    'recordsTotal' => intval($totalRecords),
    'recordsFiltered' => intval($totalFilteredRecords),
    'data' => $data
];

echo json_encode($response);
?>
