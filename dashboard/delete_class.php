<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['clid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsclass WHERE cid =:clid');
		$stmt_delete->bindParam(':clid',$_GET['clid']);
		$stmt_delete->execute();
		
		//header("Location: class.php");
		echo"<script type='text/javascript'>window.location.href = 'class.php';</script>";
		
	}

?>