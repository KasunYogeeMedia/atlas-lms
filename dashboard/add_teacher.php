<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once 'dbconfig4.php';

$msg = '';

$msg5 = '';	

$systemid_val=time();

if(isset($_POST['add_bt'])){
	
	$fullname=mysqli_real_escape_string($conn,$_POST['fullname']);
	$address=mysqli_real_escape_string($conn,$_POST['address']);
	$contactnumber=(int)mysqli_real_escape_string($conn,$_POST['contactnumber']);
	$subdetails=mysqli_real_escape_string($conn,$_POST['subdetails']);
	$qualification=mysqli_real_escape_string($conn,$_POST['qualification']);
	$username=mysqli_real_escape_string($conn,$_POST['username']);
	$password=md5(mysqli_real_escape_string($conn,$_POST['password']));
	$systemid=mysqli_real_escape_string($conn,$_POST['systemid']);
	$Percentage=mysqli_real_escape_string($conn,$_POST['Percentage']);
	
	date_default_timezone_set("Asia/Colombo");
	$add_date=date("Y-m-d H:i:s");
	
	if(!$_FILES['image']['name']==""){
	
	if ($_FILES['image']['type']=="image/jpeg"){
              $imagename = time().$_FILES['image']['name'];
              $source = $_FILES['image']['tmp_name'];
              $target = "images/teacher/".str_replace(" ","_",$imagename);
			  $db_send_name = str_replace(" ","_",$imagename);
              move_uploaded_file($source, $target);

              $imagepath = $imagename;
              $save = "images/teacher/" . $imagepath; //This is the new file you saving
              $file = "images/teacher/" . $imagepath; //This is the original file

              list($width, $height) = getimagesize($file) ;

              $modwidth = 300;

              $diff = $width / $modwidth;

              $modheight = $height / $diff;
              $tn = imagecreatetruecolor($modwidth, $modheight) ;
              $image = imagecreatefromjpeg($file) ;
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

              imagejpeg($tn, $save, 100) ;	
	}
	else{
		$db_send_name="";
	}
	}
	else{
		$db_send_name="";
	}

mysqli_query($conn,"INSERT INTO lmstealmsr(systemid, fullname, address, contactnumber,subdetails, qualification, username, password, image, Percentage, add_date, status) VALUES ('$systemid','$fullname','$address','$contactnumber','$subdetails','$qualification','$username','$password','$db_send_name','$Percentage','$add_date','0')");

if(!empty($_POST['lavel'])){
foreach($_POST['lavel'] as $lavel){
mysqli_query($conn,"INSERT INTO lmstealmsr_multiple(tealmsr_system_id, tealmsr_type, tealmsr_contain_id) VALUES ('$systemid','2','$lavel')");
}
}
	
if(!empty($_POST['subject'])){
foreach($_POST['subject'] as $subject){
mysqli_query($conn,"INSERT INTO lmstealmsr_multiple(tealmsr_system_id, tealmsr_type, tealmsr_contain_id) VALUES ('$systemid','3','$subject')");
}
}
	
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Teacher | Online Learning Platforms | Dashboard</title>
	<?php
	require_once 'headercss.php';
	?>

</head>

<body>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.php" class="brand-logo">
                <img class="logo-abbr" src="images/logo-white.png" alt="">
                <img class="logo-compact" src="images/logo-text-white.png" alt="">
                <img class="brand-title" src="images/logo-text-white.png" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <img src="images/profile/pic1.jpg" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="admin.php" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2"><?php echo $user_name;?></span>
                                    </a>
                                    <a href="logout.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
<?php

require_once 'sidebarmenu.php';

?>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
				    
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Add Teacher</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Teacher</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Teacher</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add Teacher</h4>
							</div>
							<div class="card-body">
							<?php

							if(isset($errMSG)){

							?>
			
							<div class="alert alert-danger alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Error!</strong> <?php echo $errMSG; ?>
							</div>

							<?php

							}
	
							else if(isset($successMSG)){

							?>
			
							<div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> <?php echo $successMSG; ?>.
							</div>

							<?php

							}

							?>
								<form method="POST" enctype="multipart/form-data">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Profile Photo</label>
												<p style="color:red;">Only JPG</p>
												<input type="hidden" name="systemid" id="" value="<?php echo $systemid_val; ?>">

<label for="fileName"><img src="../profile/images/hd_dp.jpg" id="yourImgTag" class="pro_pick"></label>
<input type="file" name="image" id="fileName" hidden="lms" onChange="dis_name();">
	
<script>
function dis_name(){
var input = document.getElementById("fileName");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);
fReader.onloadend = function(event){
var img = document.getElementById("yourImgTag");
img.src = event.target.result;
}
}
</script>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Full Name</label>
												<input type="text" class="form-control" name="fullname" placeholder="Enter Full Name" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Contact Number</label>
												<input type="tel" class="form-control" name="contactnumber" placeholder="Enter Contact Number" required pattern="\d*">
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Address</label>
												<input type="text" class="form-control" name="address" placeholder="Enter Address" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Subject Details</label>
												<input type="text" class="form-control" name="subdetails" placeholder="Enter Subject Details" required>
											</div>
										</div>
										<div class="col-lg-6 col-md-5 col-sm-12">
											<div class="form-group">
												<label class="form-label">Qualification</label>
												<input type="text" class="form-control" name="qualification" placeholder="Enter Qualification" required>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Percentage (%)</label>
												<input type="text" class="form-control" name="Percentage" placeholder="Enter Percentage" required pattern="\d*">
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Grade</label>
												<table>
<tbody>
<?php
$level_qury=mysqli_query($conn,"SELECT * FROM lmsclass ORDER BY name");
while($level_resalt=mysqli_fetch_array($level_qury)){
?>
<tr valign="middle">
<td style="width: 20px;"><input type="checkbox" name="lavel[]" id="<?php echo "level".$level_resalt['cid']; ?>" value="<?php echo $level_resalt['cid']; ?>"></td>
<td><label for="<?php echo "level".$level_resalt['cid']; ?>"><?php echo $level_resalt['name']; ?></label></td>
</tr>
<?php
}
?>
</tbody>
</table>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group">
												<label class="form-label">Subject</label>
<table>
<tbody>
<?php
$subject_qury=mysqli_query($conn,"SELECT * FROM lmssubject ORDER BY name");
while($subject_resalt=mysqli_fetch_array($subject_qury)){
?>
<tr valign="middle">
<td style="width: 20px;"><input type="checkbox" name="subject[]" id="<?php echo "subject".$subject_resalt['sid']; ?>" value="<?php echo $subject_resalt['sid']; ?>"></td>
<td><label for="<?php echo "subject".$subject_resalt['sid']; ?>"><?php echo $subject_resalt['name']; ?> -  [<?php

						$id = $subject_resalt['class_id'];

						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

					  ?>]</label></td>
</tr>
<?php
}
?>
</tbody>
</table>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">User Name (Email Address)</label>
												<input type="email" class="form-control" name="username" placeholder="Enter User Name" required>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Password</label>
												<input type="password" class="form-control" name="password" placeholder="Enter Password" required>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<input type="submit" name="add_bt" class="btn btn-primary" value="Save changes">
											<a class="btn btn-light" href="teachers.php"><i class="fa fa-times"></i> Cancel</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

		<?php
		require_once 'footer.php';
		?>

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <?php
	require_once 'footerjs.php';
	?>
	
</body>
</html>