<?php

session_start();

require_once 'includes.php';

require_once '../dashboard/conn.php';

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

date_default_timezone_set("Asia/Colombo");

if(isset($_GET['lms_exam_system_id'])){
	$lms_exam_system_id=mysqli_real_escape_string($conn,$_GET['lms_exam_system_id']);	
}

if(isset($_POST['update_bt'])){	
	$edit=mysqli_real_escape_string($conn,$_GET['edit']);
	$lms_question=mysqli_real_escape_string($conn,$_POST['lms_question']);
	$lms_answer1=mysqli_real_escape_string($conn,$_POST['lms_answer1']);
	$lms_answer2=mysqli_real_escape_string($conn,$_POST['lms_answer2']);
	$lms_answer3=mysqli_real_escape_string($conn,$_POST['lms_answer3']);
	$lms_answer4=mysqli_real_escape_string($conn,$_POST['lms_answer4']);
	$lms_answer_correct=mysqli_real_escape_string($conn,$_POST['lms_answer_correct']);
	if(mysqli_query($conn,"UPDATE lms_question_answer SET lms_question='$lms_question',lms_answer1='$lms_answer1',lms_answer2='$lms_answer2',lms_answer3='$lms_answer3',lms_answer4='$lms_answer4',lms_answer_correct='$lms_answer_correct' WHERE lms_question_answer_id='$edit'")){
		echo "<script>window.location='add_question.php?update&lms_exam_system_id=$lms_exam_system_id';</script>";
	}
	else{
		echo "<script>window.location='add_question.php?update_fail&lms_exam_system_id=$lms_exam_system_id';</script>";
	}
}

if(isset($_POST['add_bt'])){
	$lms_question_answer_time=date("Y-m-d H:i:s");	
	$lms_question=mysqli_real_escape_string($conn,$_POST['lms_question']);
	$lms_answer1=mysqli_real_escape_string($conn,$_POST['lms_answer1']);
	$lms_answer2=mysqli_real_escape_string($conn,$_POST['lms_answer2']);
	$lms_answer3=mysqli_real_escape_string($conn,$_POST['lms_answer3']);
	$lms_answer4=mysqli_real_escape_string($conn,$_POST['lms_answer4']);
	$lms_answer_correct=mysqli_real_escape_string($conn,$_POST['lms_answer_correct']);
		
	if(mysqli_query($conn,"INSERT INTO lms_question_answer(lms_question_answer_examid, lms_question, lms_answer1, lms_answer2, lms_answer3, lms_answer4, lms_answer_correct, lms_question_answer_time) VALUES ('$lms_exam_system_id','$lms_question','$lms_answer1','$lms_answer2','$lms_answer3','$lms_answer4','$lms_answer_correct','$lms_question_answer_time')")){
		echo "<script>window.location='add_question.php?success&lms_exam_system_id=$lms_exam_system_id';</script>";
	}
	else{
		echo "<script>window.location='add_question.php?fail&lms_exam_system_id=$lms_exam_system_id';</script>";
	}
}

if(isset($_GET['remove'])){
	$remove=mysqli_real_escape_string($conn,$_GET['remove']);
	mysqli_query($conn,"DELETE FROM lms_question_answer WHERE lms_question_answer_id='$remove'");
	echo "<script>window.location='add_question.php?removed&lms_exam_system_id=$lms_exam_system_id';</script>";
}

if(isset($_GET['edit'])){
	$edit=mysqli_real_escape_string($conn,$_GET['edit']);
	$edit_qury=mysqli_query($conn,"SELECT * FROM lms_question_answer WHERE lms_question_answer_id='$edit'");
	$edit_resalt=mysqli_fetch_array($edit_qury);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Question | Teacher Panel | Online Learning Platforms </title>
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
                            <h4>Add Question</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Add Question</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Question</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add Question | <?php echo $lms_exam_system_id; ?></h4>
							</div>
							<div class="card-body">
							<?php if(isset($_GET['update'])){ ?>
							<div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> Exam Details Updated Successfully..
							</div>
							<?php

							}

							?>
							
							<?php if(isset($_GET['success'])){ ?><div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> New Question Added Successfully.</div><?php } ?>
							<?php if(isset($_GET['removed'])){ ?><div class="alert alert-danger alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> Question Removed Successfully.</div><?php } ?>
							<?php if(isset($_GET['update'])){ ?><div class="alert alert-primary alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> Question Updated Successfully.</div><?php } ?>
								<form method="post" autocomplete="off">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Question</label>
												<input name="lms_question" type="text" class="form-control" id="" required value="<?php if(isset($_GET['edit'])){echo $edit_resalt['lms_question'];} ?>">
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Subject</label>
												 <select name="lms_exam_subject" id="" class="form-control" required>
        <option value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_subject'];} ?>" hidden="lms"><?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['name']." - ".$edit_resalt['course']." - ".$edit_resalt['class'];}else{echo "Choose...";} ?></option>
		  <?php 
		  $sub_qury=mysqli_query($conn,"SELECT * FROM lmssubject ORDER BY name");
		  while($sub_resalt=mysqli_fetch_array($sub_qury)){
		  ?>
        <option value="<?php echo $sub_resalt['sid']; ?>"><?php echo $sub_resalt['name']; ?>-<?php						$id = $sub_resalt['class_id'];						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);						$query->execute();						$result = $query->fetch();						echo $result['name'];						?></option>
		  <?php 
		  }
		  ?>
      </select>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
										<div class="form-group">
												<label class="form-label">Time Duration (Enter in minutes)</label>
												<input name="lms_exam_time_duration" type="text" class="form-control" pattern="\d*" value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_time_duration'];} ?>" required>
										</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Questions Per Paper</label>
												<input name="lms_exam_question" type="text" class="form-control" pattern="\d*" value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_question'];} ?>" required>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<button name="<?php if(isset($_GET['lms_exam_id'])){echo "update_bt";}else{echo "add_bt";} ?>" type="submit" class="btn btn-primary"><?php if(isset($_GET['lms_exam_id'])){echo "Update Exam";}else{echo "Add Exam";} ?></button>
											<a class="btn btn-light" href="video_lessons.php"><i class="fa fa-times"></i> Cancel</a>
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
	
	<!-- Datatable -->
    <script src="../dashboard/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../dashboard/js/plugins-init/datatables.init.js"></script>
	
    <!-- Svganimation scripts -->
    <script src="../dashboard/vendor/svganimation/vivus.min.js"></script>
    <script src="../dashboard/vendor/svganimation/svg.animation.js"></script>
	
</body>
</html>