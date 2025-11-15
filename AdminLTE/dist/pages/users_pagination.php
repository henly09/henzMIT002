<?php
include_once('../../../conn.php');

$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];
$orderColumn = $_POST['order'][0]['column'];
$orderDir = $_POST['order'][0]['dir'];

$columns = ['STUDENTID', 'FIRSTNAME', 'AGE', 'GENDER', 'CATEGORY', 'DEPARTMENT', 'GRADELEVEL', 'SECTION', 'image', 'id'];

// Explicitly cast STUDENTID to a string
$query = "SELECT id, CAST(STUDENTID AS CHAR) AS STUDENTID, FIRSTNAME, AGE, GENDER, CATEGORY, DEPARTMENT, GRADELEVEL, SECTION, image FROM student";

if (!empty($searchValue)) {
    $query .= " WHERE FIRSTNAME LIKE :search OR STUDENTID LIKE :search";
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

// Format FIRSTNAME and LASTNAME
foreach ($data as &$row) {
    $row['STUDENTID'] = strval($row['STUDENTID']); // Force string conversion
    $nameParts = explode(',', $row['FIRSTNAME']);
    $row['FIRSTNAME'] = isset($nameParts[1]) ? $nameParts[1] : '';
    $row['LASTNAME'] = isset($nameParts[0]) ? $nameParts[0] : '';
}

// Total records
$totalQuery = "SELECT COUNT(*) FROM student";
$totalRecords = $conn->query($totalQuery)->fetchColumn();

// Total filtered records
$totalFilteredQuery = "SELECT COUNT(*) FROM student";
if (!empty($searchValue)) {
    $totalFilteredQuery .= " WHERE FIRSTNAME LIKE :search OR STUDENTID LIKE :search";
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
