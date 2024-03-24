<?php

$dbhost = "localhost:8889";
$dbuser = "root";
$dbpass = "root";
$dbname = "LEVEL6_Tutorial";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(!$conn){
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn, $dbname);
echo "Connect successfully";
?>
