<?php
session_start();
error_reporting(0);

require_once 'dashboard/conn.php';
require_once 'dashboard/config.php';
require_once 'dashboard/dbconfig4.php';

if (isset($_SESSION["reid"])){

    $image_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='".$_SESSION["reid"]."'");
    $image_resalt=mysqli_fetch_array($image_qury);

    $fullname=$image_resalt['fullname'];

    if($image_resalt['image']==""){
    	$dis_image_path="profile/images/hd_dp.jpg";
    }else{
    	$dis_image_path="profile/uploadImg/".$image_resalt['image'];
    }

}

$code=rand(1000,9999);

$veryfy=0;
$status="";
if(isset($_POST['send_code'])){
	$contactnumber=(int)mysqli_real_escape_string($conn,$_POST['contactnumber']);
	$to="+94".(int)mysqli_real_escape_string($conn,$_POST['contactnumber']);
	$_SESSION['contactnumber']=$contactnumber;
	
	if(mysqli_query($conn,"UPDATE lmsregister SET verifycode='$code' WHERE contactnumber='$contactnumber'")){
	$message_text="Your Verify Code is $code";
	$message=urlencode($message_text);
	$url="https://send.lk/sms/send.php?token=$sms_api_token&to=$to&from=$sms_sender_id&message=$message";
	file_get_contents($url);
	
	echo "<img src=''>";
	
	$veryfy=1;
	}

}

if(isset($_POST['veryfy_bt'])){
	if(isset($_SESSION['contactnumber'])){
	$verifycode=mysqli_real_escape_string($conn,$_POST['verifycode']);
	$check_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE contactnumber='$_SESSION[contactnumber]' and verifycode!=''");
	if(mysqli_num_rows($check_qury)>0){
		$check_realt=mysqli_fetch_array($check_qury);
		if($check_realt['verifycode']==$verifycode){
			$veryfy=2;
		}
		else{
			$status="code_error";
			$veryfy=1;
		}
	}
	else{
		$status="no_user";
		$veryfy=1;
	}
	
	}
	else{
		echo "<script>window.location='forgot_password.php';</script>";	
	}
}

if(isset($_POST['change_pass'])){
	$password=md5(mysqli_real_escape_string($conn,$_POST['password']));
	$re_password=md5(mysqli_real_escape_string($conn,$_POST['re_password']));
	
	if($password==$re_password){
		if(mysqli_query($conn,"UPDATE lmsregister SET password='$password' WHERE contactnumber='$_SESSION[contactnumber]'")){
			
			mysqli_query($conn,"UPDATE lmsregister SET verifycode='' WHERE contactnumber='$_SESSION[contactnumber]'");
			
			unset($_SESSION['contactnumber']);
			
			echo "<script>window.location='login.php?change_pass_success';</script>";	
		}
	}
	else{
		$status="re_pass_error";
		$veryfy=2;
	}
}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=9">
		<meta name="description" content="Online Learning Platforms ">
		<meta name="author" content="Online Learning Platforms ">
		<title>Forgot Password | Online Learning Platforms </title>
		
		<!-- Favicon Icon -->
		<link rel="icon" type="image/png" href="images/fav.png">
		
		<!-- Stylesheets -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
		<link href='profile/vendor/unicons-2.0.1/css/unicons.css' rel='stylesheet'>
		<link href="profile/css/vertical-responsive-menu.min.css" rel="stylesheet">
		<link href="profile/css/style.css" rel="stylesheet">
		<link href="profile/css/responsive.css" rel="stylesheet">
		<link href="profile/css/night-mode.css" rel="stylesheet">
		
		<!-- Vendor Stylesheets -->
		<link href="profile/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
		<link href="profile/vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
		<link href="profile/vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">
		<link href="profile/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="profile/vendor/semantic/semantic.min.css">	

		<style>
		.error_Msg,
		.error_Msg2 {
        color: #fa4b2a;
        padding-left: 10px;
        font-family: Verdana;
		}
		</style>
		
	</head> 

