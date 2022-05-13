<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once 'dbconfig4.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Teacher Payments | Online Learning Platforms | Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link rel="stylesheet" href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
	<!-- Datatable -->
    <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
<style type="text/css">
	.multi-select{
		height: 300px;
		border: 1px solid #DDD;
		overflow-y: scroll;
		padding: 5px;
	}
	.pro_pick{
		width: 120px;
		height: 120px;
		object-fit: cover;
		background-position: center;
		background-repeat: no-repeat;
		border-radius: 100%;
		cursor: pointer;
		border: 1px solid #DDD;
		padding: 5px;
		background: #EEE;
	}
</style>
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
                                        <span class="ml-2"><?php echo $username;?></span>
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
                            <h4>All Teacher Payments</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Teacher Payments</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Teacher Payments</a></li>
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
										<h4 class="card-title">All Teacher Payments</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>ID</th>
														<th>Name</th>
														<th>Percentage</th>
														<th>Total Income</th>
														<th>Company Amount</th>
														<th>Teacher Amount</th>
													</tr>
												</thead>
												<tbody>
								<?php
$tec_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr ORDER BY fullname");
while($tec_resalt=mysqli_fetch_array($tec_qury)){
	
$income_qury=mysqli_query($conn,"SELECT SUM(amount) as total_income FROM lmspayment WHERE feeID='$tec_resalt[tid]' and status='1'");
$icome_resalt=mysqli_fetch_array($income_qury);
	
$pay_qury=mysqli_query($conn,"SELECT SUM(lms_teacher_payment_history_amount) as total_pay FROM lms_teacher_payment_history WHERE lms_teacher_payment_history_tid='$tec_resalt[tid]'");
$pay_resalt=mysqli_fetch_array($pay_qury);

$pay_qury1=mysqli_query($conn,"SELECT SUM(lms_teacher_payment_company_amount) as total_pay1 FROM lms_teacher_payment_history WHERE lms_teacher_payment_history_tid='$tec_resalt[tid]'");
$pay_resalt1=mysqli_fetch_array($pay_qury1);
				  
$a=$icome_resalt['total_income']-($pay_resalt['total_pay']+$pay_resalt1['total_pay1']);

$b=$a/100*$tec_resalt['Percentage'];

$c=$a-$b;

$d=$a-$c;
?>
<tr>
<td><a href="add_new_teacher_payment.php?id=<?php echo $tec_resalt['tid']; ?>" style="color: darkred; cursor: pointer;"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Pay Payment</button></a></td>
<td><?php if($tec_resalt['image']==""){$pro_img="../profile/img/pro_pick.png";}else{$pro_img="images/teacher/".$tec_resalt['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick">
													 <?php echo $tec_resalt['fullname']; ?></td>
<td align="right"><?php echo $tec_resalt['Percentage']."%"; ?></td>
<td align="right"><?php echo number_format($a,2) ?></td>
<td align="right"><?php echo number_format($d,2) ?></td>
<td align="right"><?php echo number_format($c,2) ?></td>
</tr>
<?php
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
$tec_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr ORDER BY fullname");
while($tec_resalt=mysqli_fetch_array($tec_qury)){
	
$income_qury=mysqli_query($conn,"SELECT SUM(amount) as total_income FROM lmspayment WHERE feeID='$tec_resalt[tid]' and status='1'");
$icome_resalt=mysqli_fetch_array($income_qury);
	
$pay_qury=mysqli_query($conn,"SELECT SUM(lms_teacher_payment_history_amount) as total_pay FROM lms_teacher_payment_history WHERE lms_teacher_payment_history_tid='$tec_resalt[tid]'");
$pay_resalt=mysqli_fetch_array($pay_qury);

$pay_qury1=mysqli_query($conn,"SELECT SUM(lms_teacher_payment_company_amount) as total_pay1 FROM lms_teacher_payment_history WHERE lms_teacher_payment_history_tid='$tec_resalt[tid]'");
$pay_resalt1=mysqli_fetch_array($pay_qury1);
				  
$a=$icome_resalt['total_income']-($pay_resalt['total_pay']+$pay_resalt1['total_pay1']);

$b=$a/100*$tec_resalt['Percentage'];

$c=$a-$b;

$d=$a-$c;
?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="card">
											<div class="card-body">
												<div class="text-center">
													<div class="profile-photo">
													<?php if($tec_resalt['image']==""){$pro_img="../profile/img/pro_pick.png";}else{$pro_img="images/teacher/".$tec_resalt['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick">
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $tec_resalt['fullname']; ?></strong></h3>
													<p class="text-muted"><strong>Percentage : <?php echo $tec_resalt['Percentage']."%"; ?></strong></p>
													<ul class="list-group mb-3 list-group-flush">
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Total Income :</span><strong><?php echo number_format($a,2) ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Company Amount :</span><strong><?php echo number_format($d,2) ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Teacher Amount :</span><strong><?php echo number_format($c,2) ?></strong></li>
													</ul>
						<a href="add_new_teacher_payment.php?id=<?php echo $tec_resalt['tid']; ?>" style="color: darkred; cursor: pointer;"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Pay Payment</button></a>
												</div>
											</div>
										</div>
									</div>
<?php
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
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Yogeemedia</a> 2021</p>
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
    <script src="vendor/global/global.min.js"></script>
    <script src="js/deznav-init.js"></script>	
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
	
	<!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>
	
    <!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
	
</body>
</html>