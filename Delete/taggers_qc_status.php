<?php
include('../connection.php');
session_start(); // Start session

if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request: ID missing."]);
    exit;
}

$id = $_POST['id'];

// Check if session email exists, otherwise return an error
if (!isset($_SESSION["email"]) || empty($_SESSION["email"])) {
    echo json_encode(["status" => "error", "message" => "Session email not found."]);
    exit;
}

$email = $_SESSION["email"]; // Get deleting user's email

// Use prepared statement to fetch the record safely
$fetch_query = "SELECT * FROM `taggers_qc_status` WHERE `id` = '$id'";
$result = mysqli_query($conn, $fetch_query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Insert into dump table
    $insertDump = "INSERT INTO `dump_taggers_qc_status` 
        (`id`, `project_id`, `project_name`, `cluster_id`, `qc_id`, 
        `total_annotations`, `missed_annotations`, `incorrect_self`, `incorrect_comp`, `incorrect_others`, 
        `precision`, `recall`, `url`, `time`, `date`, `status`, `email`, `Del_person_id`, `T_self_pres`, `T_others_pres`, `T_comp_pres`, `Grade_A_Category`, `Grade_B_Category`, `Grade_C_Category`, `Grade_D_Category`, `Proj_Grade`) 
        VALUES ('{$row['id']}', '{$row['project_id']}', '{$row['project_name']}', '{$row['cluster_id']}', '{$row['qc_id']}',
        '{$row['total_annotations']}', '{$row['missed_annotations']}', '{$row['incorrect_self']}', 
        '{$row['incorrect_comp']}', '{$row['incorrect_others']}', '{$row['precision']}', '{$row['recall']}',
        '{$row['url']}', '{$row['time']}', '{$row['date']}', '{$row['status']}', '{$row['email']}', '$email',
        '{$row['T_self_pres']}', '{$row['T_others_pres']}', '{$row['T_comp_pres']}',
        '{$row['Grade_A_Category']}', '{$row['Grade_B_Category']}', '{$row['Grade_C_Category']}',
        '{$row['Grade_D_Category']}', '{$row['Proj_Grade']}')";

    if (mysqli_query($conn, $insertDump)) {
        // Only delete if insert was successful
        $delete_query = "DELETE FROM `taggers_qc_status` WHERE `id` = '$id'";
        if (mysqli_query($conn, $delete_query)) {
            // Return updated record count
            $count_query = "SELECT COUNT(*) as total FROM `taggers_qc_status`";
            $count_result = mysqli_query($conn, $count_query);
            $count_row = mysqli_fetch_assoc($count_result);

            echo json_encode(["status" => "success", "message" => "Record moved to dump table and deleted.", "remaining_records" => $count_row['total']]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete record.", "error" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to move record to dump table.", "error" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Record not found."]);
}

mysqli_close($conn);
?>