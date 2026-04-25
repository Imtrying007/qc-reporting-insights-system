<?php
include('../connection.php');
$id=$_POST['country_id'];

$sql_query="SELECT * FROM `add_project` where `id`='$id'";
$runn=mysqli_query($conn,$sql_query);
$data=mysqli_fetch_assoc($runn);

echo $project_name=$data['project_name'];

?>