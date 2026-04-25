<?php
include('../connection.php');
$id=$_POST['id'];

$sql_query="SELECT * FROM `add_project` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);
$data=$data['mode'];

if($data == 'Auto_S2C')
{
    $delete="UPDATE `add_project` SET `mode`='Tag_S2C' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}else{
    $delete="UPDATE `add_project` SET `mode`='Auto_S2C' WHERE `id`='$id'";
    $runn=mysqli_query($conn,$delete);
}
?>