<?php
include "../connection.php";
session_start();

$deleted_by = $_SESSION["email"];
header('Content-Type: application/json');

// Validate input
if (!isset($_POST['p_id'], $_POST['qc_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing parameters"
    ]);
    exit;
}

$p_id = $_POST['p_id'];
$qc_id = $_POST['qc_id'];

try {

    // Start transaction
    $conn->begin_transaction();


// Fetch project, QC details, and sheet_url before deletion
    $stmt0 = $conn->prepare("SELECT p_id_name, p_name, qc_name, sheet_url FROM qc_notes WHERE p_id = ? AND qc_id = ? LIMIT 1");
    $stmt0->bind_param("si", $p_id, $qc_id);
    $stmt0->execute();
    $stmt0->bind_result($p_id_name, $p_name, $qc_name, $sheet_url);
    $stmt0->fetch();
    $stmt0->close();

    // Ensure sheet_url is not null
    if (empty($sheet_url)) {
        $sheet_url = null;
    }

    // Delete from qc_notes
    $stmt1 = $conn->prepare("DELETE FROM qc_notes WHERE p_id = ? AND qc_id = ?");
    $stmt1->bind_param("si", $p_id, $qc_id);
    $stmt1->execute();
    $deleted_notes = $stmt1->affected_rows;
    $stmt1->close();

    // Delete from qc_summary
    $stmt2 = $conn->prepare("DELETE FROM qc_summary WHERE p_id = ? AND qc_id = ?");
    $stmt2->bind_param("si", $p_id, $qc_id);
    $stmt2->execute();
    $deleted_summary = $stmt2->affected_rows;
    $stmt2->close();

    // Insert into delete_log
        $stmt3 = $conn->prepare("INSERT INTO delete_log 
        (p_id, p_id_name, p_name, qc_id, qc_name, sheet_url, deleted_by, qc_notes_deleted, qc_summary_deleted) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt3->bind_param(
        "sssssssii",
        $p_id,
        $p_id_name,
        $p_name,
        $qc_id,
        $qc_name,
        $sheet_url,
        $deleted_by,
        $deleted_notes,
        $deleted_summary
    );
    $stmt3->execute();
    $stmt3->close();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        "success" => true,
        "deleted_notes" => $deleted_notes,
        "deleted_summary" => $deleted_summary,
        "message" => "Deleted successfully and logged"
    ]);

} catch (Exception $e) {

    // Rollback on error
    $conn->rollback();

    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}