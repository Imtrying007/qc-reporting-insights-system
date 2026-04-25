<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `taggers_qc_status` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['status'];

if($data == 'DONE')
{
    $delete="UPDATE `taggers_qc_status` SET `status`='PENDING' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}else{
    $delete="UPDATE `taggers_qc_status` SET `status`='DONE' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}
?>