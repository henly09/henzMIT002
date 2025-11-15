<?php
include_once('../../../conn.php');

$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];
$orderColumn = $_POST['order'][0]['column'];
$orderDir = $_POST['order'][0]['dir'];

$columns = ['attendance.STUDENTID', 'student.FIRSTNAME', 'student.SECTION','attendance.LIBRARY', 'attendance.TIMEIN', 'attendance.TIMEOUT', 'attendance.LOGDATE', 'attendance.STATUS'];

$timeframe = $_GET['timeframe'] ?? null;
$selectedLibrary = $_POST['library'] ?? null;

if ($selectedLibrary == 'admin') {
    $selectedLibrary = '';
}

switch ($_SESSION['role']) {
    case 'college':
        $selectedLibrary = 'College';
        break;
    case 'senior_high':
        $selectedLibrary = 'SHS';
        break;
    case 'junior_high':
        $selectedLibrary = 'JHS';
        break;
    case 'elementary':
        $selectedLibrary = 'Elementary';
        break;
    case 'superadmin':
        $selectedLibrary = '';
        break;
}

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;

// timeframe filter
$dateFilter = '';
switch ($timeframe) {
    case 'week':
        $dateFilter = "AND YEARWEEK(attendance.LOGDATE, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'month':
        $dateFilter = "AND YEAR(attendance.LOGDATE) = YEAR(CURDATE()) AND MONTH(attendance.LOGDATE) = MONTH(CURDATE())";
        break;
    case 'year':
        $dateFilter = "AND YEAR(attendance.LOGDATE) = YEAR(CURDATE())";
        break;
}

// library filter
$libraryFilter = '';
if (!empty($selectedLibrary)) {
    $libraryFilter = "AND attendance.LIBRARY = :library";
}

$query = "
    SELECT
        attendance.STUDENTID,
        student.FIRSTNAME,
        student.SECTION,
        attendance.LIBRARY,
        attendance.TIMEIN,
        attendance.TIMEOUT,
        attendance.LOGDATE,
        attendance.STATUS
    FROM attendance
    INNER JOIN student ON attendance.STUDENTID = student.STUDENTID
    WHERE attendance.STUDENTID <> ''
    $dateFilter
    $libraryFilter
";

if (!empty($searchValue)) {
    $query .= " AND (
        attendance.STUDENTID LIKE :search OR
        student.FIRSTNAME LIKE :search OR
        attendance.LIBRARY LIKE :search
    )";
}

if (!empty($startDate) && !empty($endDate)) {
    $query .= " AND attendance.LOGDATE BETWEEN :startDate AND :endDate";
}

$query .= " ORDER BY " . $columns[$orderColumn] . " " . $orderDir;

if ($length != -1) {
    $query .= " LIMIT :start, :length";
}

$stmt = $conn->prepare($query);

if (!empty($selectedLibrary)) {
    $stmt->bindValue(':library', $selectedLibrary, PDO::PARAM_STR);
}
if (!empty($searchValue)) {
    $stmt->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
}
if (!empty($startDate) && !empty($endDate)) {
    $stmt->bindValue(':startDate', $startDate, PDO::PARAM_STR);
    $stmt->bindValue(':endDate', $endDate, PDO::PARAM_STR);
}
if ($length != -1) {
    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
    $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// total records
$totalQuery = "
    SELECT COUNT(*) 
    FROM attendance 
    INNER JOIN student ON attendance.STUDENTID = student.STUDENTID 
    WHERE attendance.STUDENTID <> ''
";
$totalRecords = $conn->query($totalQuery)->fetchColumn();

// total filtered
$totalFilteredQuery = "
    SELECT COUNT(*) FROM (
        SELECT attendance.STUDENTID
        FROM attendance
        INNER JOIN student ON attendance.STUDENTID = student.STUDENTID
        WHERE attendance.STUDENTID <> ''
        $dateFilter
        $libraryFilter
";

if (!empty($searchValue)) {
    $totalFilteredQuery .= " AND (
        attendance.STUDENTID LIKE :search OR
        student.FIRSTNAME LIKE :search OR
        attendance.LIBRARY LIKE :search
    )";
}
if (!empty($startDate) && !empty($endDate)) {
    $totalFilteredQuery .= " AND attendance.LOGDATE BETWEEN :startDate AND :endDate";
}

$totalFilteredQuery .= " ) AS subquery";

$totalFilteredStmt = $conn->prepare($totalFilteredQuery);

if (!empty($selectedLibrary)) {
    $totalFilteredStmt->bindValue(':library', $selectedLibrary, PDO::PARAM_STR);
}
if (!empty($searchValue)) {
    $totalFilteredStmt->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
}
if (!empty($startDate) && !empty($endDate)) {
    $totalFilteredStmt->bindValue(':startDate', $startDate, PDO::PARAM_STR);
    $totalFilteredStmt->bindValue(':endDate', $endDate, PDO::PARAM_STR);
}

$totalFilteredStmt->execute();
$totalFilteredRecords = $totalFilteredStmt->fetchColumn();

$response = [
    'draw' => intval($draw),
    'recordsTotal' => intval($totalRecords),
    'recordsFiltered' => intval($totalFilteredRecords),
    'data' => $data
];

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
exit;
