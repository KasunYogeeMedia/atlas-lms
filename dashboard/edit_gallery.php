<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once 'dbconfig4.php';

	function imageResize($imageResourceId, $width, $height)
	
{

    $targetWidth = 1920;
    $targetHeight = 1200;

    $targetLayer = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);


    return $targetLayer;
}
	
	if(isset($_GET['glid']) && !empty($_GET['glid']))

	{

		$id = $_GET['glid'];

		$stmt_edit = $DB_con->prepare('SELECT * FROM lmsgallery WHERE id =:glid');

		$stmt_edit->execute(array(':glid'=>$id));

		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);

		extract($edit_row);

	}

	else

	{

		header("Location: gallery.php");

	}	

	if(isset($_POST['update']))

	{

		$status = $_POST['status'];
		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];

		if ($imgFile) {

        $upload_dir = 'images/gallery/'; // upload directory	

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'docx', 'pdf', 'video', 'mp3'); // valid extensions

        $userpic = rand(1, 1000000) . "." . $imgExt;

        if (in_array($imgExt, $valid_extensions)) {

            if ($imgSize < 5000000) {

                unlink($upload_dir . $edit_row['image']);
                $file = $tmp_dir;
                $sourceProperties = getimagesize($file);
                $fileNewName = time();
                $folderPath = "images/gallery/";
                $ext = pathinfo($imgFile, PATHINFO_EXTENSION);
                $imageType = $sourceProperties[2];


                switch ($imageType) {


                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($file);
                        $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                        imagepng($targetLayer, $folderPath . $fileNewName . "_thump." . $ext);
                        break;


                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($file);
                        $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                        imagegif($targetLayer, $folderPath . $fileNewName . "_thump." . $ext);
                        break;


                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($file);
                        $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                        imagejpeg($targetLayer, $folderPath . $fileNewName . "_thump." . $ext);
                        break;


                    default:
                        echo "Invalid Image type.";
                        exit;
                        break;
                }


                move_uploaded_file($file, $folderPath . $fileNewName . "." . $ext);
                // echo "Image Resize Successfully.";
                //move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {

                $errMSG = "Sorry, your file is too large it lmsould be less then 5MB";
            }
        } else {

            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {

        // if no image selected the old image remain as it is.

        $userpic = $edit_row['image']; // old image from database

    }
    if (empty($imgFile)) {
        $upload_name = $edit_row['image'];
    } else {
        $upload_name = $fileNewName . '_thump.' . $ext;
    }

		if(!isset($errMSG))

		{

			$stmt = $DB_con->prepare('UPDATE lmsgallery

									     SET image=:upic,
	
											 status=:status

								       WHERE id=:glid');

			$stmt->bindParam(':upic',$upload_name);

			$stmt->bindParam(':status',$status);

			$stmt->bindParam(':glid',$id);

			if($stmt->execute()){

				$successMSG = "Gallery Successfully Updated ...";

				header("refresh:2;gallery.php"); // redirects image view page after 5 seconds.

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
    <title>Edit Gallery | Online Learning Platforms | Dashboard</title>
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
                            <h4>Edit Gallery</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="class_tute.php">Gallery</a></li>
                            <li class="breadcrumb-item active"><a href="edit_class_tute.php">Edit Gallery</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
								<h5 class="card-title">Edit Gallery</h5>
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
                                <form method="POST" enctype="multipart/form-data">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label class="form-label">Upload Main Image</label>
												<input type="file" class="form-control" id="input-8" name="user_image" />
					  <hr>
					  <p style="font-weight:bold;color:red;">Note : "Max Width - 1920px x Height - 1200px | Only Upload - Jpg|Png"</p>
											</div>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-12">
											<div class="form-group">
												<label class="form-label">Status</label>
												<select class="form-control" id="input-6" name="status" required>
					  <option><?php echo $status; ?></option>
                      <option>Publish</option>
                      <option>Unpublished</option>
                      </select>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12">
											<input type="submit" name="update" class="btn btn-primary" value="Update">
											<a class="btn btn-light" href="gallery.php"><i class="fa fa-times"></i> Cancel</a>
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