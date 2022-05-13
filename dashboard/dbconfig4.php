<?php
require_once 'db.php';
$DB_HOST = 'localhost';
$DB_USER = $udbname;
$DB_PASS = $dbpassword;
$DB_NAME = $dbname;

$sms_api_key="xobiKaEecHrWFGItKthBAiiC3UcCX51R";
$sms_api_token="$sa_token";
$sms_sender_id="$sender_id";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	
?>