<?php
include('../connection.php');
$id=$_POST['id'];

$delete="DELETE FROM `training _queue` WHERE `id`='$id'";
$runn=mysqli_query($conn,$delete);


$sql_query="SELECT * FROM `training _queue`";
$runn=mysqli_query($conn,$sql_query);
echo $count=mysqli_num_rows($runn);

?>