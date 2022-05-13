<?php

	require_once '../dashboard/dbconfig4.php';
	
	if(isset($_GET['rvid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmscomments WHERE id =:rvid');
		$stmt_delete->bindParam(':rvid',$_GET['rvid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'review.php';</script>";
		
	}

?>