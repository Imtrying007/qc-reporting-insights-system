<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `add_project` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['status'];

if($data == 'Active')
{
    $delete="UPDATE `add_project` SET `status`='Inactive' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}else{
    $delete="UPDATE `add_project` SET `status`='Active' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}
?>