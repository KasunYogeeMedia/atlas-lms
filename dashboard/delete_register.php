<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['rgid']))
	{
		
		$stmt_delete = $DB_con->prepare('DELETE FROM lmsregister WHERE reid =:rgid');
		$stmt_delete->bindParam(':rgid',$_GET['rgid']);
		$stmt_delete->execute();
		
		//header(register);
		echo"<script type='text/javascript'>window.location.href = 'register.php';</script>";
	}

?>