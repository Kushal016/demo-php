<?php

ob_start();//turns on output buffering
session_start();

$timezone = date_default_timezone_set("Asia/Kolkata");
$con = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno()){
	echo "Failed".mysqli_connect_errno(); 
}

?>