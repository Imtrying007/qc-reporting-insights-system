<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `project_qc_status` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['status'];

if($data == 'SHOW')
{
    $delete="UPDATE `project_qc_status` SET `status`='HIDE' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}else{
    $delete="UPDATE `project_qc_status` SET `status`='SHOW' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}
?>