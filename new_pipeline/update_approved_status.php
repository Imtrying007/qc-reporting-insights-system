<?php
include "../connection.php";

session_start();
$approved_by = $_SESSION["email"];

$id = $_POST['id'];

// Get current status
$query = "SELECT status FROM qc_summary WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['status'] === 'pending') {

    // First action → approve
    $new_status = 'approved';
    $approved_date = date('Y-m-d H:i:s');

    $update = "UPDATE qc_summary 
               SET status=?, approved_by=?, approved_date=? 
               WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $new_status, $approved_by, $approved_date, $id);

} elseif ($row['status'] === 'approved') {

    // Toggle to rejected
    $new_status = 'rejected';
    $approved_date = date('Y-m-d H:i:s');
    $update = "UPDATE qc_summary 
               SET status=?, approved_by=?, approved_date=? 
               WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $new_status, $approved_by, $approved_date, $id);

} else { // rejected

    // Toggle back to approved
    $new_status = 'approved';
    $approved_date = date('Y-m-d H:i:s');

    $update = "UPDATE qc_summary 
               SET status=?, approved_by=?, approved_date=? 
               WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssi", $new_status, $approved_by, $approved_date, $id);
}

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "status" => $new_status,
        "approved_by" => $approved_by,
        "approved_date" => $approved_date
    ]);
} else {
    echo json_encode(["success" => false]);
}
?>