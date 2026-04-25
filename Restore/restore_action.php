<?php
include('../connection.php');
session_start();

$id = $_POST['id'];

if (!$id) {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
    exit;
}

// Fetch the deleted record
$fetch_query = "SELECT * FROM `dump_project_qc_status` WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $fetch_query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Restore data into project_qc_status
    $restoreQuery = "INSERT INTO `project_qc_status` (`project_id`, `project_name`, `cluster_id`, `qc_id`, 
        `total_annotations`, `missed_annotations`, `incorrect_self`, `incorrect_comp`, `incorrect_others`, 
        `precision`, `recall`, `url`, `time`, `date`, `status`,`taggers`,`T_self_pres`, `T_others_pres`, `T_comp_pres`, `Grade_A_Category`, `Grade_B_Category`, `Grade_C_Category`, `Grade_D_Category`, `Proj_Grade`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conn, $restoreQuery);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssss",
        $row['project_id'], $row['project_name'], $row['cluster_id'], $row['qc_id'],
        $row['total_annotations'], $row['missed_annotations'], $row['incorrect_self'], 
        $row['incorrect_comp'], $row['incorrect_others'], $row['precision'], $row['recall'],
        $row['url'], $row['time'], $row['date'], $row['status'],$row['taggers'],
        $row['T_self_pres'], $row['T_others_pres'], $row['T_comp_pres'],
        $row['Grade_A_Category'], $row['Grade_B_Category'], $row['Grade_C_Category'], 
        $row['Grade_D_Category'], $row['Proj_Grade']
    );

    if (mysqli_stmt_execute($stmt)) {
        // Delete the record from dump_project_qc_status
        $deleteQuery = "DELETE FROM `dump_project_qc_status` WHERE `id` = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["status" => "success", "message" => "Record restored successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to restore the record."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Record not found."]);
}
?>
