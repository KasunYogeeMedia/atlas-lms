<?php

	$server = "localhost";
	$username = "stepup_atlas";
	$pass = "hDm7BDkZxA=l";
	$db = "stepup_atlas";

	//create connection 

	$conn = mysqli_connect($server,$username,$pass,$db);
	if($conn->connect_error){

		die ("Connection Failed!". $conn->connect_error);
	}
	
    $main_db=mysqli_query($conn,"SELECT * FROM lmsdb WHERE id=1");
	$main_db_resalt=mysqli_fetch_array($main_db);
	$dbname = $main_db_resalt['dbname'];
	$udbname = $main_db_resalt['username'];
	$dbpassword = $main_db_resalt['password'];


	$setting=mysqli_query($conn,"SELECT * FROM settings WHERE id=1");
	$setting_resalt=mysqli_fetch_array($setting);
	$reg_prefix = $setting_resalt['reg_prefix'];
	$application_name = $setting_resalt['application_name'];
	$main_logo = $setting_resalt['main_logo'];

	$sms=mysqli_query($conn,"SELECT * FROM lmssms WHERE id=1");
	$sms_resalt=mysqli_fetch_array($sms);
	$sender_id = $sms_resalt['sender_id'];
	$sa_token = $sms_resalt['sa_token'];

	$payment_getway=mysqli_query($conn,"SELECT * FROM lmsgetway WHERE id=1");
	$getway_resalt=mysqli_fetch_array($payment_getway);
	$app_id = $getway_resalt['app_id'];
	$hash_salt = $getway_resalt['hash_salt'];
	$a_token = $getway_resalt['a_token'];

	$lmsurl=mysqli_query($conn,"SELECT * FROM lmsurl WHERE id=1");
	$lmsurl_resalt=mysqli_fetch_array($lmsurl);
	$url = $lmsurl_resalt['url'];
?>