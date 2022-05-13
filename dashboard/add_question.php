<?php

session_start();

require_once 'includes.php';
require_once 'conn.php';
require_once("config.php");
require_once 'dbconfig4.php';

date_default_timezone_set("Asia/Colombo");


$edit = 0;

if (isset($_GET["edit"])) {
    $edit = 1;
}

if(isset($_POST['submit']) && isset($_POST['update'])){

    print_r($_POST);

    $exam_id = $_POST['exam_id'];

    $sql = "SELECT * FROM lms_exam_details where lms_exam_id = :id";
    $query = $DB_con->prepare($sql);
    $query->bindParam('id', $exam_id);
    $query->execute();

    if ($query->rowCount() == 0) {
        die();

    }

    $result = $query->fetch();

    $question_count = $result['lms_exam_question'];

    $sql = "UPDATE lms_mcq_questions SET question = :question, ans_1 = :ans_1, ans_2 = :ans_2, ans_3 = :ans_3, ans_4 = :ans_4, ans = :ans WHERE id = :q_id";
    $query = $DB_con->prepare($sql);

    for ($i=1; $i <= $question_count ; $i++) {

        $q_id = htmlspecialchars($_POST["q_" . $i . "_id"]);
        $question = $_POST["q_" . $i . "_question"];
        $ans_1 = htmlspecialchars($_POST["q_" . $i . "_ans_1"]);
        $ans_2 = htmlspecialchars($_POST["q_" . $i . "_ans_2"]);
        $ans_3 = htmlspecialchars($_POST["q_" . $i . "_ans_3"]);
        $ans_4 = htmlspecialchars($_POST["q_" . $i . "_ans_4"]);
        $ans = htmlspecialchars($_POST["q_" . $i . "_ans"]);

        $query->bindParam('q_id', $q_id);
        $query->bindParam('question', $question);
        $query->bindParam('ans_1', $ans_1);
        $query->bindParam('ans_2', $ans_2);
        $query->bindParam('ans_3', $ans_3);
        $query->bindParam('ans_4', $ans_4);
        $query->bindParam('ans', $ans);
        $query->execute();

        $edit = 1;

    }

}



if(isset($_POST['submit'])){

    $exam_id = $_POST['exam_id'];

    $sql = "SELECT * FROM lms_exam_details where lms_exam_id = :id";
    $query = $DB_con->prepare($sql);
    $query->bindParam('id', $exam_id);
    $query->execute();

    if ($query->rowCount() == 0) {
        die();

    }

    $result = $query->fetch();

    $question_count = $result['lms_exam_question'];

    $sql = "INSERT INTO lms_mcq_questions (exam_id, question, ans_1, ans_2, ans_3, ans_4, ans) VALUES (:exam_id, :question, :ans_1, :ans_2, :ans_3, :ans_4, :ans)";
    $query = $DB_con->prepare($sql);
    $query->bindParam('exam_id', $exam_id);

    for ($i=1; $i <= $question_count ; $i++) {

        $question = $_POST["q_" . $i . "_question"];
        $ans_1 = htmlspecialchars($_POST["q_" . $i . "_ans_1"]);
        $ans_2 = htmlspecialchars($_POST["q_" . $i . "_ans_2"]);
        $ans_3 = htmlspecialchars($_POST["q_" . $i . "_ans_3"]);
        $ans_4 = htmlspecialchars($_POST["q_" . $i . "_ans_4"]);
        $ans = htmlspecialchars($_POST["q_" . $i . "_ans"]);

        $query->bindParam('question', $question);
        $query->bindParam('ans_1', $ans_1);
        $query->bindParam('ans_2', $ans_2);
        $query->bindParam('ans_3', $ans_3);
        $query->bindParam('ans_4', $ans_4);
        $query->bindParam('ans', $ans);
        $query->execute();

        $edit = 1;

    }
exit();
}


