<?php
include_once('../../../conn.php');

$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];
$orderColumn = $_POST['order'][0]['column'];
$orderDir = $_POST['order'][0]['dir'];

$columns = ['FIRSTNAME', 'visit_count'];

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
}

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;

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
    default:
        $dateFilter = '';
}

$libraryFilter = '';
switch ($selectedLibrary) {
    case 'College':
        $libraryFilter = "AND attendance.LIBRARY = 'College'";
        break;
    case 'SHS':
        $libraryFilter = "AND attendance.LIBRARY = 'SHS'";
        break;
    case 'JHS':
        $libraryFilter = "AND attendance.LIBRARY = 'JHS'";
        break;
    case 'Elementary':
        $libraryFilter = "AND attendance.LIBRARY = 'Elementary'";
        break;
    default:
        $libraryFilter = '';
        break;
}

$query = "
    SELECT
        student.FIRSTNAME,
        COUNT(*) AS visit_count
    FROM 
        attendance
    INNER JOIN 
        student 
    ON 
        attendance.STUDENTID = student.STUDENTID
    WHERE 
        attendance.STUDENTID <> ''
        $dateFilter
        $libraryFilter
";

if (!empty($searchValue)) {
    $query .= " AND student.FIRSTNAME LIKE :search";
}

if (!empty($startDate) && !empty($endDate)) {
    $query .= " AND attendance.LOGDATE BETWEEN :startDate AND :endDate";
}

if ($length != -1) {
    $query .= " GROUP BY attendance.STUDENTID, student.FIRSTNAME";
    $query .= " ORDER BY " . $columns[$orderColumn] . " " . $orderDir;
    $query .= " LIMIT :start, :length";
} else {
    $query .= " GROUP BY attendance.STUDENTID, student.FIRSTNAME";
    $query .= " ORDER BY " . $columns[$orderColumn] . " " . $orderDir;
}

$stmt = $conn->prepare($query);

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

$totalQuery = "
    SELECT COUNT(DISTINCT attendance.STUDENTID)
    FROM attendance
    INNER JOIN student 
    ON attendance.STUDENTID = student.STUDENTID
    WHERE attendance.LIBRARY = 'College' AND attendance.STUDENTID <> ''
";
$totalRecords = $conn->query($totalQuery)->fetchColumn();

$totalFilteredQuery = "
    SELECT COUNT(*) FROM (
        SELECT attendance.STUDENTID
        FROM attendance
        INNER JOIN student 
        ON attendance.STUDENTID = student.STUDENTID
        WHERE attendance.LIBRARY = 'College' AND attendance.STUDENTID <> ''
";

if (!empty($searchValue)) {
    $totalFilteredQuery .= " AND student.FIRSTNAME LIKE :search";
}

$totalFilteredQuery .= " GROUP BY attendance.STUDENTID ) AS subquery";

$totalFilteredStmt = $conn->prepare($totalFilteredQuery);
if (!empty($searchValue)) {
    $totalFilteredStmt->bindValue(':search', '%' . $searchValue . '%', PDO::PARAM_STR);
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
