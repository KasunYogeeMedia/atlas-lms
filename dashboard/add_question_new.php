<?php
session_start();
require_once 'includes.php';
require_once 'conn.php';
require_once("config.php");
require_once 'dbconfig4.php';

$exam_id=mysqli_real_escape_string($conn,$_GET['exam_id']);
$q_qury=mysqli_query($conn,"SELECT * FROM lms_exam_details WHERE lms_exam_id='$exam_id'");
$q_resalt=mysqli_fetch_assoc($q_qury);

$mcq_qury=mysqli_query($conn,"SELECT COUNT(*) total_mcq FROM lms_mcq_questions WHERE exam_id='$exam_id'");
$mcq_resalt=mysqli_fetch_assoc($mcq_qury);

if(!isset($_GET['id'])){
if($q_resalt['lms_exam_question']<=$mcq_resalt['total_mcq']){
	header("location:q_list.php?exam_id=$exam_id");
}
}

if(isset($_POST['submit_btn'])){
	$exam_id=mysqli_real_escape_string($conn,$_GET['exam_id']);
	$question=mysqli_real_escape_string($conn,$_POST['question']);
	$ans_1=mysqli_real_escape_string($conn,$_POST['ans_1']);
	$ans_2=mysqli_real_escape_string($conn,$_POST['ans_2']);
	$ans_3=mysqli_real_escape_string($conn,$_POST['ans_3']);
	$ans_4=mysqli_real_escape_string($conn,$_POST['ans_4']);
	$ans=mysqli_real_escape_string($conn,$_POST['ans']);
	if(!$question==""){
	if(mysqli_query($conn,"INSERT INTO
	lms_mcq_questions (id, exam_id, question, ans_1, ans_2, ans_3, ans_4, ans)
	VALUES (NULL, '$exam_id', '$question', '$ans_1', '$ans_2', '$ans_3', '$ans_4', '$ans')")){
		header("location:add_question_new.php?exam_id=$exam_id&added_success");
	}
	}
	else{
		header("location:add_question_new.php?exam_id=$exam_id&question_empty");
	}
}

if(isset($_POST['update_btn'])){
	$id=mysqli_real_escape_string($conn,$_GET['id']);
	$exam_id=mysqli_real_escape_string($conn,$_GET['exam_id']);
	$question=mysqli_real_escape_string($conn,$_POST['question']);
	$ans_1=mysqli_real_escape_string($conn,$_POST['ans_1']);
	$ans_2=mysqli_real_escape_string($conn,$_POST['ans_2']);
	$ans_3=mysqli_real_escape_string($conn,$_POST['ans_3']);
	$ans_4=mysqli_real_escape_string($conn,$_POST['ans_4']);
	$ans=mysqli_real_escape_string($conn,$_POST['ans']);
	if(!$question==""){
	if(mysqli_query($conn,"UPDATE lms_mcq_questions SET question='$question',ans_1='$ans_1',ans_2='$ans_2',ans_3='$ans_3',ans_4='$ans_4',ans='$ans' WHERE id='$id'")){
		header("location:add_question_new.php?exam_id=$exam_id&id=$id&update_success");
	}
	}
	else{
		header("location:add_question_new.php?exam_id=$exam_id&id=$id&update_fail");
	}
}

if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($conn,$_GET['id']);
	$view_qury=mysqli_query($conn,"SELECT * FROM lms_mcq_questions WHERE id='$id'");
	$view_resalt=mysqli_fetch_assoc($view_qury);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Question | Online Learning Platforms | Dashboard</title>
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
                            <h4>Add Question</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Add Question</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Question</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Add questions</h4>
								<a href="q_list.php?exam_id=<?php echo $_GET['exam_id']; ?>" class="btn btn-dark">Back to questions list</a>
							</div>
							<div class="card-body">
						
							<?php if(isset($_GET['added_success'])){ ?><div class="alert alert-success alert-dismissible alert-alt solid fade show"><strong>Success!</strong> New Question added Successfully.</div><?php } ?>
							<?php if(isset($_GET['question_empty'])){ ?><div class="alert alert-danger alert-dismissible alert-alt solid fade show"><strong>Fail!</strong> Please enter your question.</div><?php } ?>
								
							<?php if(isset($_GET['update_success'])){ ?><div class="alert alert-success alert-dismissible alert-alt solid fade show"><strong>Success!</strong> Question update Successfully.</div><?php } ?>
							<?php if(isset($_GET['update_fail'])){ ?><div class="alert alert-danger alert-dismissible alert-alt solid fade show"><strong>Fail!</strong> Question update fail, Please try again.</div><?php } ?>

<iframe src="image_upload.php?exam_id=<?php echo $exam_id; ?>" style="width: 100%; height: 250px; border: 1px solid #CCCCCC;"></iframe>
								
<form method="post" autocomplete="off">

<div class="question-title">Question</div>
<div class="form-group">
<textarea name="question" required="required" class="q-editor" id="question"><?php if(isset($_GET['id'])){echo $view_resalt['question'];} ?></textarea>
</div>
<div class="form-group">
<input name="ans_1" type="text" required="required" class="form-control" id="ans_1" placeholder="Answer 1" value="<?php if(isset($_GET['id'])){echo $view_resalt['ans_1'];} ?>">
</div>
<div class="form-group">
<input name="ans_2" type="text" required="required" class="form-control" id="ans_2" placeholder="Answer 2" value="<?php if(isset($_GET['id'])){echo $view_resalt['ans_2'];} ?>">
</div>
<div class="form-group">
<input name="ans_3" type="text" required="required" class="form-control" id="ans_3" placeholder="Answer 3" value="<?php if(isset($_GET['id'])){echo $view_resalt['ans_3'];} ?>">
</div>
<div class="form-group">
<input name="ans_4" type="text" required="required" class="form-control" id="ans_4" placeholder="Answer 4" value="<?php if(isset($_GET['id'])){echo $view_resalt['ans_4'];} ?>">
</div>

<div class="form-group">
<div class="row">
<div class="col-sm-6">
<select name="ans" required="required" class="form-control" id="ans">
<option value="" hidden="yes">-Select-</option>
<option <?php if(isset($_GET['id'])){if($view_resalt['ans']==1){echo "selected";}} ?> value="1">Answer 1</option>
<option <?php if(isset($_GET['id'])){if($view_resalt['ans']==2){echo "selected";}} ?> value="2">Answer 2</option>
<option <?php if(isset($_GET['id'])){if($view_resalt['ans']==3){echo "selected";}} ?> value="3">Answer 3</option>
<option <?php if(isset($_GET['id'])){if($view_resalt['ans']==4){echo "selected";}} ?> value="4">Answer 4</option>
</select>
</div>
</div>
</div>

<button name="<?php if(isset($_GET['id'])){echo "update_btn";}else{echo "submit_btn";} ?>" type="submit" class="btn btn-success"><?php if(isset($_GET['id'])){echo "Update Questions";}else{echo "Add New &amp; Next";} ?></button>
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

    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

                <script>
                      $(".q-editor").each(function () {
                        CKEDITOR.replace(this);
                      });
                </script>
	
</body>
</html>