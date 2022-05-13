<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once("config.php");

require_once 'dbconfig4.php';

date_default_timezone_set("Asia/Colombo");

if(isset($_POST['update_bt'])){
	$lms_exam_add_user=mysqli_real_escape_string($conn,$_POST['lms_exam_add_user']);
	$lms_exam_id=mysqli_real_escape_string($conn,$_GET['lms_exam_id']);
	$lms_exam_name=mysqli_real_escape_string($conn,$_POST['lms_exam_name']);
	$lms_exam_subject=mysqli_real_escape_string($conn,$_POST['lms_exam_subject']);
	$lms_exam_question=mysqli_real_escape_string($conn,$_POST['lms_exam_question']);
	$lms_exam_time_duration=mysqli_real_escape_string($conn,$_POST['lms_exam_time_duration']);
	$lms_exam_start_time=mysqli_real_escape_string($conn,$_POST['lms_exam_start_time']);
	$lms_exam_end_time=mysqli_real_escape_string($conn,$_POST['lms_exam_end_time']);
	$lms_exam_pay_type=mysqli_real_escape_string($conn,$_POST['lms_exam_pay_type']);
	
	if(mysqli_query($conn,"UPDATE lms_exam_details SET lms_exam_add_user='$lms_exam_add_user',lms_exam_name='$lms_exam_name',lms_exam_subject='$lms_exam_subject',lms_exam_question='$lms_exam_question',lms_exam_start_time='$lms_exam_start_time',lms_exam_end_time='$lms_exam_end_time',lms_exam_time_duration='$lms_exam_time_duration',lms_exam_pay_type='$lms_exam_pay_type' WHERE lms_exam_id='$lms_exam_id'")){
		echo "<script>window.location='new_exam.php?update&lms_exam_id=$lms_exam_id';</script>";
	}
	else{
		echo "<script>window.location='new_exam.php?update_fail&lms_exam_id=$lms_exam_id';</script>";
	}
}

