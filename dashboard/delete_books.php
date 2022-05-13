<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['bkid']))
	{
		
		$stmt_select = $DB_con->prepare('SELECT cover FROM lmsbooks WHERE bid =:bkid');
		$stmt_select->execute(array(':bkid'=>$_GET['bkid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("img/books/".$imgRow['cover']);

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsbooks WHERE bid =:bkid');
		$stmt_delete->bindParam(':bkid',$_GET['bkid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'books.php';</script>";
		
	}

?>