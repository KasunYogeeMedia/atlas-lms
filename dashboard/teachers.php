<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once 'dbconfig4.php';

if(isset($_GET['delete'])){
	$delete=mysqli_real_escape_string($conn,$_GET['delete']);
	mysqli_query($conn,"DELETE FROM lmstealmsr WHERE tid='$delete'");
	echo "<script>window.location='teachers.php';</script>";
}

if(isset($_GET['status'])&&isset($_GET['type'])){
	$status=mysqli_real_escape_string($conn,$_GET['status']);
	$type=mysqli_real_escape_string($conn,$_GET['type']);
	
	if($type==1){
		$update=0;
	}
	if($type==0){
		$update=1;
	}
	
	mysqli_query($conn,"UPDATE lmstealmsr SET status='$update' WHERE tid='$status'");
	
	echo "<script>window.location='teachers.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Teachers | Online Learning Platforms | Dashboard</title>
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
                            <h4>All Teachers</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Teachers</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Teachers</a></li>
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
										<h4 class="card-title">All Teachers </h4>
										<a href="add_teacher.php" class="btn btn-square btn-secondary">+ Add Teacher</a>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>#</th>
														<th>Profile</th>
													    <th>Action</th>
														<th>Status</th>
														<th>Name</th>
														<th>Phone</th>
														<th>Email</th>
														<th>Al Year</th>
														<th>Classes</th>
														<th>Qualification</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$count=0;
												$tec_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr ORDER BY fullname");
												while($tec_resalt=mysqli_fetch_array($tec_qury)){
												$count++;
												?>
													<tr>
													<td><?php echo number_format($count,0); ?></td>
<td><?php if($tec_resalt['image']==""){$pro_img="../profile/images/hd_dp.jpg";}else{$pro_img="images/teacher/".$tec_resalt['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick"></td>
<td style="white-space: nowrap">
<a href="edit_teacher.php?edit=<?php echo $tec_resalt['tid']; ?>" title="Edit" class="btn btn-sm btn-primary" style="margin-right: 5px;"><i class="la la-pencil"></i></a>
<a href="teachers.php?status=<?php echo $tec_resalt['tid']; ?>&type=<?php echo $tec_resalt['status']; ?>" title="Status Change" style="margin-right: 5px;" onClick="JavaScript:return confirm('Are you sure change this status?');" class="btn btn-sm btn-secondary"><i class="fa fa-lg fa-cogs" style="color: darkblue;"></i></a>
<a href="teachers.php?delete=<?php echo $tec_resalt['tid']; ?>" title="Delete" onClick="JavaScript:return confirm('Are you sure delete this teacher?');" class="btn btn-sm btn-danger"><i class="la la-trash-o"></i></a>	
</td>
<td align="center">
<?php
if($tec_resalt['status']==1){
?>
<span class="btn btn-success btn-sm">Active</span>
<?php
}
if($tec_resalt['status']==0){
?>
<span class="btn btn-primary btn-sm">Deactive</span>
<?php
}
?>	
</td>
<td style="text-transform: capitalize;"><?php echo $tec_resalt['fullname']; ?></td>
<td><?php echo "0".(int)$tec_resalt['contactnumber']; ?></td>
<td><?php echo $tec_resalt['username']; ?></td>
<td>
<?php
$level_array=array();
$level_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr_multiple INNER JOIN lmsclass ON lmstealmsr_multiple.tealmsr_contain_id=lmsclass.cid WHERE tealmsr_system_id='$tec_resalt[systemid]' and tealmsr_type='2'");
while($level_resalt=mysqli_fetch_array($level_qury)){
array_push($level_array,"• ".$level_resalt['name']);
}
echo join("<br>",$level_array);
?>	
</td>
<td>
<?php
$subject_array=array();
$subject_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr_multiple INNER JOIN lmssubject ON lmstealmsr_multiple.tealmsr_contain_id=lmssubject.sid WHERE tealmsr_system_id='$tec_resalt[systemid]' and tealmsr_type='3'");
while($subject_resalt=mysqli_fetch_array($subject_qury)){
array_push($subject_array,"• ".$subject_resalt['name']);
}
echo join("<br>",$subject_array);
?>	
</td>
<td><?php echo $tec_resalt['qualification']; ?></td>										
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
								<tbody>
												<?php
												$count=0;
												$tec_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr ORDER BY fullname");
												while($tec_resalt=mysqli_fetch_array($tec_qury)){
												$count++;
												?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="card">
											<div class="card-body">
												<div class="text-center">
													<div class="profile-photo">
													<?php if($tec_resalt['image']==""){$pro_img="../profile/images/hd_dp.jpg";}else{$pro_img="images/teacher/".$tec_resalt['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick">
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $tec_resalt['fullname']; ?></strong></h3>
													<p class="text-muted"><strong>AL Year : <?php
$level_array=array();
$level_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr_multiple INNER JOIN lmsclass ON lmstealmsr_multiple.tealmsr_contain_id=lmsclass.cid WHERE tealmsr_system_id='$tec_resalt[systemid]' and tealmsr_type='2'");
while($level_resalt=mysqli_fetch_array($level_qury)){
array_push($level_array,"• ".$level_resalt['name']);
}
echo join("<br>",$level_array);
?></strong></p>
													<p class="text-muted"><strong>Class : <?php
$subject_array=array();
$subject_qury=mysqli_query($conn,"SELECT * FROM lmstealmsr_multiple INNER JOIN lmssubject ON lmstealmsr_multiple.tealmsr_contain_id=lmssubject.sid WHERE tealmsr_system_id='$tec_resalt[systemid]' and tealmsr_type='3'");
while($subject_resalt=mysqli_fetch_array($subject_qury)){
array_push($subject_array,"• ".$subject_resalt['name']);
}
echo join("<br>",$subject_array);
?></strong></p>
													<hr>
													<p class="text-muted"><strong>Qualification : <?php echo $tec_resalt['qualification']; ?></strong></p>
													<ul class="list-group mb-3 list-group-flush">
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">User : </span><strong><?php echo $tec_resalt['username']; ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Contact No : </span><strong><?php echo "0".(int)$tec_resalt['contactnumber']; ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Status : </span><strong>
						<?php
if($tec_resalt['status']==1){
?>
<span class="btn btn-success btn-sm">Active</span>
<?php
}
if($tec_resalt['status']==0){
?>
<span class="btn btn-primary btn-sm">Deactive</span>
<?php
}
?></strong></li>

													</ul>
<a href="edit_teacher.php?edit=<?php echo $tec_resalt['tid']; ?>" title="Edit" class="btn btn-primary btn-rounded mt-3 px-4"><i class="la la-pencil"></i></a>
<a href="teachers.php?status=<?php echo $tec_resalt['tid']; ?>&type=<?php echo $tec_resalt['status']; ?>" title="Status Change" class="btn btn-success btn-rounded mt-3 px-4" onClick="JavaScript:return confirm('Are you sure change this status?');" class="btn btn-sm btn-secondary"><i class="fa fa-lg fa-cogs" style="color: darkblue;"></i></a>
<a href="teachers.php?delete=<?php echo $tec_resalt['tid']; ?>" title="Delete" class="btn btn-danger btn-rounded mt-3 px-4" onClick="JavaScript:return confirm('Are you sure delete this teacher?');"><i class="la la-trash-o"></i></a>	

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