if ($edit == 1) {
    
    $sql = "SELECT * FROM lms_mcq_questions WHERE exam_id = :exam_id";
    $query = $DB_con->prepare($sql);
    $query->bindParam('exam_id', $exam_id);
    $query->execute();
    $edit_result = $query->fetchAll();

    //print_r($edit_result);
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
							</div>
							<div class="card-body">
							<?php if(isset($_GET['update'])){ ?>
							<div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> Exam Details Updated Successfully..
							</div>
							<?php

							}

							?>
							
							<?php if(isset($_GET['success'])){ ?><div class="alert alert-success alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> New Question Added Successfully.</div><?php } ?>
							<?php if(isset($_GET['removed'])){ ?><div class="alert alert-danger alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> Question Removed Successfully.</div><?php } ?>
							<?php if(isset($_GET['update'])){ ?><div class="alert alert-primary alert-dismissible alert-alt solid fade show">
							<button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span></button>
							<strong>Success!</strong> Question Updated Successfully.</div><?php } ?>
								<form method="post" autocomplete="off">



<?php
		
		$exam_id = $_GET['exam_id'];

		$sql = "SELECT * FROM lms_exam_details where lms_exam_id = :id";
		$query = $DB_con->prepare($sql);
		$query->bindParam('id', $exam_id);
		$query->execute();

		if ($query->rowCount() == 0) {
			die();

		}

		$result = $query->fetch();

		$question_count = $result['lms_exam_question'];


		for ($i=1; $i <= $question_count ; $i++) { 

                    $j = $i-1;
?>
					<div class="question-title">Question  <?php echo $i; ?></div>
                    <div class="form-group">
                        <label class="form-control" for="q_<?php echo $i; ?>_question">Question</label>
                        
                        <?php
                        if ($edit == 1) {
                            echo "<input type=\"hidden\" name=\"q_". $i ."_id\" value=".$edit_result[$j][0].">";
                        }
                        ?>

                        <textarea class="q-editor" name="q_<?php echo $i; ?>_question" class="form-control" required="required"><?php if ($edit) {echo $edit_result[$j][2];} ?></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php if ($edit) {echo $edit_result[$j][3];} ?>" name="q_<?php echo $i; ?>_ans_1"  class="form-control" placeholder="answer 1" required="required">
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php if ($edit) {echo $edit_result[$j][4];} ?>" name="q_<?php echo $i; ?>_ans_2" class="form-control" placeholder="answer 2" required="required">
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php if ($edit) {echo $edit_result[$j][5];} ?>" name="q_<?php echo $i; ?>_ans_3" class="form-control" placeholder="answer 3" required="required">
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php if ($edit) {echo $edit_result[$j][6];} ?>" name="q_<?php echo $i; ?>_ans_4" class="form-control" placeholder="answer 4" required="required">
                    </div>
                    <div class="form-group">
                        <div class="row">
                        <div class="col-sm-6">
                            <label class="form-control" for="q_<?php echo $i; ?>_ans">Pick the correct answer</label>
                        </div>
                        <div class="col-sm-6">
                        <select name="q_<?php echo $i; ?>_ans" class="form-control">
                        	<option value="1" <?php if ($edit && $edit_result[$j][7] == 1 ) {echo "selected= \"selected\"";} ?>>Answer 1</option>
                        	<option value="2" <?php if ($edit && $edit_result[$j][7] == 2 ) {echo "selected= \"selected\"";} ?>>Answer 2</option>
                        	<option value="3" <?php if ($edit && $edit_result[$j][7] == 3 ) {echo "selected= \"selected\"";} ?>>Answer 3</option>
                        	<option value="4" <?php if ($edit && $edit_result[$j][7] == 4 ) {echo "selected= \"selected\"";} ?>>Answer 4</option>
                        </select>
                        </div>
                        </div>
                    </div>
<?php
		}

?>





                    <div class="form-group">
                        <?php
                        if ($edit == 1) {
                            echo "<input type=\"hidden\" name=\"update\" value=\"1\">";
                        }
                        ?>
                        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                        <input type="submit" name="submit" value="Submit" class="form-control">
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

    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

                <script>
                      $(".q-editor").each(function () {
                        CKEDITOR.replace(this);
                      });
                </script>
	
</body>
</html>