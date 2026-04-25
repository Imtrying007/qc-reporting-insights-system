<?php
include('../connection.php');
session_start();

$id = $_POST['id'];
$del_person_id =$_SESSION['email'];

// Backup the record to dump_cluster before deletion
$backup_query = "INSERT INTO `dump_cluster` (`id`, `cluster`, `Cluster_head_name`, `status`, `del_person_id`) 
                 SELECT `id`, `cluster`, `Cluster_head_name`, `status`, '$del_person_id' 
                 FROM `cluster` 
                 WHERE `id`='$id'";

if (mysqli_query($conn, $backup_query)) {
    // Proceed to delete the record from the main table
    $delete_query = "DELETE FROM `cluster` WHERE `id`='$id'";
    
    if (mysqli_query($conn, $delete_query)) {
        echo "Cluster deleted successfully.";
    } else {
        echo "Error deleting record.";
    }
} else {
    echo "Error backing up record.";
}
?>
