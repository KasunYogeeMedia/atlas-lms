<?php

session_start();

require_once 'includes.php';

?>
<?php

require("conn.php");

require_once 'dbconfig4.php';

if(isset($_GET['sbid'])){
	$sbid=mysqli_real_escape_string($conn,$_GET['sbid']);
	$view_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE sid='$sbid'");
	$view_result=mysqli_fetch_array($view_qury);
}
else{
	echo "<script>window.location='subject.php';</script>";
}


	if(isset($_POST['update']))
	{
		$class_id = $_POST['class_id'];
		$name = $_POST['name'];
		$price = $_POST['price'];
        $fvp = $_POST['fees_valid_period'];
		$status = $_POST['status'];

    $sbid = $_GET['sbid'];

		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE lmssubject
			SET class_id=:class_id,
				name=:name,
				price=:price,
                fees_valid_period=:fees_valid_period,
				status=:status
			WHERE sid=:sbid');
			$stmt->bindParam(':class_id',$class_id);
			$stmt->bindParam(':name',$name);
			$stmt->bindParam(':price',$price);
            $stmt->bindParam(':fees_valid_period',$fvp);
			$stmt->bindParam(':status',$status);
			$stmt->bindParam(':sbid',$sbid);
			if($stmt->execute()){
				
				$successMSG = "Subject Successfully Updated ....";

				header("refresh:2;subject.php"); // redirects image view page after 5 seconds.
				
			}
			else{
				
				$errMSG = "Sorry Data Could Not Updated !";
				
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
    <title>Edit Subject | Online Learning Platforms | Dashboard</title>
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
                            <h4>Edit Subject</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="subject.php">Subject</a></li>
                            <li class="breadcrumb-item active"><a href="edit_admin.php">Edit Subject</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
								<h5 class="card-title">Edit Subject</h5>
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
                                <form action="" method="POST" enctype="multlmsrt/form-data">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Grade</label>
												<select name="class_id" class="form-control">
												<?php 
												$class_qury=mysqli_query($conn,"SELECT * FROM lmsclass ORDER BY name");
												while($class_result=mysqli_fetch_array($class_qury)){
												?>						  
												<option <?php if($view_result['class_id']==$class_result['cid']){echo "selected";} ?> value="<?php echo $class_result['cid']; ?>"><?php echo $class_result['name']; ?></option>
												<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Subject Name</label>
												<input type="text" class="form-control" name="name" value="<?php echo $view_result['name']; ?>" required>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Price</label>
												<input type="text" class="form-control" name="price" value="<?php echo $view_result['price']; ?>" required>
											</div>
										</div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Fees Valid Period</label>
                                                <select name="fees_valid_period" class="form-control">

	                                                <option value=''></option>
	                                                <?php

	                                                	$days_a = array(1,30,40,45,90,180);
	                                                	$days_a_txt = array(1=>"1 Day",30=>"30 Days",40=>"40 Days Month",45=>"45 Days Month",90=>"90 Days");


	                                                	foreach($days_a as $d){

	                                                		if ($view_result['fees_valid_period'] == $d ){

	                                                			echo "<option selected='selected' value='".$d."'>".$days_a_txt[$d]."</option>";

	                                                		}else{
	                                                			echo "<option value='".$d."'>".$days_a_txt[$d]."</option>";	                                                			
	                                                		}

	                                                	}


	                                                ?>

                                            	</select>
                                            </div>
                                        </div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group fallback w-100">
												<label class="form-label">Status</label>
												<select class="form-control" id="input-6" name="status" required>
												<option <?php if($view_result['status']=="Publish"){echo "selected";} ?>>Publish</option>
												<option <?php if($view_result['status']=="Unpublish"){echo "selected";} ?>>Unpublish</option>
												</select>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<input type="submit" name="update" class="btn btn-primary" value="Update">
											<a class="btn btn-light" href="subject.php"><i class="fa fa-times"></i> Close</a>
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