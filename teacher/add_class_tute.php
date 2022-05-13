<?php

session_start();

require_once 'includes.php';

require_once("../dashboard/conn.php");

require_once("../dashboard/config.php");

require_once '../dashboard/dbconfig4.php';


if(isset($_SESSION['tid'])){

	$user_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr WHERE tid='$_SESSION[tid]'");

	$user_resalt=mysqli_fetch_array($user_qury);

	

	if($user_resalt['image']==""){

		$image_path="../profile/images/hd_dp.jpg";

	}

	else{

		$image_path="../dashboard/images/teacher/".$user_resalt['image'];

	}

}

else{

echo "<script>window.location='home.php';</script>";

}



$msg5 = '';	

if(isset($_POST['add_classtute']))

	{

        $tid = $_POST['tid'];
		$class = $_POST['class'];				
		$subject = $_POST['subject'];				
		$month = $_POST['month'];
		$ctype = $_POST['ctype'];
		$title = $_POST['title'];
		$status = $_POST['status'];
		
		date_default_timezone_set("Asia/Colombo");
	
		$payment_month=mysqli_real_escape_string($conn,$_POST['payment_month'].date("-d H:i:s"));
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		if(empty($class)){			
		$errMSG = "Please Select Class.";		
		}else if(empty($subject)){			
		$errMSG = "Please Select Subject.";		
		}else if(empty($month)){			
		$errMSG = "Please Select Month.";
		}else if(empty($ctype)){			
		$errMSG = "Please Select Type.";
		}else if(empty($title)){			
		$errMSG = "Please Select Title.";		
		}else if(empty($status)){
			$errMSG = "Please Select Status.";
		}
		{
			$upload_dir = '../dashboard/images/classtute/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif' ,'docx' , 'pdf' , 'video' , 'mp3' ); // valid extensions
		
			// rename uploading image
			$userpic = rand(1,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// lmsck file size '5MB'
				if($imgSize < 50000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF , DOCX & PDF files are allowed.";		
			}
		}
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO lmsclasstute(tid,class,subject,month,ctype,title,tdocument,add_date,status) VALUES(:tid,:class,:subject,:month,:ctype,:title,:upic,:payment_month,:status)');
			$stmt->bindParam(':tid',$tid);						
			$stmt->bindParam(':class',$class);						
			$stmt->bindParam(':subject',$subject);						
			$stmt->bindParam(':month',$month);
			$stmt->bindParam(':ctype',$ctype);
			$stmt->bindParam(':title',$title);
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':payment_month',$payment_month);
			$stmt->bindParam(':status',$status);

			if($stmt->execute())

			{

				$successMSG = "Class Tute Successfully Added.";

				header("refresh:2;class_tute.php"); // redirects image view page after 5 seconds.

			}

			else

			{

				$errMSG = "error while inserting....";

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
    <title>Add Class Tute | Teacher Panel | Online Learning Platforms </title>
	<!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../dashboard/images/favicon.png">
	<link rel="stylesheet" href="../dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
	<!-- Datatable -->
    <link href="../dashboard/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dashboard/css/style.css">

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
                <img class="logo-abbr" src="../dashboard/images/logo-white.png" alt="">
                <img class="logo-compact" src="../dashboard/images/logo-text-white.png" alt="">
                <img class="brand-title" src="../dashboard/images/logo-text-white.png" alt="">
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
                                    <img src="../profile/images/hd_dp.jpg" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="admin.php" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2"><?php echo $user_resalt['fullname'];?></span>
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
                            <h4>Add Class Tute</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Class Tute</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Class Tute</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add Class Tute</h4>
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
												<label class="form-label">Teacher</label>
												<select class="form-control" name="tid" required>
								<?php

								$stmt = $DB_con->prepare('SELECT * FROM lmstealmsr where tid="'.$_SESSION['tid'].'" and status="1" ORDER BY tid');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								?>
								<option value="<?php echo $row['tid']; ?>"><?php echo $row['fullname']; ?></option>
								<?php 
								} 
								}
								?>
								</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Grade</label>
												<select class="form-control" name="class" onChange="JavaScript:send_level(this.value);" required>						 
												<option value="" hidden="lms">Select Grade</option>					  
												<?php																
															
												$stmt = $DB_con->prepare('SELECT * FROM lmsclass ORDER BY cid');								
												$stmt->execute();								
												if($stmt->rowCount() > 0)								
												{								
												while($row=$stmt->fetch(PDO::FETCH_ASSOC))								
												{								
												extract($row);								
												?>                        
												<option value="<?php echo $row['cid']; ?>"><?php echo $row['name']; ?></option>                        
												<?php 
												} 								
												}								
												?>                      
												</select>   
											</div>
										</div>
										<script>
										function send_level(level_id){
										var xhttp = new XMLHttpRequest();
										xhttp.onreadystatechange = function() {
										if (this.readyState == 4 && this.status == 200) {
										document.getElementById("subject_dis").innerHTML = this.responseText;
										}
										};
										xhttp.open("GET", "ajax_subject_filter.php?level_id="+level_id, true);
										xhttp.send();
										}
										</script>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Subject</label>
												<span id="subject_dis">						
					   <select name="subject" class="form-control" required>						
					   <option hidden="lms"><?php if(isset($_GET['edit'])){echo $edit_resalt['subject'];}else{echo "Subject Not Found";} ?></option>	
					   </select>						
					   </span> 
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Month</label>
												<select class="form-control" name="month" required>  
					   <option style="display:none;">Select Month</option>  
					   <option>January</option>  
					   <option>February</option>  
					   <option>March</option>  
					   <option>April</option>  
					   <option>May</option>  
					   <option>June</option>  
					   <option>July</option>  
					   <option>August</option> 
					   <option>September</option>  
					   <option>October</option>  
					   <option>November</option>  
					   <option>December</option>                      
					   </select> 
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Class Type</label>
												<select class="form-control" name="ctype" required>  
					   <option style="display:none;">Select Class Type</option>  
					   <option>Online Class</option>
					   <option>Paper Class</option>
				       <option>Free Class</option>                             
					   </select>                      
											</div>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-12">
											<div class="form-group">
												<label class="form-label">Title</label>
												<input type="text" class="form-control" name="title" placeholder="Enter Class Tute Title" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Upload Document</label>
												<input type="file" class="form-control" name="user_image">
					  <hr>
					  <p style="font-weight:bold;color:red;">Note : "Only Upload - Pdf|Docx|Jpg|Png"</p>
											</div>
										</div>
										
										<div class="col-lg-3 col-md-6 col-sm-12 mb-2">
											<label class="form-label">Upload Month</label>
											<input name="payment_month" type="month" id="payment_month" class="form-control" value="<?php echo date("Y-m") ?>">
										</div>
										
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Status</label>
												<select class="form-control" name="status" required>
                        <option value="1">Published</option>
                        <option value="0">Unpublished</option>
                      </select>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<input type="submit" name="add_classtute" class="btn btn-primary" value="Save changes">
											<a class="btn btn-light" href="class_tute.php"><i class="fa fa-times"></i> Cancel</a>
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

		<!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://yogeemedia.com" target="_blank">Yogeemedia</a> 2021</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

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
	
	<!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../dashboard/vendor/global/global.min.js"></script>
	<script src="../dashboard/js/deznav-init.js"></script>
	<script src="../dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../dashboard/js/custom.min.js"></script>

	<!-- Svganimation scripts -->
    <script src="../dashboard/vendor/svganimation/vivus.min.js"></script>
    <script src="../dashboard/vendor/svganimation/svg.animation.js"></script>
	
	<!-- pickdate -->
    <script src="../dashboard/vendor/pickadate/picker.js"></script>
    <script src="../dashboard/vendor/pickadate/picker.time.js"></script>
    <script src="../dashboard/vendor/pickadate/picker.date.js"></script>
	
	<!-- Pickdate -->
    <script src="../dashboard/js/plugins-init/pickadate-init.js"></script>
	
	
</body>
</html>