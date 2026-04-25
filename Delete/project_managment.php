<?php
include('../connection.php');
session_start();

if (!isset($_POST['id']) || !isset($_SESSION['email'])) {
    echo "error";
    exit;
}

$id = $_POST['id'];
$deletedBy = $_SESSION['email']; // Email from session

// Fetch project details before deleting
$query = "SELECT * FROM `add_project` WHERE `id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Insert into dump_add_project before deleting
    $insertDump = "INSERT INTO `dump_add_project` (`id`, `owner_name`, `project_name`, `cluster`, `date`, `time`, `status`,`mode`, `Del_person_id`) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmtDump = $conn->prepare($insertDump);
    $stmtDump->bind_param("issssssss", $row['id'], $row['owner_name'], $row['project_name'], $row['cluster'], $row['date'], $row['time'], $row['status'],$row['mode'], $deletedBy);
    
    if ($stmtDump->execute()) {
        // Now delete from add_project
        $deleteQuery = "DELETE FROM `add_project` WHERE `id` = ?";
        $stmtDelete = $conn->prepare($deleteQuery);
        $stmtDelete->bind_param("i", $id);
        
        if ($stmtDelete->execute()) {
            // Get remaining project count
            $countQuery = "SELECT COUNT(*) FROM `add_project`";
            $countResult = $conn->query($countQuery);
            $count = $countResult->fetch_row()[0];

            echo $count; // Return updated project count
        } else {
            echo "error"; // Deletion failed
        }
    } else {
        echo "error"; // Insert into dump failed
    }
} else {
    echo "error"; // No matching record found
}
?>
