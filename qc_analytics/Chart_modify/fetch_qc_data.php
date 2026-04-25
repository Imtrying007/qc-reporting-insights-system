<?php
header('Content-Type: application/json');
include('../../connection.php'); // Ensure correct path

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request method"]);
    exit;
}

$filterType = $_POST['filterType'] ?? 'overall';

$data = [];

try {
    // Base SQL Query (Joining Tables)
    $query = "SELECT 
                q.name AS qc_name, 
                c.Cluster_head_name AS cluster_head, 
                pq.precision, 
                pq.recall, 
                pq.date 
              FROM project_qc_status pq
              JOIN cluster c ON pq.cluster_id = c.id
              JOIN qc q ON pq.qc_id = q.id";

    // Apply Yearly & Monthly Filters
    if ($filterType === 'year') {
        $query .= " WHERE YEAR(pq.date) = YEAR(CURDATE())";
    } elseif ($filterType === 'month') {
        $query .= " WHERE YEAR(pq.date) = YEAR(CURDATE()) AND MONTH(pq.date) = MONTH(CURDATE())";
    }

    // Debug: Print SQL Query
    file_put_contents('debug.log', date("Y-m-d H:i:s") . " - SQL Query: " . $query . PHP_EOL, FILE_APPEND);

    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Database Query Failed: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        $qc_name = $row['qc_name'];
        $cluster_head = $row['cluster_head'];
        $precision = floatval($row['precision']);
        $recall = floatval($row['recall']);

        // Determine performance category
        if ($precision >= 98 && $recall >= 98) {
            $category = "above_98";
        } elseif ($precision >= 95 && $recall >= 95) {
            $category = "between_95_98";
        } elseif ($precision >= 90 && $recall >= 90) {
            $category = "between_90_95";
        } elseif ($precision >= 85 && $recall >= 85) {
            $category = "between_85_90";
        } else {
            $category = "below_80";
        }

        // Organize Data
        if (!isset($data[$qc_name])) {
            $data[$qc_name] = [];
        }

        $found = false;
        foreach ($data[$qc_name] as &$clusterData) {
            if ($clusterData['cluster_head'] === $cluster_head) {
                $clusterData[$category] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $data[$qc_name][] = [
                "cluster_head" => $cluster_head,
                "above_98" => ($category === "above_98") ? 1 : 0,
                "between_95_98" => ($category === "between_95_98") ? 1 : 0,
                "between_90_95" => ($category === "between_90_95") ? 1 : 0,
                "between_85_90" => ($category === "between_85_90") ? 1 : 0,
                "below_80" => ($category === "below_80") ? 1 : 0
            ];
        }
    }

    // Debug: Log if data is empty
    if (empty($data)) {
        file_put_contents('debug.log', date("Y-m-d H:i:s") . " - No data available for filter: $filterType" . PHP_EOL, FILE_APPEND);
    }

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
    file_put_contents('debug.log', date("Y-m-d H:i:s") . " - Error: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
}
?>
