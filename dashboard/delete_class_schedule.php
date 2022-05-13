<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['csid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsclass_schlmsle WHERE classid =:csid');
		$stmt_delete->bindParam(':csid',$_GET['csid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'class_schlmsle.php';</script>";
		
	}

?>