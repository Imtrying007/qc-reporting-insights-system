<?php
include '../connection.php';

$p_id = $_POST['p_id'];
$qc_id = $_POST['qc_id'];

/*
Step fix:
Instead of qc_id < ?, we pick the immediate previous qc run.
*/
$sql = "WITH prev_run AS (
    SELECT MAX(qc_id) AS prev_qc_id
    FROM qc_notes
    WHERE qc_id < ?
      AND p_id = ?
),

current_qn AS (
    SELECT DISTINCT
        p_id,
        category_id,
        actual,
        predicted
    FROM qc_notes
    WHERE qc_id = ?
      AND p_id = ?
),

prev_qn AS (
    SELECT DISTINCT
        q.p_id,
        q.category_id,
        q.actual,
        q.predicted
    FROM qc_notes q
    JOIN prev_run pr
      ON q.qc_id = pr.prev_qc_id
    WHERE q.p_id = ?
)

SELECT
    qs.category_id,
    qs.category_name,
    qs.SPI,
    qs.CPI,
    qs.NPD,
    qs.accuracy,
    qs.Ai_grade,

    COUNT(DISTINCT c.actual, c.predicted) AS total_tuples,

    COUNT(DISTINCT p.actual, p.predicted) AS persistent_tuples

FROM qc_summary qs

LEFT JOIN current_qn c
    ON qs.p_id = c.p_id
   AND qs.category_id = c.category_id

LEFT JOIN prev_qn p
    ON p.p_id = c.p_id
   AND p.category_id = c.category_id
   AND p.actual = c.actual
   AND p.predicted = c.predicted

WHERE qs.p_id = ?
  AND qs.qc_id = ?
  AND qs.is_overall = 0

GROUP BY
    qs.category_id,
    qs.category_name,
    qs.SPI,
    qs.CPI,
    qs.NPD,
    qs.accuracy,
    qs.Ai_grade

ORDER BY qs.Ai_grade DESC";

$query_start = microtime(true);

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "sssssss",
    $qc_id, // prev_run
    $p_id,  // prev_run filter
    $qc_id, // current_qn
    $p_id,  // current_qn
    $p_id,  // prev_qn
    $p_id,  // qc_summary p_id
    $qc_id  // qc_summary qc_id
);
$stmt->execute();

$result = $stmt->get_result();

$query_end = microtime(true);
$query_time = $query_end - $query_start;

if($result && $result->num_rows > 0){
    echo "Query executed in " . $query_time . " seconds";
    echo '<table class="table table-bordered table-sm">';
    echo '<thead>
            <tr>
                <th>Category</th>
                <th>SPI</th>
                <th>CPI</th>
                <th>NPD</th>
                <th>Accuracy</th>
                <th>AI Grade</th>
                <th>Issue Persistency</th>
            </tr>
          </thead><tbody>';

    while($row = $result->fetch_assoc()){

        $total = $row['total_tuples'];
        $persistent = $row['persistent_tuples'];

        $persistency_ratio = ($total > 0) ? $persistent / $total : 0;

        echo '<tr>
                <td>'.htmlspecialchars($row['category_name']).'</td>
                <td>'.htmlspecialchars($row['SPI']).'</td>
                <td>'.htmlspecialchars($row['CPI']).'</td>
                <td>'.htmlspecialchars($row['NPD']).'</td>
                <td>'.htmlspecialchars($row['accuracy']).'</td>
                <td>'.htmlspecialchars($row['Ai_grade']).'</td>
                  <td>'
                        . htmlspecialchars($persistent) . ' / ' . htmlspecialchars($total)
                        . ' = ' . htmlspecialchars(number_format($persistency_ratio, 3)) .'</td>
              </tr>';
    }

    echo '</tbody></table>';

} else {
    echo 'No category data found.';
}

$stmt->close();
$conn->close();
?>