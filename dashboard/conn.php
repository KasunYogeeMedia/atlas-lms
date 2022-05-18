<?php
    require_once 'db.php';
    
	$server = "localhost";
	$username = "$udbname";
	$pass = "$dbpassword";
	$db = "$dbname";
    
	//create connection 
	
	$conn = mysqli_connect($server,$username,$pass,$db);
    

	//mathsck conncetion

	if($conn->connect_error){
		
		die ("Connection Failed!". $conn->connect_error);
	}

?>
