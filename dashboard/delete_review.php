<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['rrid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmscomments WHERE id =:rrid');
		$stmt_delete->bindParam(':rrid',$_GET['rrid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'reviews.php';</script>";
		
	}

?>