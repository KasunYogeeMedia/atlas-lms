<?php

	require_once 'dbconfig4.php';
	
	if(isset($_GET['glid']))
	{
		
		$stmt_select = $DB_con->prepare('SELECT image FROM lmsgallery WHERE id =:glid');
		$stmt_select->execute(array(':glid'=>$_GET['glid']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("img/gallery/".$imgRow['image']);


		$stmt_delete = $DB_con->prepare('DELETE FROM lmsgallery WHERE id =:glid');
		$stmt_delete->bindParam(':glid',$_GET['glid']);
		$stmt_delete->execute();

		echo"<script type='text/javascript'>window.location.href = 'gallery.php';</script>";
		
	}

?>