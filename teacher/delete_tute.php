<?php

	require_once '../dashboard/dbconfig4.php';
	
	if(isset($_GET['ttid']))
	{

		$stmt_select = $DB_con->prepare('SELECT tdocument FROM lmstute WHERE tuid =:ttid');
		$stmt_select->execute(array(':ttid'=>$_GET['ttid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("../dashboard/images/tute/".$imgRow['tdocument']);

		$stmt_delete = $DB_con->prepare('DELETE FROM lmstute WHERE tuid =:ttid');
		$stmt_delete->bindParam(':ttid',$_GET['ttid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'tute.php';</script>";
		
	}

?>