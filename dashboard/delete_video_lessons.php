<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['leid']))
	{

		$stmt_select = $DB_con->prepare('SELECT cover FROM lmslesson WHERE lid =:leid');
		$stmt_select->execute(array(':leid'=>$_GET['leid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("images/lesson/cover/".$imgRow['cover']);

		$stmt_delete = $DB_con->prepare('DELETE FROM lmslesson WHERE lid =:leid');
		$stmt_delete->bindParam(':leid',$_GET['leid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'video_lessons.php';</script>";
		
	}

?>