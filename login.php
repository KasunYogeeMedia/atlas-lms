<?php
session_start();
error_reporting(0);

require_once 'dashboard/conn.php';
require_once 'dashboard/config.php';
require_once 'dashboard/dbconfig4.php';

if (isset($_SESSION["reid"])){

    

}

$ip_address=time();


if (isset($_POST['login'])) {
	
    $username = (int)$_POST['username'];
	
    $password = md5($_POST['password']);

    $sql = mysqli_query($conn, "SELECT * FROM lmsregister WHERE contactnumber = '$username' and status='1'");
	
	if(mysqli_num_rows($sql)>0){
		
		$result = mysqli_fetch_array($sql);
		if($password==$result['password']){
			
			if($result['relogin']==0){
			
			$_SESSION['reid']=$result['reid'];
				
			//setcookie('reid', $result['reid'], time() + (86400 * 30), "/");
				
			echo "<script>window.location='profile/student_profile.php';</script>";
			}
			else{
				echo "<script>window.location='login.php?ip_error';</script>";
			}
		}
		else{
			//password not match
			echo "<script>window.location='login.php?password_error';</script>";
		}
		
	}
	else{
		//user not found
		echo "<script>window.location='login.php?user_error';</script>";
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
		<title>Login | Online Learning Platforms </title>
		
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
		
	</head> 

<body>
	<!-- Signup Start -->
	<div class="sign_in_up_bg">
		<div class="container">
			<div class="row justify-content-lg-center justify-content-md-center">
				<!--<div class="col-lg-12">-->
					 
				<!--</div>-->
			
				<div class="col-lg-6 col-md-8">
					<div class="sign_form">
					    	<div class="main_logo25" id="logo">
					<a href="<?php echo $url;?>" title="Home "> <img src="./dashboard/settings/logo/<?php echo $main_logo; ?>" class="img-responsive" alt="Guruniwasa"></a>
					</div>
						<h2>Welcome to <?php echo $application_name; ?></h2>
						<p>Log In to <?php echo $application_name; ?> Account!</p>
						<form method="POST">
							<?php if(isset($_GET['request'])){ ?><div class="alert alert-info text-center"><strong>Information!</strong><br>Your Re login request send successfully. Waiting for approval your request.</div><?php } ?>
								<?php if(isset($_GET['password_error'])){ ?><div class="alert alert-danger text-center"><strong>Sorry!</strong><br>The username or password that you've entered is incorrect!</div><?php } ?>
								<?php if(isset($_GET['user_error'])){ ?><div class="alert alert-danger text-center"><strong>Sorry!</strong><br>There is a problem with your User name or Password. shck and try again.</div><?php } ?>
								<?php if(isset($_GET['ip_error'])){ ?><div class="alert alert-danger text-center"><strong>Sorry!</strong><br>Your account has been blocked due to unautorised access.<br><br><a style="color: dodgerblue; cursor: pointer;" onClick="JavaScript:window.location='login.php?req_id=<?php echo $_GET['u']; ?>';">Request Re login?</a></div><?php } ?>
								<div class="row">
							   <div class="col-lg-12">
                                <div class="single-form">
                                    <label style="font-weight:bold;float:left;">PHONE NUMBER</label>
                                    <input name="username" id="username" value="<?php if(isset($_POST['username'])){echo $_POST['username'];} ?>" type="text" class="form-control phone_val" required placeholder="Your Phone Number" maxlength="10" minlength="10" style="border: 2px solid #ccc;">
                                </div>
								</div>
								  </div>
								  <div class="row">
							   <div class="col-lg-12">
                                <div class="single-form">
                                    <label style="font-weight:bold;float:left;">PASSWORD *</label>
                                    <input name="password" type="password" class="form-control" required id="myInput" placeholder="Your Password" style="border: 2px solid #ccc;"></div>
                                </div>
								</div>
								<br>
							    <div class="row">
							    <div class="col-lg-12">
                                <div class="single-form">
									<input name="login" type="submit" value="Login" class="btn btn-primary btn-block" style="background:#28a745;color:#ffffff;">
                                </div>
								</div>
								  </div>
                            </form>
						<p class="sgntrm145">Or <a href="forgot_password.php">Forgot Password</a>.</p>
						<p style="    line-height: 1.5;
                            padding-top: 10px;
                            font-weight: 600;">දුරකතන අංකය සහ මුරපදය යොදා login විය හැක්කේ ගුරු නිවස ආයතනයේ ගිණුමක් සෑදූ දරුවන් හට පමණි.
                            ගුරුනිවස ආයතනයේ ගිණුමක් සාදා ගැනීමට පහත සදහන් register ක්ලික් කර දරුවාගේ තොරතුරු ඇතුලත් කර ගිණුමක් සාදා ගන්න.
                        </p>
						<p class="mb-0 mt-30 hvsng145">Don't have an account? <a href="register.php">Register</a></p>
                        
					</div>
					<div class="sign_footer">
					     Copyrights 2021
 © <?php echo $application_name;?> | Website by <a target="_blank" title="Click to visit" href="https://yogeemedia.com/">yogeemedia.com</div>
				</div>				
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