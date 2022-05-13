<?php

session_start();



if(!isset($_SESSION['tid']) || (trim($_SESSION['tid']) == '')){

	header('location:index.php');

	exit();

}



$session_id = $_SESSION['tid']; 

/*$session_id = $_SESSION['username']; */





?>