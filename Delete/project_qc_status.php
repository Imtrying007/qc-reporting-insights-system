<?php
include('../connection.php');
session_start(); // Start session

$id = $_POST['id'];

// Check if session email exists, otherwise return an error
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    echo "error_no_session";
    exit;
}

$email = $_SESSION["email"]; // Get deleting user's email

// Fetch the data before deleting
$fetch_query = "SELECT * FROM `project_qc_status` WHERE `id` = '$id'";
$fetch_result = mysqli_query($conn, $fetch_query);

if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
    $row = mysqli_fetch_assoc($fetch_result);

    // Manually insert all columns along with Del_person_id
    $insertDump = "INSERT INTO `dump_project_qc_status` (`id`, `project_id`, `project_name`, `cluster_id`, `qc_id`, 
        `total_annotations`, `missed_annotations`, `incorrect_self`, `incorrect_comp`, `incorrect_others`, 
        `precision`, `recall`, `url`, `time`, `date`, `status`, `Del_person_id`,`taggers`,`T_self_pres`, `T_others_pres`, `T_comp_pres`, 
    `Grade_A_Category`, `Grade_B_Category`, `Grade_C_Category`, `Grade_D_Category`, `Proj_Grade`) 
    VALUES (
        '{$row['id']}', '{$row['project_id']}', '{$row['project_name']}', '{$row['cluster_id']}', '{$row['qc_id']}',
        '{$row['total_annotations']}', '{$row['missed_annotations']}', '{$row['incorrect_self']}', 
        '{$row['incorrect_comp']}', '{$row['incorrect_others']}', '{$row['precision']}', '{$row['recall']}',
        '{$row['url']}', '{$row['time']}', '{$row['date']}', '{$row['status']}', '$email','{$row['taggers']}','{$row['T_self_pres']}', '{$row['T_others_pres']}', '{$row['T_comp_pres']}',
        '{$row['Grade_A_Category']}', '{$row['Grade_B_Category']}', '{$row['Grade_C_Category']}',
        '{$row['Grade_D_Category']}', '{$row['Proj_Grade']}'
    )";

    mysqli_query($conn, $insertDump);
}

// Proceed with deletion
mysqli_query($conn, "DELETE FROM `project_qc_status` WHERE `id` = '$id'");

// Return updated record count
echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `project_qc_status`"));
?>