if(isset($_POST['add_bt'])){
	$lms_exam_name=mysqli_real_escape_string($conn,$_POST['lms_exam_name']);
	$lms_exam_add_user=mysqli_real_escape_string($conn,$_POST['lms_exam_add_user']);
	$lms_exam_subject=mysqli_real_escape_string($conn,$_POST['lms_exam_subject']);
	$lms_exam_question=mysqli_real_escape_string($conn,$_POST['lms_exam_question']);
	$lms_exam_time_duration=mysqli_real_escape_string($conn,$_POST['lms_exam_time_duration']);
	$lms_exam_start_time=mysqli_real_escape_string($conn,$_POST['lms_exam_start_time']);
	$lms_exam_end_time=mysqli_real_escape_string($conn,$_POST['lms_exam_end_time']);
	$lms_exam_pay_type=mysqli_real_escape_string($conn,$_POST['lms_exam_pay_type']);
	$lms_exam_system_id=time();
	$lms_exam_add_time=date("Y-m-d H:i:s");
	
	if(mysqli_query($conn,"INSERT INTO
	lms_exam_details(lms_exam_add_user,lms_exam_system_id, lms_exam_name, lms_exam_subject, lms_exam_question, lms_exam_time_duration, lms_exam_start_time, lms_exam_end_time, lms_exam_add_time, lms_exam_pay_type)
	VALUES ('$lms_exam_add_user','$lms_exam_system_id','$lms_exam_name','$lms_exam_subject','$lms_exam_question','$lms_exam_time_duration','$lms_exam_start_time','$lms_exam_end_time','$lms_exam_add_time','$lms_exam_pay_type')")){
		echo "<script>window.location='exam.php?success';</script>";
	}
	else{
		echo "<script>window.location='new_exam.php?fail';</script>";
	}
}

if(isset($_GET['lms_exam_id'])){
	$lms_exam_id=mysqli_real_escape_string($conn,$_GET['lms_exam_id']);
	$join_str="lms_exam_details INNER JOIN lmssubject ON lms_exam_details.lms_exam_subject=lmssubject.sid";
	$edit_qury=mysqli_query($conn,"SELECT * FROM $join_str WHERE lms_exam_id='$lms_exam_id'");
	$edit_resalt=mysqli_fetch_array($edit_qury);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add New Exam | Online Learning Platforms | Dashboard</title>
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
                            <h4>Add New Exam</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">New Exam</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add New Exam</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add New Exam</h4>
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
								<form method="POST" enctype="multipart/form-data">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Exam Name</label>
												<input name="lms_exam_name" type="text" class="form-control" value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_name'];} ?>" required>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Teacher</label>
												 <select name="lms_exam_add_user" class="form-control" required>
		  <?php 
		  $tec_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr ORDER BY fullname");
		  while($tec_resalt=mysqli_fetch_array($tec_qury)){
		  ?>
        <option value="<?php echo $tec_resalt['tid']; ?>"><?php echo $tec_resalt['fullname']; ?></option>
		  <?php 
		  }
		  ?>
      </select>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Grade/Subject</label>
												 <select name="lms_exam_subject" id="" class="form-control" required>
        <option value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_subject'];} ?>" hidden="yes"><?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['name'];}else{echo "Choose...";} ?></option>
		  <?php 
		  $sub_qury=mysqli_query($conn,"SELECT * FROM lmssubject ORDER BY name");
		  while($sub_resalt=mysqli_fetch_array($sub_qury)){
		  ?>
        <option value="<?php echo $sub_resalt['sid']; ?>"><?php echo $sub_resalt['name']; ?>  -  [<?php

						$id = $sub_resalt['class_id'];

						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

					  ?>]</option>
		  <?php 
		  }
		  ?>
      </select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
										<div class="form-group">
												<label class="form-label">Time Duration (Enter in minutes)</label>
												<input name="lms_exam_time_duration" type="text" class="form-control" pattern="\d*" value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_time_duration'];} ?>" required>
										</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Questions Per Paper</label>
												<input name="lms_exam_question" type="text" class="form-control" pattern="\d*" value="<?php if(isset($_GET['lms_exam_id'])){echo $edit_resalt['lms_exam_question'];} ?>" required>
											</div>
										</div>
										
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Start Time</label>
												<input name="lms_exam_start_time" type="datetime-local" required class="form-control" id="lms_exam_start_time" pattern="\d*" value="<?php if(isset($_GET['lms_exam_id'])){echo date("Y-m-d\TH:i:s",strtotime($edit_resalt['lms_exam_start_time']));} ?>">
											</div>
										</div>
										
										<div class="col-lg-3 col-md-3 col-sm-12">
										  <div class="form-group">
											<label class="form-label">End Time</label>
											  <input name="lms_exam_end_time" type="datetime-local" required class="form-control" id="lms_exam_end_time" pattern="\d*" value="<?php if(isset($_GET['lms_exam_id'])){echo date("Y-m-d\TH:i:s",strtotime($edit_resalt['lms_exam_end_time']));} ?>">
											</div>
										</div>
										
										<div class="col-lg-2 col-md-2 col-sm-12">
										  <div class="form-group">
											<label class="form-label">Payment Type</label>
											  <select name="lms_exam_pay_type" required="required" class="form-control" id="lms_exam_pay_type">
												  <option value="" hidden="yes">-Select-</option>
												  <option <?php if(isset($_GET['lms_exam_id'])){if($edit_resalt['lms_exam_pay_type']==1){echo "selected";}} ?> value="1">Payed</option>
												  <option <?php if(isset($_GET['lms_exam_id'])){if($edit_resalt['lms_exam_pay_type']==0){echo "selected";}} ?> value="0">Free</option>
											  </select>
										  </div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
											<button name="<?php if(isset($_GET['lms_exam_id'])){echo "update_bt";}else{echo "add_bt";} ?>" type="submit" class="btn btn-primary"><?php if(isset($_GET['lms_exam_id'])){echo "Update Exam";}else{echo "Add Exam";} ?></button>
											<a class="btn btn-light" href="exam.php"><i class="fa fa-times"></i> Cancel</a>
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