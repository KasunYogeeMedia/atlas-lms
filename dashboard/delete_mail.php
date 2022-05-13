<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['maid']))
	{
		
		$stmt_delete = $DB_con->prepare('DELETE FROM lmsmail WHERE mid =:maid');
		$stmt_delete->bindParam(':maid',$_GET['maid']);
		$stmt_delete->execute();
		
		//header("Location: mail.php");
		echo"<script type='text/javascript'>window.location.href = 'mail.php';</script>";
		
	}

?>