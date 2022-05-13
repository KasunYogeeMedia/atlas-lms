<?php

//error_reporting(0);
//session_start();



include 'dbconfig4.php';

require_once("conn.php");

if(isset($_GET['pid'])){

	$pid=mysqli_real_escape_string($conn,$_GET['pid']);	

	mysqli_query($conn,"UPDATE lmspayment SET `status`=1 WHERE pid='$pid' LIMIT 1");	

    if ($_GET['inti_loca'] == "home"){ header("Location:home.php"); }
    if ($_GET['inti_loca'] == "bank_payment"){ header("Location:bank_payaments.php"); }

}

?>