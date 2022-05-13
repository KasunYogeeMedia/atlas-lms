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
    <title>Teacher Payment Reports | Online Learning Platforms | Dashboard</title>
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
                            <h4>All Teacher Payment Reports</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Teacher Payment Reports</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Teacher Payment Reports</a></li>
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
<div class="table-responsive">
				  

<form method="post" class="p-3">
<table>
<tbody>
<tr>
<td>
<select name="filter_text" id="" required class="form-control">
<option value="" hidden="lms">Select Teacher</option>
<?php 
$filter_teacher_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr ORDER BY fullname");
while($filter_teacher_resalt=mysqli_fetch_array($filter_teacher_qury)){
?>
<option value="<?php echo $filter_teacher_resalt['tid']; ?>"><?php echo $filter_teacher_resalt['fullname']; ?></option>
<?php
}
?>
</select>
</td>
<td><button type="submit" name="filter_bt" class="btn btn-success">Filter</button></td>
</tr>
</tbody>
</table>
</form>
				  
<table id="example" class="table table-bordered">
<thead>
<tr>
<th>Action</th>
<th>Subject</th>
<th>Student's</th>
<th>Income</th>
</tr>
</thead>
<tbody>
<?php
if(isset($_POST['filter_bt'])){
	
$user_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr WHERE tid='$_POST[filter_text]'");
$user_resalt=mysqli_fetch_array($user_qury);
				
$sub_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr_multiple INNER JOIN lmssubject ON lmstealmsr_multiple.tealmsr_contain_id=lmssubject.sid WHERE tealmsr_system_id='$user_resalt[systemid]' and tealmsr_type='3' ORDER BY name");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
	
$sum_qury=mysqli_query($conn,"SELECT SUM(amount) AS Amount FROM lmspayment WHERE feeID='$_POST[filter_text]' and pay_sub_id='$sub_resalt[tealmsr_contain_id]'");
$sum_resalt=mysqli_fetch_array($sum_qury);
?>
<tr>
<td><a href="view_student_list.php?feeID=<?php echo $_POST['filter_text']; ?>&pay_sub_id=<?php echo $sub_resalt['tealmsr_contain_id'] ?>"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-users"></i> View</button></a></td>
<td><?php echo $sub_resalt['name']; ?></td>
<td align="center"><?php echo number_format(mysqli_num_rows(mysqli_query($conn,"SELECT DISTINCT userID FROM lmspayment WHERE feeID='$_POST[filter_text]' and pay_sub_id='$sub_resalt[tealmsr_contain_id]'")),0); ?></td>
<td align="right"><?php echo number_format($sum_resalt['Amount'],2); ?></td>
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