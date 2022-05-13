<?php


if(!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')){
	header('location:index.php');
	exit();
}

$session_id = $_SESSION['user_id']; 
$session_id = $_SESSION['user_name']; 


?>