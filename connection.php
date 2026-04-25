<?php
// connection
$server_name = "localhost";
$user_name = "dbroot";
$password = "dbp";
$dbname = "dbn";

$conn = mysqli_connect($server_name, $user_name, $password, $dbname);
if (!$conn) {
    echo "Error connecting";
} else {
    // echo "Connection established";
}

?>
