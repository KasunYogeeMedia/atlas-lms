<?php

session_start();

require_once 'includes.php';

require_once("../dashboard/conn.php");

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home | Teacher Panel | Online Learning Platforms </title>
	
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../dashboard/images/favicon.png">
    <link rel="stylesheet" href="../dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
	<!-- Datatable -->
    <link href="../dashboard/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dashboard/css/style.css">

</head>
<body>

    <?php
	require_once 'preloader.php';
	?>

   
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
                <img class="logo-compact" src="../dashboard/../dashboard/images/logo-text-white.png" alt="">
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
        <div class="content-wrapper">
<div class="container-fluid">

<h4>Dashboard</h4><hr>
	
<table>
<tbody>
<tr>
<td><img src="<?php echo $image_path; ?>" class="pro_pick"></td>
<td style="padding-left: 20px;"><h3><?php echo $user_resalt['fullname']; ?></h3>
<p style="color: #999999;"><?php echo $user_resalt['qualification']; ?></p>
<p style="color: #999999;"><?php echo "0".(int)$user_resalt['contactnumber']; ?></p>
<p style="color: #999999;">Status:
<?php if($user_resalt['status']==1){ ?>
<span class="badge badge-rounded badge-success">Active</span>
<?php } ?>
<?php if($user_resalt['status']==0){ ?>
<span class="badge badge-rounded badge-danger">Deactive</span>
<?php } ?>	
</p>
<!--<a href="profile.php"><i class="fa fa-edit"></i> Edit My Profile</a>-->
</td>
</tr>
</tbody>
</table>
<hr>
<div class="row">
					<div class="col-xl-12 col-xxl-12 col-sm-12">
						<div class="row">
						<div class="col-xl-4 col-xxl-4 col-sm-6">
						<div class="widget-stat card bg-success">
							<div class="card-body">
								<div class="media">
									<span class="mr-3">
										<i class="la la-slideshare"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Classes</p>
										<h3 class="text-white"><?php
$my_class=mysqli_query($conn,"SELECT * FROM lmsclass_schlmsle WHERE tealmsr='$_SESSION[tid]'");
echo number_format(mysqli_num_rows($my_class),0);
?>	</h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-4 col-xxl-4 col-sm-6">
						<div class="widget-stat card bg-primary">
							<div class="card-body">
								<div class="media">
									<span class="mr-3">
										<i class="la la-book"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Tutes</p>
										<h3 class="text-white"><?php
$my_tute=mysqli_query($conn,"SELECT * FROM lmsclasstute WHERE tid='$_SESSION[tid]'");
echo number_format(mysqli_num_rows($my_tute),0);
?></h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-4 col-xxl-4 col-sm-6">
						<div class="widget-stat card bg-warning">
							<div class="card-body">
								<div class="media">
									<span class="mr-3">
										<i class="la la-play-circle-o"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Videos</p>
										<h3 class="text-white"><?php
$my_videos=mysqli_query($conn,"SELECT * FROM lmslesson WHERE tid='$_SESSION[tid]'");
echo number_format(mysqli_num_rows($my_videos),0);
?></h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-4 col-xxl-4 col-sm-6">
						<div class="widget-stat card bg-secondary">
							<div class="card-body">
								<div class="media">
									<span class="mr-3">
										<i class="la la-black-tie"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Total Student</p>
										<h3 class="text-white"><?php
$student_count=mysqli_query($conn,"SELECT COUNT(feeID) count
FROM lmspayment
WHERE feeID='$_SESSION[tid]'
GROUP BY feeID");
$student_resalt=mysqli_fetch_assoc($student_count);
echo $student_resalt['count'];
?></h3>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-xl-8 col-xxl-8 col-sm-6">
						<div class="widget-stat card bg-danger">
							<div class="card-body">
								<div class="media">
									<span class="mr-3">
										<i class="la la-money"></i>
									</span>
									<div class="media-body text-white">
										<p class="mb-1">Time Period : <?php echo date("Y-m-01"); ?> to <?php echo date("Y-m-t", strtotime(date("Y-m-d"))); ?></p>
										<h3 class="text-white">Current Income : <?php
$start=date("Y-m-01");
$end=date("Y-m-t", strtotime(date("Y-m-d")));
$payment_count=mysqli_query($conn,"SELECT SUM(amount) amount
FROM lmspayment
WHERE feeID='$_SESSION[tid]' AND status=1 AND created_at BETWEEN '$start' AND '$end'
GROUP BY feeID");
$payment_resalt=mysqli_fetch_assoc($payment_count);
echo 'Rs '.number_format((float)$payment_resalt['amount'],2);
?></h3>
									</div>
								</div>
							</div>
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

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../dashboard/vendor/global/global.min.js"></script>
	<script src="../dashboard/js/deznav-init.js"></script>
	<script src="../dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../dashboard/js/custom.min.js"></script>
		
    <!-- Chart Morris plugin files -->
    <script src="../dashboard/vendor/raphael/raphael.min.js"></script>
    <script src="../dashboard/vendor/morris/morris.min.js"></script>
		
	
	<!-- Chart piety plugin files -->
    <script src="../dashboard/vendor/peity/jquery.peity.min.js"></script>
	
		<!-- Demo scripts -->
    <script src="../dashboard/js/dashboard/dashboard-2.js"></script>
	
	<!-- Svganimation scripts -->
    <script src="../dashboard/vendor/svganimation/vivus.min.js"></script>
    <script src="../dashboard/vendor/svganimation/svg.animation.js"></script>
    
</body>
</html>