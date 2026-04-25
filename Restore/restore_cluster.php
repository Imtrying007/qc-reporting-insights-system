<?php
session_start();
include('../connection.php');

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access!"]);
    exit;
}

$id = $_POST['id'];

// Fetch cluster details from `dump_cluster`
$sql = "SELECT * FROM `dump_cluster` WHERE `id` = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    // Restore cluster data to `cluster` table
    $restore_sql = "INSERT INTO `cluster` (`id`, `cluster`, `Cluster_head_name`, `status`)
                    VALUES ('{$data['id']}', '{$data['cluster']}', '{$data['Cluster_head_name']}', '{$data['status']}')";
    
    if (mysqli_query($conn, $restore_sql)) {
        // Delete from `dump_cluster` after restoring
        $delete_sql = "DELETE FROM `dump_cluster` WHERE `id` = '$id'";
        mysqli_query($conn, $delete_sql);

        echo json_encode(["status" => "success", "message" => "Cluster restored successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to restore cluster."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Cluster not found in trash."]);
}
?>
