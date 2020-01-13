<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "setiawan_spooring_2";
$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if(!$conn){
	die($conn->connect_error);
}
?>