<?php
include('../connection.php');

if (!isset($_POST['id'], $_POST['column'], $_POST['value'])) {
    exit("Missing parameters");
}

$id     = intval($_POST['id']);
$column = $_POST['column'];
$value  = $_POST['value'];

// Whitelist allowed columns to prevent SQL injection
$allowed_columns = [
    'project_id', 'project_name', 'cluster_id', 'qc_id',
    'total_annotations', 'missed_annotations', 'incorrect_self', 'incorrect_comp', 'incorrect_others',
    'precision', 'recall', 'time', 'date', 'status', 'taggers',
    'T_self_pres', 'T_others_pres', 'T_comp_pres',
    'Grade_A_Category', 'Grade_B_Category', 'Grade_C_Category', 'Grade_D_Category', 'Proj_Grade'
];

// We skip 'url' and 'id' — 'url' is not editable, and 'id' is primary key
if (!in_array($column, $allowed_columns)) {
    exit("Invalid column");
}

$stmt = $conn->prepare("UPDATE project_qc_status SET `$column` = ? WHERE id = ?");
$stmt->bind_param("si", $value, $id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "DB error: " . $conn->error;
}
?>
