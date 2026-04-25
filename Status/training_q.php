<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `training _queue` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['info_status'];

if($data == 'recieved')
{
    $delete="UPDATE `training _queue` SET `info_status`='pending' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
    
}
else{
    $delete="UPDATE `training _queue` SET `info_status`='recieved' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}

?>