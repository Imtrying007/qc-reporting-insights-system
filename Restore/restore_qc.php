<?php
include('../connection.php');
session_start();

$id = $_POST['id'];
$restored_by = $_SESSION['email']; // Fetching email from session

// Fetch the deleted record from `dump_qc`
$fetch_query = "SELECT * FROM `dump_qc` WHERE `id` = '$id'";
$fetch_result = mysqli_query($conn, $fetch_query);

if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
    $row = mysqli_fetch_assoc($fetch_result);

    // Restore data into `qc`
    $restore_query = "INSERT INTO `qc` (`id`, `name`, `status`) 
                      VALUES ('{$row['id']}', '{$row['name']}', '{$row['status']}')";

    if (mysqli_query($conn, $restore_query)) {
        // Delete the record from `dump_qc`
        $delete_query = "DELETE FROM `dump_qc` WHERE `id` = '$id'";
        mysqli_query($conn, $delete_query);

        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
