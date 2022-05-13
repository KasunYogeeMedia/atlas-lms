<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once("config.php");

require_once 'dbconfig4.php';

$msg5 = '';	

if(isset($_POST['add_exams']))

	{

        $tid = $_POST['tid'];
		$class = $_POST['class'];
		$subject = $_POST['subject'];				
		$examname = $_POST['examname'];
		$edate = $_POST['edate'];
		$exam_end_date = $_POST['exam_end_date'];
		$quizcount = $_POST['quizcount'];
		$status = $_POST['status'];
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		
		if(empty($subject)){			
		$errMSG = "Please Select Subject.";
		}else if(empty($subject)){			
		$errMSG = "Please Select Subject.";
		}else if(empty($examname)){			
		$errMSG = "Please Select Exam Name.";	
		}else if(empty($edate)){			
		$errMSG = "Please Select Exam Date.";
		}else if(empty($quizcount)){			
		$errMSG = "Please Enter No Of Quiz.";
		}else if(empty($status)){
			$errMSG = "Please Select Status.";
		}
		{
			$upload_dir = 'images/exams/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif' ,'docx' , 'pdf' , 'video' , 'mp3' ); // valid extensions
		
			// rename uploading image
			$userpic = rand(1,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// thck file size '5MB'
				if($imgSize < 5000000)				{
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
			$stmt = $DB_con->prepare('INSERT INTO lmsonlineexams(tid,class,subject,examname,edate,exam_end_date,edocument,quizcount,status) VALUES(:tid,:class,:subject,:examname,:edate,:exam_end_date,:upic,:quizcount,:status)');
			$stmt->bindParam(':tid',$tid);
			$stmt->bindParam(':class',$class);
			$stmt->bindParam(':subject',$subject);
			$stmt->bindParam(':examname',$examname);	
			$stmt->bindParam(':edate',$edate);
			$stmt->bindParam(':exam_end_date',$exam_end_date);
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':quizcount',$quizcount);
			$stmt->bindParam(':status',$status);

			if($stmt->execute())

			{

				$successMSG = "Online Exams Successfully Added.";

				header("refresh:2;online_exams.php"); // redirects image view page after 5 seconds.

			}

			else

			{

				$errMSG = "error while inserting....";

			}
		
}
	
		
}

	if(isset($_POST['update']))

	{

		$tid = $_POST['tid'];
		$class = $_POST['class'];
		$subject = $_POST['subject'];				
		$examname = $_POST['examname'];
		$edate = $_POST['edate'];
		$exam_end_date = $_POST['exam_end_date'];
		$quizcount = $_POST['quizcount'];
		$status = $_POST['status'];
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		if($imgFile)

		{

			$upload_dir = 'images/exams/'; // upload directory	

			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif' ,'docx' , 'pdf' , 'video' , 'mp3'); // valid extensions

			$userpic = rand(1,1000000).".".$imgExt;

			if(in_array($imgExt, $valid_extensions))

			{			

				if($imgSize < 5000000)

				{

					//unlink($upload_dir.$edit_row['edocument']);

				 	move_uploaded_file($tmp_dir,$upload_dir.$userpic);

				}

				else

				{

					$errMSG = "Sorry, your file is too large it thould be less then 5MB";

				}

			}

			else

			{

				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		

			}	

		}

		else

		{

			// if no image selected the old image remain as it is.

			//$userpic = $edit_row['edocument']; // old image from database

		}

		if(!isset($errMSG))

		{
		$exid=mysqli_real_escape_string($conn,$_GET['exid']);
		$stmt = $DB_con->prepare('UPDATE lmsonlineexams

									     SET tid=:tid,
											 class=:class,
											 subject=:subject,											 											 
											 examname=:examname,
											 edate=:edate,
											 exam_end_date=:exam_end_date,
										     edocument=:upic,
											 quizcount=:quizcount,
											 status=:status
								       WHERE exid=:exid');

			$stmt->bindParam(':tid',$tid);
			$stmt->bindParam(':class',$class);
			$stmt->bindParam(':subject',$subject);
			$stmt->bindParam(':examname',$examname);	
			$stmt->bindParam(':edate',$edate);
			$stmt->bindParam(':exam_end_date',$exam_end_date);
			$stmt->bindParam(':upic',$userpic);
			$stmt->bindParam(':quizcount',$quizcount);
			$stmt->bindParam(':status',$status);
			$stmt->bindParam(':exid',$exid);
			if($stmt->execute()){
				
				$successMSG = "Online Exams Successfully Updated ...";

				header("refresh:2;online_exams.php"); // redirects image view page after 5 seconds.
			}
			else{
				$errMSG = "Sorry Data Could Not Updated !";
			}
		}
	}


if(isset($_GET['exid'])){
$exid=mysqli_real_escape_string($conn,$_GET['exid']);
$view_qury=mysqli_query($conn,"SELECT *
FROM lmsonlineexams ex
WHERE ex.exid='$exid'");
$view_resalt=mysqli_fetch_assoc($view_qury);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Online Exams | Online Learning Platforms | Dashboard</title>
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
                            <h4>Add Online Exams</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Class Tute</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Online Exams</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add Online Exams</h4>
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
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Teacher</label>
												<select class="form-control" name="tid" required>
													<option value="" hidden="yes"></option>
								<?php

								$stmt = $DB_con->prepare('SELECT * FROM lmstealmsr where status="1" ORDER BY tid');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								?>
								<option <?php if(isset($_GET['exid'])){if($view_resalt['tid']==$row['tid']){echo "selected";}} ?> value="<?php echo $row['tid']; ?>"><?php echo $row['fullname']; ?></option>
								<?php
								} 
								}
								?>
								</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Al Year</label>
												<select class="form-control" name="class" required onChange="JavaScript:send_level(this.value);">
					  <option value="" hidden="lms">Select Al Year</option>
					  <?php
								require_once 'dbconfig4.php';
								$stmt = $DB_con->prepare('SELECT * FROM lmsclass ORDER BY cid');
								$stmt->execute();
								if($stmt->rowCount() > 0)
								{
								while($row=$stmt->fetch(PDO::FETCH_ASSOC))
								{
								extract($row);
								?>
                        <option value="<?php echo $row['cid']; ?>"><?php echo $row['name']; ?></option>
                        <?php } 

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
												<label class="form-label">Class Subject</label>
						<span id="subject_dis">
						<select name="subject" id="" required class="form-control">
						<option hidden="lms"><?php if(isset($_GET['edit'])){echo $edit_resalt['subject'];}else{echo "Subject Not Found";} ?></option>
						</select>
						</span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label class="form-label">Exam Name</label>
												<input type="text" class="form-control" name="examname" placeholder="Enter Exam Name" required value="<?php if(isset($_GET['exid'])){echo $view_resalt['examname'];} ?>">
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Exam Start Date</label>
												<input type="datetime-local" class="form-control" name="edate" placeholder="Select Exam Date" required value="<?php if(isset($_GET['exid'])){ echo date("Y-m-d\TH:i:s",strtotime($view_resalt['edate'])); } ?>">
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
										  <div class="form-group">
											<label class="form-label">Exam End Date</label>
												<input name="exam_end_date" type="datetime-local" required class="form-control" id="exam_end_date" placeholder="Select Exam Date" value="<?php if(isset($_GET['exid'])){ echo date("Y-m-d\TH:i:s",strtotime($view_resalt['exam_end_date'])); } ?>">
											</div>
										</div>
										

										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Upload Document</label>
												<input name="user_image" type="file" required="required" class="form-control">
												<hr>
												<p style="font-weight:bold;color:red;">Note : "Only Upload - Pdf|Docx|Jpg|Png"</p>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">No Of Quiz</label>
												<input type="text" class="form-control" name="quizcount" placeholder="Enter No Of Quiz" required value="<?php if(isset($_GET['exid'])){echo $view_resalt['quizcount'];} ?>">
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Status</label>
												<select class="form-control" name="status" required>
												<option <?php if(isset($_GET['exid'])){if($view_resalt['status']==1){echo "selected";}} ?> value="1">Published</option>
												<option <?php if(isset($_GET['exid'])){if($view_resalt['status']==0){echo "selected";}} ?> value="0">Unpublished</option>
												</select>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<?php if(isset($_GET['exid'])){ ?><input type="submit" name="update" class="btn btn-primary" value="Update Exam"><?php } ?>
											<?php if(!isset($_GET['exid'])){ ?><input type="submit" name="add_exams" class="btn btn-primary" value="Add Exam"><?php } ?>
											<a class="btn btn-light" href="online_exams.php"><i class="fa fa-times"></i> Cancel</a>
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