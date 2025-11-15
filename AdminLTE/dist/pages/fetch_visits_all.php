<?php
include_once('../../../conn.php');
try {
    $stmt = $conn->prepare("SELECT `LOGDATE`, COUNT(*) AS visit_count FROM attendance GROUP BY `LOGDATE` ORDER BY `LOGDATE` ASC");
    $stmt->execute();

    $data = [];
    while ($row = $stmt->fetch()) {
        $data[] = [
            'date' => $row['LOGDATE'],
            'visits' => (int)$row['visit_count']
        ];
    }

    if (empty($data)) {
        echo "No data found";
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
