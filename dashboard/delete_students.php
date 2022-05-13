<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['stid']))
	{

		$stmt_select = $DB_con->prepare('SELECT image,contactnumber FROM lmsregister WHERE reid =:stid');
		$stmt_select->execute(array(':stid'=>$_GET['stid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("img/profile/".$imgRow['image']);

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsregister WHERE reid =:stid');
		$stmt_delete->bindParam(':stid',$_GET['stid']);
		$stmt_delete->execute();
		
		$contactnumber = $imgRow['contactnumber'];

		$stmt_delete = $DB_con->prepare('DELETE FROM lmsreq_subject WHERE sub_req_reg_no ="'.$contactnumber.'"');
		$stmt_delete->bindParam(':sub_req_reg_no',$contactnumber);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'students.php';</script>";
		
	}

?>