<?php

session_start();

require_once("../dashboard/conn.php");



if(isset($_SESSION['tid'])){

	$user_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr WHERE tid='$_SESSION[tid]'");

	$user_resalt=mysqli_fetch_array($user_qury);

	

	if($user_resalt['image']==""){

		$image_path="../profile/images/hd_dp.jpg";

	}

	else{

		$image_path="https://laksiripremanath.com/maths/dashboard/images/teacher/".$user_resalt['image'];

	}

}

else{

echo "<script>window.location='home.php';</script>";

}

?>