<body class="sign_in_up_bg">
	<!-- Signup Start -->
	<div class="container">
		<div class="row justify-content-lg-center justify-content-md-center">
			<div class="col-lg-12">
					<div class="main_logo25" id="logo">
						<!--<a href="index.php"><img src="assets/images/logo/logonw.png" alt="" alt="" style="height:100px;text-align:center;"></a>-->
						<a href="index.php"><img class="logo-inverse" src="profile/images/ct_logo.svg" alt=""></a>
					</div>
				</div>
			
			<div class="col-lg-6 col-md-8">
			<?php if($veryfy==0){ ?>
				<div class="sign_form">
					<h2>Forgot Password</h2>
					<form method="POST">
					<div class="row">
							   <div class="col-lg-12">
                                <div class="single-form">
                                    <label class="lbltext">Phone Number</label>
                                    <input name="contactnumber" type="text" class="form-control phone_val" required="" placeholder="Your Phone Number" maxlength="10" minlength="10">
								</div>
								</div>
								<br><br>
								<div class="col-lg-12">
								    
                                <div class="single-form">
                                    	<br><br>
                                    <input type="submit" name="send_code" value="Send" class="btn btn-primary btn-block" style="background:#28a745;color:#ffffff;">
								</div>
								</div>
					</div>
					</form>
					<p class="mb-0 mt-30">Go Back <a href="login.php">Login</a></p>
				</div>
			<?php } ?>
			<?php if($veryfy==1){ ?>
				<div class="sign_form">
					<h2>Enter Verify Code</h2>
					<form method="POST">
					<?php if($status=="code_error"){ ?><div class="alert alert-danger">Fail! Verify code is not match, please try again.</div><?php } ?>
					<?php if($status=="no_user"){ ?><div class="alert alert-danger">Fail! User not valid, please try again.</div><?php } ?>
					<div class="row">
							   <div class="col-lg-12">
                                <div class="single-form">
                                    <label class="lbltext">Verify Code</label>
									<input name="verifycode" type="text" class="form-control phone_val" required placeholder="****" pattern="\d*" maxlength="4" minlength="4">
								</div>
								</div>
								<br><br>
								<div class="col-lg-12">
                                <div class="single-form">
                                    <input type="submit" name="veryfy_bt" value="Veryfy" class="btn btn-primary btn-block" style="background:#28a745;color:#ffffff;">
								</div>
								</div>
					</div>
					</form>
					<p class="mb-0 mt-30">Go Back <a href="login.php">Login</a></p>
				</div>
			<?php } ?>
		
			<?php if($veryfy==2){ ?>
				<div class="sign_form">
					<h2>Change Password</h2>
					<form method="POST">
					<?php if($status=="re_pass_error"){ ?><div class="alert alert-danger">Fail! Re-enter Password not match, please try again.</div><?php } ?>
					<div class="row">
							   <div class="col-lg-12">
                                <div class="single-form">
                                    <label class="lbltext">New Password</label>
									<input name="password" id="username" type="password" class="form-control phone_val" required minlength="8">
								</div>
								</div>
								<br><br>
								<div class="col-lg-12">
                                <div class="single-form">
                                    <label class="lbltext">Re-Enter Password</label>
									<input name="re_password" id="username" type="password" class="form-control phone_val" required minlength="8">
								</div>
								</div>
								<br><br>
								<div class="col-lg-12">
                                <div class="single-form">
									<input type="submit" name="change_pass" value="Change Password" class="btn btn-primary btn-block" style="background:#28a745;color:#ffffff;">
								</div>
								</div>
					</div>
					</form>
					<p class="mb-0 mt-30">Go Back <a href="login.php">Login</a></p>
				</div>
			
			<?php } ?>
			<div class="sign_footer"> <p>
                     Copyrights <span id="getYear"></span>
 © <?php echo $application_name;?> | Website by <a target="_blank" title="Click to visit" href="https://yogeemedia.com/">yogeemedia.com</a>
                  </p></div>
			</div>	
			
		</div>				
	</div>				
	<!-- Signup End -->	

	<script src="profile/js/jquery-3.3.1.min.js"></script>
	<script src="profile/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="profile/vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="profile/vendor/semantic/semantic.min.js"></script>
	<script src="profile/js/custom.js"></script>	
	<script src="profile/js/night-mode.js"></script>	
	
</body>
</html>