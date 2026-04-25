<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `Request` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['status'];

if($data == 'Done')
{
    $delete="UPDATE `Request` SET `status`='Pending' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
    
}
else{
    $delete="UPDATE `Request` SET `status`='Done' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}

?>