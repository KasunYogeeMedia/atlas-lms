<?php
session_start();
require_once 'dashboard/conn.php';
if(!isset($_SESSION['reid'])){
	header('location:$url');
	exit();
}

$fullname = $_SESSION['fullname'];
$contactnumber = $_SESSION['contactnumber'];

?>