<?php
include('../connection.php');
session_start();

header('Content-Type: application/json'); // Set response type to JSON

$id = isset($_POST['id']) ? intval($_POST['id']) : 0; // Validate and sanitize input

if ($id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid project ID."]);
    exit;
}

// Fetch the deleted record
$fetch_query = "SELECT `owner_name`, `project_name`, `cluster`, `date`, `time`, `status` ,`mode` 
                FROM `dump_add_project` WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $fetch_query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && $row = mysqli_fetch_assoc($result)) {
    // Insert into add_project (excluding ID to avoid duplicates)
    $restoreQuery = "INSERT INTO `add_project` (`owner_name`, `project_name`, `cluster`, `date`, `time`, `status` ,`mode`) 
                     VALUES (?, ?, ?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($conn, $restoreQuery);
    mysqli_stmt_bind_param($stmt, "sssssss", 
        $row['owner_name'], $row['project_name'], $row['cluster'], 
        $row['date'], $row['time'], $row['status'],$row['mode']
    );

    if (mysqli_stmt_execute($stmt)) {
        // Delete from dump_add_project
        $deleteQuery = "DELETE FROM `dump_add_project` WHERE `id` = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "success", "message" => "Project restored successfully!", "id" => $id]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to restore the project."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Record not found."]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
