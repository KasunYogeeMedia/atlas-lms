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

if(isset($_GET['remove'])){
	$id=mysqli_real_escape_string($conn,$_GET['remove']);
	$exam_id=mysqli_real_escape_string($conn,$_GET['exam_id']);
	if(mysqli_query($conn,"DELETE FROM lms_mcq_questions WHERE id='$id'")){
		header("location:q_list.php?exam_id=$exam_id");
	}
}

$exam_id=mysqli_real_escape_string($conn,$_GET['exam_id']);
$q_qury=mysqli_query($conn,"SELECT * FROM lms_exam_details WHERE lms_exam_id='$exam_id'");
$q_resalt=mysqli_fetch_assoc($q_qury);

$mcq_qury=mysqli_query($conn,"SELECT COUNT(*) total_mcq FROM lms_mcq_questions WHERE exam_id='$exam_id'");
$mcq_resalt=mysqli_fetch_assoc($mcq_qury);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Question Teacher Panel | Online Learning Platforms |  demolms.lk</title>
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
                            <h4>Questions List</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Questions List</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Questions List</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Questions List</h4>
								<?php if($q_resalt['lms_exam_question']<=$mcq_resalt['total_mcq']){}else{ ?><a href="add_question_new.php?exam_id=<?php echo $_GET['exam_id']; ?>" class="btn btn-dark">New questions</a><?php } ?>
							</div>
							<div class="card-body">
						
							<?php if(isset($_GET['added_success'])){ ?><div class="alert alert-success alert-dismissible alert-alt solid fade show"><strong>Success!</strong> New Question Added Successfully.</div><?php } ?>
							<?php if(isset($_GET['question_empty'])){ ?><div class="alert alert-danger alert-dismissible alert-alt solid fade show"><strong>Fail!</strong> Please enter your question.</div><?php } ?>

Questions: <?php echo $q_resalt['lms_exam_question']; ?>/<?php echo $mcq_resalt['total_mcq']; ?>
								
<?php if($q_resalt['lms_exam_question']<=$mcq_resalt['total_mcq']){ ?><br><em class="text-success">All questions are completed for the exam.</em><?php }else{ ?><br><em class="text-danger">All questions are not completed for the exam.</em><?php } ?>
								
<table class="table">
<tbody>
<tr>
<td>#No</td>
<td>Action</td>
<td>Questions</td>
</tr>
	
<?php 
$q_count=0;
$q_list_qury=mysqli_query($conn,"SELECT * FROM lms_mcq_questions WHERE exam_id='$_GET[exam_id]' ORDER BY exam_id");
while($q_list_resalt=mysqli_fetch_assoc($q_list_qury)){
$q_count++;
?>
<tr>
<td><?php echo $q_count; ?></td>
<td style="white-space: nowrap;">
<a href="add_question_new.php?id=<?php echo $q_list_resalt['id']; ?>&exam_id=<?php echo $_GET['exam_id']; ?>" class="btn btn-dark btn-sm"><i class="fa fa-edit"></i></a>
<a href="q_list.php?remove=<?php echo $q_list_resalt['id']; ?>&exam_id=<?php echo $_GET['exam_id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure to remove this question?');"><i class="fa fa-trash"></i></a>
</td>
<td><?php echo $q_list_resalt['question']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>

								
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
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Yogee Media</a> 2021</p>
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

    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

	
</body>
</html>