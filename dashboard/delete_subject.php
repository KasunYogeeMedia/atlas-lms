<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['sbid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmssubject WHERE sid =:sbid');
		$stmt_delete->bindParam(':sbid',$_GET['sbid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'subject.php';</script>";
		
	}

?>