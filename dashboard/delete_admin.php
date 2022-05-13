<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['adid']))
	{
		
		$stmt_delete = $DB_con->prepare('DELETE FROM lmsusers WHERE user_id =:adid');
		$stmt_delete->bindParam(':adid',$_GET['adid']);
		$stmt_delete->execute();
		
		//header("Location: admin.php");
		echo"<script type='text/javascript'>window.location.href = 'admin.php';</script>";
	}

?>