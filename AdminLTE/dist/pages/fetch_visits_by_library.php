<?php
include_once('../../../conn.php');
try {
    // Adjust SQL to include `Date` along with `Program` and group by both
    $stmt = $conn->prepare("SELECT `LIBRARY`, `LOGDATE`, COUNT(*) AS visit_count 
                            FROM attendance 
                            GROUP BY `LIBRARY`, `LOGDATE` 
                            ORDER BY `LIBRARY`, `LOGDATE` ASC");
    $stmt->execute();

    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['LIBRARY'] == 'admin' || $row['LIBRARY'] == 'college') {
            continue;
        }
        $data[] = [
            'LIBRARY' => $row['LIBRARY'],
            'date' => $row['LOGDATE'],
            'visits' => (int)$row['visit_count']
        ];
    }

    if (empty($data)) {
        echo json_encode(["message" => "No data found"]);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}