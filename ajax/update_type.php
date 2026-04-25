<?php
session_start();
include('../connection.php');

// Ensure no extra whitespace/output
ob_start();

// Get POST data safely
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$type = isset($_POST['type']) ? mysqli_real_escape_string($conn, $_POST['type']) : '';

// Default response
$response = ['status' => 'error'];

if ($id > 0 && !empty($type)) {
    $update_sql = "UPDATE admin SET type='$type' WHERE id=$id";
    if (mysqli_query($conn, $update_sql)) {
        // Check if the current user changed their own role
        if (isset($_SESSION['user_id']) && $id == $_SESSION['user_id']) {
            session_unset();
            session_destroy();
            $response['status'] = 'logout';
        } else {
            $response['status'] = 'success';
        }
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>