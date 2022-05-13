<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['ctid']))
	{

		$stmt_delete = $DB_con->prepare('DELETE FROM lmscategory WHERE ctid =:ctid');
		$stmt_delete->bindParam(':ctid',$_GET['ctid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'category.php';</script>";
		
	}

?>