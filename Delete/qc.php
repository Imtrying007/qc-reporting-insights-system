<?php
include('../connection.php');
session_start();

$id = $_POST['id'];
$deleted_by = $_SESSION['email']; // Get email from session

// Fetch the record before deleting
$fetch_query = "SELECT * FROM `qc` WHERE `id` = '$id'";
$fetch_result = mysqli_query($conn, $fetch_query);

if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
    $row = mysqli_fetch_assoc($fetch_result);

    // Insert into `dump_qc` before deleting
    $insert_query = "INSERT INTO `dump_qc` (`id`, `name`, `status`, `Del_person_id`) 
                     VALUES ('{$row['id']}', '{$row['name']}', '{$row['status']}', '$deleted_by')";

    if (mysqli_query($conn, $insert_query)) {
        // Delete from `qc`
        $delete_query = "DELETE FROM `qc` WHERE `id` = '$id'";
        if (mysqli_query($conn, $delete_query)) {
            // Count remaining records
            $count_query = "SELECT COUNT(*) as total FROM `qc`";
            $count_result = mysqli_query($conn, $count_query);
            $count_row = mysqli_fetch_assoc($count_result);
            echo $count_row['total']; // Return remaining count
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "not_found";
}
?>
