<?php
// Include the database connection
include('../connection.php');

// Check if the POST request is valid
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "updateQCStatus") {
    // SQL Query to update precision and recall
    $sql = "UPDATE `project_qc_status` 
            SET 
                `precision` = ROUND((`total_annotations` - `incorrect_self` - `incorrect_comp` - `incorrect_others`) * 100.0 / `total_annotations`, 2),
                `recall` = ROUND((`total_annotations` - `incorrect_self` - `incorrect_comp` - `incorrect_others`) * 100.0 / (`total_annotations` + `missed_annotations`), 2)";

    // Execute query and return the result
    if ($conn->query($sql) === TRUE) {
        echo "QC status updated successfully!";
    } else {
        echo "Error updating QC status: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
