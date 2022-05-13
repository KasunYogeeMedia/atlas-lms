<?php

session_start();

require_once 'includes.php';

?>

<?php

require_once 'dbconfig4.php';

$msg = '';

$msg5 = '';	

if(isset($_POST['save']))

{

		$user_name = $_POST['user_name'];
		
		$user_email = $_POST['user_email'];
		
		$user_pass = $_POST['user_pass'];

        $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);
		
		$admintype = $_POST['admintype'];
		
		$admin = $_POST['admin'];
		
		$students = $_POST['students'];
				
		$teachers = $_POST['teachers'];
		
		$class = $_POST['class'];
		
		$subject = $_POST['subject'];
		
		$lesson = $_POST['lesson'];

		$payments = $_POST['payments'];
		
		$class_schedule = $_POST['class_schedule'];
		
		$mail = $_POST['mail'];

		$status = $_POST['status'];

		// if no error occured, continue ....

		if(!isset($errMSG))

		{

			$stmt = $DB_con->prepare('INSERT INTO lmsusers(user_name,user_email,user_pass,admintype,admin,students,teachers,class,subject,lesson,payments,class_schedule,mail,status) VALUES(:user_name,:user_email,:user_pass,:admintype,:admin,:students,:teachers,:class,:subject,:lesson,:payments,:class_schedule,:mail,:status)');

			$stmt->bindParam(':user_name',$user_name);
			
			$stmt->bindParam(':user_email',$user_email);

			$stmt->bindParam(':user_pass',$user_pass);
			
			$stmt->bindParam(':admintype',$admintype);
			
			$stmt->bindParam(':admin',$admin);
			
			$stmt->bindParam(':students',$students);

			$stmt->bindParam(':teachers',$teachers);
			
			$stmt->bindParam(':class',$class);
			
			$stmt->bindParam(':subject',$subject);
			
			$stmt->bindParam(':lesson',$lesson);

			$stmt->bindParam(':payments',$payments);
			
			$stmt->bindParam(':class_schedule',$class_schedule);
			
			$stmt->bindParam(':mail',$mail);

			$stmt->bindParam(':status',$status);
			
			if($stmt->execute())

			{

				$successMSG = "Successfully! Created New Admin User Account....";

				header("refresh:2;admin.php"); // redirects image view page after 5 seconds.

			}

			else

			{

				$errMSG = "error while inserting....";

			}

		}

	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Admin | Online Learning Platforms | Dashboard</title>
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
                            <h4>Add Admin</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Admin</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add Admin Users Account</h4>
							</div>
							<div class="card-body">
							<?php

							if(isset($errMSG)){

							?>
			
							<div class="alert alert-danger alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Error!</strong> <?php echo $errMSG; ?>
							</div>

							<?php

							}
	
							else if(isset($successMSG)){

							?>
			
							<div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> <?php echo $successMSG; ?>.
							</div>

							<?php

							}

							?>
								<form method="POST" enctype="multlmsrt/form-data">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Username</label>
												<input type="text" class="form-control" name="user_name" placeholder="Enter Username" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Email</label>
												<input type="email" class="form-control" name="user_email" placeholder="Enter Email" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Password</label>
												<input type="password" class="form-control" name="user_pass" placeholder="Enter Password" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Admin Type</label>
												<select class="form-control" name="admintype" required>
													<option>Super Admin</option>
													<option>Core Admin</option>
													<option>Editor</option>
													<option>Viewer</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Admin</label>
												<select class="form-control" name="admin" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Students</label>
												<select class="form-control" name="students" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Teachers</label>
												<select class="form-control" name="teachers" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Class</label>
												<select class="form-control" name="class" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Subject</label>
												<select class="form-control" name="subject" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Lesson</label>
												<select class="form-control" name="lesson" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Payments</label>
												<select class="form-control" name="payments" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Class Schedule</label>
												<select class="form-control" name="class_schedule" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Mail</label>
												<select class="form-control" name="mail" required>
													<option>True</option>
													<option>False</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Status</label>
												<select class="form-control" name="status" required>
													<option>Publish</option>
													<option>Unpublish</option>
												</select>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<input type="submit" name="save" class="btn btn-primary" value="Save changes">
											<a class="btn btn-light" href="admin.php"><i class="fa fa-times"></i> Cancel</a>
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