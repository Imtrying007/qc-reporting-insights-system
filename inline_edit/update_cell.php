<?php
include('../connection.php');

header('Content-Type: application/json');

if (isset($_POST['id'], $_POST['column'], $_POST['value'])) {

    $id = (int) $_POST['id'];
    $column = $_POST['column'];
    $value = $_POST['value'];

    $allowed = ['concern', 'info_status', 'p_name'];

    if (!in_array($column, $allowed)) {
        echo json_encode(['success' => false, 'error' => 'Invalid column']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE `training _queue` SET `$column` = ? WHERE `id` = ?");
    $stmt->bind_param("si", $value, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(['success' => false, 'error' => 'Incomplete POST data']);
}
?>