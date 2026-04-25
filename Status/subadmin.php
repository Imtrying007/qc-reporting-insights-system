<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `admin` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['status'];

if($data == 'SHOW')
{
    $delete="UPDATE `admin` SET `status`='HIDE' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}else{
    $delete="UPDATE `admin` SET `status`='SHOW' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}
?>