<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once 'dbconfig4.php';

if(isset($_GET['exid'])){
	$exid=mysqli_real_escape_string($conn,$_GET['exid']);
	if(mysqli_query($conn,"DELETE FROM lmsonlineexams WHERE exid='$exid'")){
	header("location:online_exams.php");
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Online Exams | Online Learning Platforms | Dashboard</title>
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
                            <h4>All Online Exams</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Online Exams</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Online Exams</a></li>
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
										<h4 class="card-title">All Online Exams</h4>
										<a href="add_online_exams.php" class="btn btn-square btn-secondary">+ Add Online Exams</a>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-bordered">
												<thead>
													<tr>
														<th>ID</th>
														<th>Option</th>
														<th>Action</th>									
														<th>Al Year</th>
														<th>Class Subject</th>						
														<th>Exam</th>
														<th>Exam Post</th>
														<th>Time</th>
														<th>Document</th>
														<th>No Of Quiz</th>
													</tr>
												</thead>
												<tbody>
								<?php
$no_count=0;
								$stmt = $DB_con->prepare('SELECT * FROM lmsonlineexams ORDER BY exid DESC');

								$stmt->execute();

								if($stmt->rowCount() > 0)

								{

								while($row=$stmt->fetch(PDO::FETCH_ASSOC))

								{
									$no_count++;
								extract($row);

								?>
													<tr>
													<td><?php echo $no_count; ?></td>
						<td>
						<?php 
						
							if($row['status'] == "0"){

								echo '<button class="btn btn-primary btn-sm" on>Pending</button>';

							}else if($row['status'] == "1"){

								echo '<button class="btn btn-success btn-sm">Published</button>';

							}
						
						?>
						</td>
						<td style="white-space: nowrap;">
						<a class="btn btn-sm btn-primary" href="add_online_exams.php?exid=<?php echo $row["exid"]; ?>">
						<i class="fa fa-edit"></i> 
						</a>
						<a class="btn btn-sm btn-danger" href="online_exams.php?exid=<?php echo $row["exid"]; ?>" onClick="return confirm('Are you sure to remove the exam?');">
						<i class="fa fa-times-circle"></i>
						</a>
						</td>                                            										
						<td><?php

						$id = $row['class']; 

						$query = $DB_con->prepare('SELECT name FROM lmsclass WHERE cid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

						 ?></td>
						<td>
						<?php

						$id = $row['subject']; 

						$query = $DB_con->prepare('SELECT name FROM lmssubject WHERE sid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['name'];

						?>
						</td>												
						<td><?php echo $row['examname']; ?></td>
						<td style="white-space: nowrap;"><?php echo date("Y-m-d h:i:s A",strtotime($row['add_date'])); ?></td>
						<td style="white-space: nowrap;">Start: <?php echo date("Y-m-d h:i:s A",strtotime($row['edate'])); ?><br>End: <?php echo date("Y-m-d h:i:s A",strtotime($row['exam_end_date'])); ?></td>
						<td><a class="btn btn-success btn-rounded mt-3 px-4" href="images/exams/<?php echo $row['edocument']; ?>" target="_blank">View Paper</a></td>
						<td><?php echo $row['quizcount']; ?></td>									
													</tr>
								<?php } 

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

								$stmt = $DB_con->prepare('SELECT * FROM lmsonlineexams ORDER BY exid DESC');

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
													<a class="btn btn-success btn-rounded mt-3 px-4" href="images/exams/<?php echo $row['edocument']; ?>" target="_blank">View Paper</a>
													</div>
													<h3 class="mt-4 mb-1"><strong><?php echo $row['examname']; ?></strong></h3>
													<p class="text-muted"><strong>Post Date : <?php echo date("Y-m-d h:i:s A",strtotime($row['add_date'])); ?></strong></p>
													<ul class="list-group mb-3 list-group-flush">
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Start :</span><strong><?php echo date("Y-m-d h:i:s A",strtotime($row['edate'])); ?></strong> <span class="mb-0">End :</span><strong><?php echo date("Y-m-d h:i:s A",strtotime($row['exam_end_date'])); ?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">No Of Quiz :</span><strong><?php echo $row['quizcount']; ?></strong></li>
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
															<span class="mb-0">Status : </span><strong>
						<?php 
						
							if($row['status'] == "0"){

								echo '<button class="btn btn-primary btn-sm" on>Pending</button>';

							}else if($row['status'] == "1"){

								echo '<button class="btn btn-success btn-sm">Published</button>';

							}
						
						?></strong></li>
														<li class="list-group-item px-0 d-flex justify-content-between">
															<span class="mb-0">Added Date :</span><strong><?php echo $row['add_date']; ?></strong></li>
													</ul>
						<a class="btn btn-primary btn-rounded mt-3 px-4" href="edit_online_exams.php?emid=<?php echo $row["exid"]; ?>">
						<i class="fa fa-edit"></i> 
						</a>
						<a class="btn btn-danger btn-rounded mt-3 px-4" href="delete_online_exams.php?emid=<?php echo $row["exid"]; ?>">
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