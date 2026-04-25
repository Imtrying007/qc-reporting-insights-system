<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `ds_table_qc_status` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['status'];

if($data == 'done')
{
    $delete="UPDATE `ds_table_qc_status` SET `status`='pending' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}else{
    $delete="UPDATE `ds_table_qc_status` SET `status`='done' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}
?>