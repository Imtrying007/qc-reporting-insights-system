<?php
include('../connection.php');
$id=$_POST['id'];

$delete="DELETE FROM `ds_table_qc_status` WHERE `id`='$id'";
$runn=mysqli_query($conn,$delete);


$sql_query="SELECT * FROM `ds_table_qc_status`";
$runn=mysqli_query($conn,$sql_query);
echo $count=mysqli_num_rows($runn);

?>