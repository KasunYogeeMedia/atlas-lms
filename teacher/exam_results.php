<?php

session_start();

require_once 'includes.php';

require_once '../dashboard/dbconfig4.php';

require_once("../dashboard/conn.php");

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Exam Results | Teacher Panel | Online Learning Platforms </title>
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
                            <h4>All Exam Results</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Exam Results</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Exam Results</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<ul class="nav nav-pills mb-3">
							<li class="nav-item"><a href="#list-view" data-toggle="tab" class="nav-link btn-primary mr-1 show active">List View</a></li>
							<li class="nav-item"><a href="#grid-view" data-toggle="tab" class="nav-link btn-primary">Grid View</a></li>
						</ul>
					</div>
					<div class="col-lg-12">
						<div class="row tab-content">
							<div id="list-view" class="tab-pane fade active show col-lg-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">All Exam Results</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
										<form method="post">
	
<table class="m-3">
<tbody>
<tr>
<td>
<select name="lms_report_exam_code" id="" class="form-control" required>
<option value="" hidden="lms">Select Exam</option>
<?php 
$join_str="lms_exam_details INNER JOIN lmssubject ON lms_exam_details.lms_exam_subject=subject.id";
$exam_qury=mysqli_query($conn,"SELECT * FROM $join_str WHERE lms_exam_add_user='$_SESSION[tid]' ORDER BY lms_exam_name DESC");
while($exam_resalt=mysqli_fetch_array($exam_qury)){	
?>
<option value="<?php echo $exam_resalt['lms_exam_system_id']; ?>"><?php echo $exam_resalt['lms_exam_name']." - ".$exam_resalt['name']; ?></option>
<?php } ?>
</select>
</td>
<td>
<button type="submit" class="btn btn-success">Filter</button>	
</td>
</tr>
</tbody>
</table>

	
</form>
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>Student</th>
<th>End Time</th>
<th>Total MCQ</th>
<th>Faced</th>
<th>Correct</th>
<th>Percentage</th>
													</tr>
												</thead>
												<tbody>
<?php
if(isset($_POST['lms_report_exam_code'])){
	
$join_str="lms_exam_report INNER JOIN register ON lms_exam_report.lms_report_user=register.reid INNER JOIN lms_exam_details ON lms_exam_report.lms_report_exam_code=lms_exam_details.lms_exam_system_id";
$exam_qury=mysqli_query($conn,"SELECT * FROM $join_str WHERE lms_report_exam_code='$_POST[lms_report_exam_code]' ORDER BY lms_report_end_time DESC");
while($exam_resalt=mysqli_fetch_array($exam_qury)){
	
$resalt_qury=mysqli_query($conn,"SELECT * FROM lms_answer INNER JOIN lms_question_answer ON lms_answer.lms_answer_q=lms_question_answer.lms_question_answer_id WHERE lms_answer_identify='$exam_resalt[lms_report_exam_id]'");
	
$cont_answer=mysqli_num_rows($resalt_qury);

$corr_count=0;
while($count_resalt=mysqli_fetch_array($resalt_qury)){
	if($count_resalt['lms_answer_a']==$count_resalt['lms_answer_correct']){
		$corr_count++;
	}	
}	
$a=100/$exam_resalt['lms_exam_question'];
$b=$a*$corr_count;
?>
                    <tr>
						<td><?php echo $exam_resalt['fullname']; ?></td>
                        <td><?php echo date_format(date_create($exam_resalt['lms_report_end_time']),"M d, Y - h:i:s A"); ?></td>
						<td><?php echo $exam_resalt['lms_exam_question']; ?></td>
						<td><?php echo $cont_answer; ?></td>
						<td><?php echo $corr_count; ?></td>
						<td><?php echo $b; ?>%</td>		
													</tr>
<?php
}
}
?>
												</tbody>
											</table>
										</div>
									</div>
                                </div>
                            </div>
							<div id="grid-view" class="tab-pane fade col-lg-12">
								<div class="row">
								<tbody>
								<?php

								$stmt = $DB_con->prepare('SELECT * FROM lmslesson ORDER BY lid');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{

								extract($row);

								?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="card">
											<div class="card-body">
												<div class="text-center">
													<div class="profile-photo">
													<iframe width="100%" height="250" src="<?php echo $row['video']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $row['title']; ?></strong></h3>
													<ul class="list-group mb-3 list-group-flush">
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Teacher :</span><strong><?php

						$id = $row['tid']; 

						$query = $DB_con->prepare('SELECT fullname FROM lmstealmsr WHERE tid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['fullname'];

						 ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Type :</span><strong><?php echo $row['type']; ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Al Year :</span><strong><?php

						$id = $row['class']; 

						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

						 ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Class :</span><strong><?php

						$id = $row['subject']; 

						$query = $DB_con->prepare('SELECT name FROM lmssubject WHERE sid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

						?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Status :</span><strong><?php 
						
							if($row['status'] == "0"){

								echo '<button class="btn btn-primary btn-sm" on>Pending</button>';

							}else if($row['status'] == "1"){

								echo '<button class="btn btn-success btn-sm">Success</button>';

							}
						
						?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Added Date :</span><strong><?php echo $row['add_date']; ?></strong></li>
													</ul>
						<a class="btn btn-primary btn-rounded mt-3 px-4" href="edit_video_lessons.php?leid=<?php echo $row["lid"]; ?>">
						<i class="fa fa-edit"></i> 
						</a>
						<a class="btn btn-danger btn-rounded mt-3 px-4" href="delete_video_lessons.php?leid=<?php echo $row["lid"]; ?>">
						<i class="fa fa-times-circle"></i> 
						</a>
												</div>
											</div>
										</div>
									</div>
<?php } 

								}
								?>
								</div>
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