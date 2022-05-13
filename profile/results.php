<?php
session_start();
include '../dashboard/conn.php';
include '../dashboard/dbconfig4.php';

if(isset($_GET['view'])){
	$_SESSION['exam_id']=$_GET['view'];
}

if(!isset($_SESSION['exam_id'])){
	header("location:exam_list.php");
}

date_default_timezone_set("Asia/Colombo");

$ex_qury=mysqli_query($conn,"SELECT *
FROM lms_exam_details ed
WHERE ed.lms_exam_id='$_SESSION[exam_id]'");
$ex_resalt=mysqli_fetch_assoc($ex_qury);

$f_qury=mysqli_query($conn,"SELECT COUNT(*) faced
FROM lms_answer a
WHERE a.lms_answer_user='$_SESSION[reid]' AND a.lms_answer_paper='$_SESSION[exam_id]'");
$f_esalt=mysqli_fetch_assoc($f_qury);

$a_qury=mysqli_query($conn,"SELECT SUM(IF(a.lms_answer_a=mcq.ans,1,0)) AS pass_answer
FROM lms_answer a INNER JOIN lms_mcq_questions mcq ON a.lms_answer_q=mcq.id
WHERE a.lms_answer_user='$_SESSION[reid]' AND a.lms_answer_paper='$_SESSION[exam_id]'");
$a_resalt=mysqli_fetch_assoc($a_qury);

@$mak=$a_resalt['pass_answer']/$ex_resalt['lms_exam_question']*100;

$current_time=date("Y-m-d H:i:s");
if(!isset($_GET['view'])){
mysqli_query($conn,"INSERT INTO
lms_exam_report (lms_report_id, exam_report_user, exam_report_paper, exam_report_faced, exam_report_corect, exam_report_percent, exam_report_complet_time)
VALUES (NULL, '$_SESSION[reid]', '$_SESSION[exam_id]', '$f_esalt[faced]', '$a_resalt[pass_answer]', '$mak', '$current_time')");
unset($_SESSION['exam_id']);
}

$GLOBALS['conn']=$conn;
function display_answer($lms_answer_user,$lms_answer_paper,$lms_answer_q){
	$ce_qury=mysqli_query($GLOBALS['conn'],"SELECT n.lms_answer_a FROM lms_answer n WHERE n.lms_answer_user='$lms_answer_user' AND n.lms_answer_paper='$lms_answer_paper' AND n.lms_answer_q='$lms_answer_q'");
	$ce_esalt=mysqli_fetch_assoc($ce_qury);
	return($ce_esalt['lms_answer_a']);
}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="demolms.lk">
	<meta name="author" content="demolms.lk">
	<title>Results : <?php echo $ex_resalt['lms_exam_name']; ?></title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

	<?php
	require_once 'headercss.php';
	?>
<style type="text/css">
	*{
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		text-transform: capitalize;
	}
	.main-table{
		width: 50%;
		border-collapse: collapse;
		margin: auto;
	}
	.main-table td{
		border: 1px solid #555555;
		padding: 15px;
	}
	.sub_bt{
		padding: 10px;
		border-radius: 5px;
		outline: none;
		border: none;
		background: green;
		color: white;
		font-weight: bold;
		font-size: 14px;
		text-decoration: none;
		margin-top: 10px;
		margin-bottom: 10px;
		cursor: pointer;
	}

/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 20px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.container.correct_ans {
	background-color: #00ff00;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #ccc;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}

.title {
  width: 100%;
  padding: 20 20 20 20px;
  background-color: #867ae9;
  color: #FFFFFF;
  text-align: center;
  margin-top: 20px;
  margin-bottom: 20px;
}

</style>

</head>

<body>
	<?php
	require_once 'header.php';
	?>

	<?php
	require_once 'sidebarmenu.php';
	?>
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
<div class="row text-center">	
  
    <table class="table table-bordered mt-4">
    <tbody>
	<tr><td colspan="2" class="alert-secondary"><?php echo $ex_resalt['lms_exam_name']; ?>, Result Summery</td></tr
	<tr><td>Completed time</td><td align="center"><?php echo date("Y-m-d h:i:s A",strtotime($current_time)); ?></td></tr>
    <tr><td>Total No Of Quiz</td><td align="center"><?php echo $ex_resalt['lms_exam_question']; ?></td></tr>
    <tr><td>Faced Questions</td><td align="center"><?php echo $f_esalt['faced']; ?></td></tr>
    <tr><td>Correct Answers</td><td align="center"><?php echo $a_resalt['pass_answer']; ?></td></tr>
    <tr><td>Percentage </td><td align="center" class="alert-success"><?php echo $mak; ?>%</td></tr>
	<?php if(isset($_GET['view'])){ ?><tr><td>Rank </td><td align="center" class="alert-info"><?php echo rank_count($_SESSION['exam_id'],$_SESSION['reid']); ?></td></tr><?php } ?>
    </tbody>
    </table>


</div>
		
<?php if(isset($_GET['view'])){ ?>
		
<hr>
		
<?php
$q_count=0;
$q_qury=mysqli_query($conn,"SELECT *
FROM lms_mcq_questions mcq
WHERE mcq.exam_id='$_SESSION[exam_id]'");
while($q_resalt=mysqli_fetch_assoc($q_qury)){
$q_count++;
?>

<h3 class="question"><?php echo $q_count; ?>.<br><?php echo $q_resalt['question']; ?></h3>
	
<label class="container" <?php if($q_resalt['ans']==1){echo "style='background-color: rgba(0,128,0,0.2);'";} ?>>A) <?php echo $q_resalt['ans_1']; ?><input type="radio" disabled="disabled" <?php if(display_answer($_SESSION['reid'],$_SESSION['exam_id'],$q_resalt['id'])==1){echo "checked";} ?>> <span class="checkmark"></span></label>
<label class="container" <?php if($q_resalt['ans']==2){echo "style='background-color: rgba(0,128,0,0.2);'";} ?>>B) <?php echo $q_resalt['ans_2']; ?><input type="radio" disabled="disabled" <?php if(display_answer($_SESSION['reid'],$_SESSION['exam_id'],$q_resalt['id'])==2){echo "checked";} ?>> <span class="checkmark"></span></label>
<label class="container" <?php if($q_resalt['ans']==3){echo "style='background-color: rgba(0,128,0,0.2);'";} ?>>C) <?php echo $q_resalt['ans_3']; ?><input type="radio" disabled="disabled" <?php if(display_answer($_SESSION['reid'],$_SESSION['exam_id'],$q_resalt['id'])==3){echo "checked";} ?>> <span class="checkmark"></span></label>
<label class="container" <?php if($q_resalt['ans']==4){echo "style='background-color: rgba(0,128,0,0.2);'";} ?>>D) <?php echo $q_resalt['ans_4']; ?><input type="radio" disabled="disabled" <?php if(display_answer($_SESSION['reid'],$_SESSION['exam_id'],$q_resalt['id'])==4){echo "checked";} ?>> <span class="checkmark"></span></label>

<?php
}
?>
<?php } ?>
		
<hr>
<div><a href="exam_list.php" class="btn btn-dark">Go to back</a></div>

</div>
		</div>
		
	<?php
	require_once 'footer.php';
	?>
	</div>
	<!-- Body End -->
	<?php
	require_once 'footerjs.php';
	?>

</body>
</html>