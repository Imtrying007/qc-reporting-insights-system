<?php
include "../connection.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $query = mysqli_query($conn, "SELECT project_name FROM add_project WHERE id='$id' LIMIT 1");

    if($row = mysqli_fetch_assoc($query)){
        echo $row['project_name'];
    } else {
        echo "";
    }
}
?>