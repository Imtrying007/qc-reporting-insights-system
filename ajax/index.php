<?php 
include('../connection.php');

echo "ok"; 

echo $post_id=$_POST['post_id'];


if(!empty($post_id)){

    echo $sql_query_query="SELECT * FROM `submission_file` WHERE `id`='$post_id'";
    $runn_query=mysqli_query($conn,$sql_query_query);
    $count=mysqli_num_rows($runn_query);
    if($count == '1')
    {
        $data_sub=mysqli_fetch_assoc($runn_query);
        echo $article_component=$data_sub['article_component'];
      
    }
   


}

?>