<?php
include('../connection.php');
$id=$_POST['id'];

$delete="DELETE FROM `mesage_request` WHERE `id`='$id'";
$runn=mysqli_query($conn,$delete);


$sql_query="SELECT * FROM `mesage_request`";
$runn=mysqli_query($conn,$sql_query);
echo $count=mysqli_num_rows($runn);

?>