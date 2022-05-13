<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['emid']))
	{

		$stmt_select = $DB_con->prepare('SELECT edocument FROM lmsonlineexams WHERE exid =:emid');
		$stmt_select->execute(array(':emid'=>$_GET['emid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("img/exams/".$imgRow['edocument']);

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsonlineexams WHERE exid =:emid');
		$stmt_delete->bindParam(':emid',$_GET['emid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'online_exams.php';</script>";
		
	}

?>