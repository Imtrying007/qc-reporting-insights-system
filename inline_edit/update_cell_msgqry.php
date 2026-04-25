<?php
// Include the database connection file
// connection
include('../connection.php');

// Capture POST data
if (isset($_POST['id'], $_POST['column'], $_POST['value'])) {
    $id = $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    // Validate input
    if (empty($id) || empty($column) || empty($value)) {
        echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
        exit();
    }

    // Update query
    $stmt = $conn->prepare("UPDATE `mesage_request` SET `$column` = ? WHERE `id` = ?");
    $stmt->bind_param("si", $value, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database update failed.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Incomplete POST data.']);
}
?>
