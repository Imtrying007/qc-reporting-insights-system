<?php
include('../connection.php');

$date = date("Y-m-d");
$time = date("H:i:s");

$project_id   = $_POST['project_id'];
$project_name = $_POST['project_name'];
$status       = $_POST['status'];
$cluster      = $_POST['cluster'];

$stmt = $conn->prepare("INSERT INTO add_project 
(owner_name, project_name, cluster, date, time, status) 
VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssssss",
    $project_id,
    $project_name,
    $cluster,
    $date,
    $time,
    $status
);

if($stmt->execute()){
    echo "1";
} else {
    echo "0";
}
?>