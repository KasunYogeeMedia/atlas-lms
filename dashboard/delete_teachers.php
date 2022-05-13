<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['teid']))
	{

		$stmt_select = $DB_con->prepare('SELECT image FROM lmstealmsr WHERE tid =:teid');
		$stmt_select->execute(array(':teid'=>$_GET['teid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("img/teacher/".$imgRow['image']);

		$stmt_delete = $DB_con->prepare('DELETE FROM lmstealmsr WHERE tid =:teid');
		$stmt_delete->bindParam(':teid',$_GET['teid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'teachers.php';</script>";
		
	}

?>