<?php
// Include the database connection file
include('../connection.php');

header('Content-Type: application/json');

try {
    // Update query to calculate precision and recall
    $sql = "
        UPDATE `project_qc_status` 
        SET 
            `precision` = (`total_annotations` - `incorrect_self` - `incorrect_comp` - `incorrect_others`) * 100 / `total_annotations`,
            `recall` = (`total_annotations` - `incorrect_self` - `incorrect_comp` - `incorrect_others`) * 100 / (`total_annotations` + `missed_annotations`);
    ";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database update failed: ' . $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
} finally {
    $conn->close(); // Close the database connection
}
?>
