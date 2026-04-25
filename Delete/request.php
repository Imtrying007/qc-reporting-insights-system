<?php
include('../connection.php');
$id=$_POST['id'];

$delete="DELETE FROM `Request` WHERE `id`='$id'";
$runn=mysqli_query($conn,$delete);


$sql_query="SELECT * FROM `Request`";
$runn=mysqli_query($conn,$sql_query);
echo $count=mysqli_num_rows($runn);

?>