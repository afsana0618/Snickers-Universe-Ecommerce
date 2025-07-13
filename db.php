<?php
$host = "localhost";
$user = "mundol1_linusmundo7";
$pass = "@Delasalle17";
$db = "mundol1_snickers_store";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error){
    die("Connection failed:". $conn->connect_error);
}
?>