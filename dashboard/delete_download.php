<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['lnid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsdownload WHERE lid =:lnid');
		$stmt_delete->bindParam(':lnid',$_GET['lnid']);
		$stmt_delete->execute();
		
		//header("Location: download.php");
		echo"<script type='text/javascript'>window.location.href = 'download.php';</script>";
		
	}

?>