<?php
$url = $_SERVER['REQUEST_URI'];
$parts = parse_url($url);
parse_str($parts['query'], $query);
$att_res =  $query['att_res'];
session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once 'dbconfig4.php';

$count_att=mysqli_query($conn,"SELECT COUNT(*) FROM user_attandance WHERE lid = $att_res");
$row = mysqli_fetch_array($count_att);
$total = $row[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Class Schedule | Online Learning Platforms | Dashboard</title>
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
                            <h4>Total Attendence - <?php echo $total ;?></h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Students Attendence</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Students Attendence</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					
					<div class="col-lg-12">
						<div class="row tab-content">
							<div id="list-view" class="tab-pane fade active show col-lg-12">
								<div class="card">
									
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>#</th>
														<th>Student name</th>
														
													</tr>
												</thead>
												<tbody>
<?php
$count=0;
$list_qury=mysqli_query($conn,"SELECT * FROM `lmsregister` INNER JOIN user_attandance ON lmsregister.reid = user_attandance.userid WHERE lid=$att_res; ");

while($list_resalt=mysqli_fetch_array($list_qury)){
$count++;
	
?>
<tr>
<td><?php echo number_format($count,0); ?></td>		
<td style="text-transform: capitalize;"><?php echo $list_resalt['fullname']; ?></td>

													
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
$count=0;
$list_qury=mysqli_query($conn,"SELECT * FROM lmsclass_schlmsle INNER JOIN lmstealmsr ON lmsclass_schlmsle.tealmsr=lmstealmsr.tid ORDER BY classid DESC");

while($list_resalt=mysqli_fetch_array($list_qury)){
$count++;
	
$level_qury=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$list_resalt[level]'");
$level_resalt=mysqli_fetch_array($level_qury);

$subject_qury=mysqli_query($conn,"SELECT * FROM lmsclass_schlmsle WHERE classid='$list_resalt[classid]'");
$subject_resalt=mysqli_fetch_array($subject_qury);
?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="card">
											<div class="card-body">
												<div class="text-center">
													<div class="profile-photo">
													<?php if($subject_resalt['image']==""){$pro_img="../profile/images/hd_dp.jpg";}else{$pro_img="images/class/".$subject_resalt['image'];} ?><img src="<?php echo $pro_img; ?>" class="pro_pick">
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $list_resalt['lesson']; ?></strong></h3>
													<p class="text-muted"><strong>Teacher : <?php echo $list_resalt['fullname']; ?></strong></p>
													<hr>
													<ul class="list-group mb-3 list-group-flush">
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Class Type : </span><strong><?php echo $list_resalt['classtype']; ?></strong></li>
													<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Password : </span><strong><?php echo $subject_resalt['cpassword']; ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">AL Year  : </span><strong><?php echo $level_resalt['name']; ?></strong></li>
														
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Class : </span><strong><?php

						$id = $subject_resalt['subject'];

						require_once 'dbconfig4.php';
								
						$query = $DB_con->prepare('SELECT name FROM lmssubject WHERE sid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

?></strong></li>
														
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Class Time : </span><strong><?php echo date_format(date_create($list_resalt['class_start_time']),"h:i:s A"); ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Class Date : </span><strong><?php echo date_format(date_create($list_resalt['classdate']),"M d, Y"); ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Month :</span><strong><span class="badge badge-success" style="font-size:14px;"> <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($list_resalt['add_date']),"F"); ?></span></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Added Date : </span><strong><?php echo date_format(date_create($list_resalt['add_date2']),"M d, Y - h:i:s A"); ?></strong></li>
														
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Status : </span><strong>
<?php 
						
							if($list_resalt['classstatus'] == "0"){

								echo '<button class="btn btn-primary btn-sm" on>Unpublished</button>';

							}else if($list_resalt['classstatus'] == "1"){

								echo '<button class="btn btn-success btn-sm">Published</button>';

							}else if($list_resalt['classstatus'] == "2"){

								echo '<button class="btn btn-warning btn-sm">Done</button>';

							}else{

								echo '<button class="btn btn-danger btn-sm">Cancel</button>';
							}
						?></strong></li>

													</ul>
<a href="<?php echo $list_resalt['classlink']; ?>" target="_blank" class="btn btn-sm btn-secondary btn-rounded mt-3 px-4"><i class="fa fa-lg fa-video-camera"></i></a>
<a href="add_class_schedule.php?edit=<?php echo $list_resalt['classid']; ?>" class="btn btn-sm btn-primary btn-rounded mt-3 px-4"><i class="fa fa-lg fa-edit"></i></a>
<a href="class_schedule.php?remove=<?php echo $list_resalt['classid']; ?>" onClick="JavaScript:return confirm('Are your sure delete lesson?');" class="btn btn-sm btn-danger btn-rounded mt-3 px-4"><i class="fa fa-lg fa-trash"></i></a>
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