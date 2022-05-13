<?php

session_start();

require_once 'includes.php';

require_once 'conn.php';

require_once("config.php");

require_once 'dbconfig4.php';

date_default_timezone_set("Asia/Colombo");
$current_time=date("Y-m-d H:i:s");

$GLOBALS['conn']=$conn;
function check_resalt($exam_id,$user_id,$quizno){
	$q_qury=mysqli_query($GLOBALS['conn'],"SELECT * FROM paper_marks p WHERE p.exam_id='$exam_id' AND p.user_id='$user_id' AND p.quizno='$quizno'");
	if(mysqli_num_rows($q_qury)>0){
	$q_resalt=mysqli_fetch_assoc($q_qury);
	$answerstatus=$q_resalt['answerstatus'];
	}
	else{
	$answerstatus="";
	}
	return($answerstatus);
}

if(isset($_GET['id'])){
$id=mysqli_real_escape_string($conn,$_GET['id']);
$view_paper=mysqli_query($conn,"SELECT es.id,es.filename,r.fullname,r.contactnumber,ex.examname,ex.quizcount,r.reid,es.marks,es.remark
FROM exam_submissions es LEFT JOIN lmsregister r ON es.user_id=r.reid
LEFT JOIN lmsonlineexams ex ON es.exam_id=ex.exid
WHERE es.id='$id'");
$view_resalt=mysqli_fetch_assoc($view_paper);

$check_qury=mysqli_query($conn,"SELECT * FROM paper_marks WHERE exam_id='$view_resalt[id]' AND user_id='$view_resalt[reid]'");
if(!mysqli_num_rows($check_qury)>0){
for($e=1;$e<=$view_resalt['quizcount'];$e++){
mysqli_query($conn,"INSERT INTO
paper_marks (mid, exam_id, user_id, quizno, answerstatus, add_date, status)
VALUES (NULL, '$view_resalt[id]', '$view_resalt[reid]', '$e', '1', '$current_time', '1')");
}
if(mysqli_query($conn,"UPDATE exam_submissions SET marks='100',remark='',status='1' WHERE id='$id'")){
header("location:add_marks.php?id=$id");
}
}
	
}
else{
	echo "Error! Something is wrong. Please go to the <a href='home.php'>main page.</a>";
	exit();
}

if(isset($_POST['submit_btn'])){
$id=mysqli_real_escape_string($conn,$_GET['id']);
	
if(mysqli_query($conn,"DELETE FROM paper_marks WHERE exam_id='$view_resalt[id]' AND user_id='$view_resalt[reid]'")){
	
$cret_answer=0;
for($e=1;$e<=$view_resalt['quizcount'];$e++){
	if(empty($_POST['quiz'.$e])){
		$answer=0;		
	}
	else{
		$answer=1;	
		$cret_answer++;
	}
			mysqli_query($conn,"INSERT INTO
			paper_marks (mid, exam_id, user_id, quizno, answerstatus, add_date, status)
			VALUES (NULL, '$view_resalt[id]', '$view_resalt[reid]', '$e', '$answer', '$current_time', '1')");
}
		
	}
	
$marks=$cret_answer/$view_resalt['quizcount']*100;
$remark=mysqli_real_escape_string($conn,$_POST['remark']);
mysqli_query($conn,"UPDATE exam_submissions SET marks='$marks',remark='$remark',status='1' WHERE id='$id'");
header("location:add_marks.php?id=$id");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>View Answers and Add Marks | Online Learning Platforms | Dashboard</title>
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
                                        <span class="ml-2"><?php echo $fullname;?></span>
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
                            <h4>View Answers and Add Marks</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Class Tute</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">View Answers and Add Marks</a></li>
                        </ol>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-8">
				
<div class="card">
<div class="card-header">
<h4 class="card-title">View Answers Sheet</h4>
</div>
<div class="card-body">
<strong>Student Details</strong><br>

Name: <strong><?php echo $view_resalt['fullname']; ?></strong><br>
Contact: <strong><?php echo "0".(int)$view_resalt['contactnumber']; ?></strong><br><br>

<?php 
$image_count=0;
foreach(json_decode($view_resalt['filename']) as $filename){
$image_count++;
?>
<p><?php echo "Image ".$image_count; ?></p>
<img src="../profile/uploadImg/paper/<?php echo $filename; ?>" class="w-100 mb-4" style="border: 1px solid #CCCCCC;">
<?php
}
?>							

	
</div>
</div>
					</div>
					<div class="col-lg-4">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Marks Paper</h4>
								<hr>
							</div>
							<div class="card-body">
							
								<form method="POST">
									<div class="row">
									  <div class="col-12">
<strong>Exam Details</strong><br>
Name <strong><?php echo $view_resalt['examname']; ?></strong><br>
Total Quiz <strong><?php echo $view_resalt['quizcount']; ?></strong><br>
Marks/Grade <span class="badge badge-secondary text-white"><?php echo $view_resalt['marks']; ?>%</span> <span class="badge badge-info text-white"><?php echo rate_count($view_resalt['marks']); ?></span>
			
<p class="mt-2 text-success"><em>Put a check mark for the wrong question</em></p>
										  
<table style="width: 100%; margin-top: 10px;">
<tbody>
<tr>
<td>Question</td>	
<td align="center">Wrong Answer</td>
</tr>
<?php 
for($e=1;$e<=$view_resalt['quizcount'];$e++){
?>
<tr class="table table-sm">
<td align="left" valign="middle">Question <?php echo $e; ?></td>
<td align="center" valign="middle">
<input <?php if(check_resalt($view_resalt['id'],$view_resalt['reid'],$e)==1){echo "checked";} ?> type="checkbox" name="quiz<?php echo $e; ?>">
</td>
</tr>
<?php } ?>
</tbody>
</table>
										  
Remark
<textarea name="remark" rows="4" class="form-control" id="remark"><?php echo $view_resalt['remark']; ?></textarea>
										  
<button name="submit_btn" type="submit" class="btn btn-success text-white mt-2">Submit</button>
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