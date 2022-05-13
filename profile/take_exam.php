<?php
session_start();
include '../dashboard/conn.php';

if(isset($_GET['lms_exam_system_id'])){
	$lms_exam_system_id=mysqli_real_escape_string($conn,$_GET['lms_exam_system_id']);
	$_SESSION['lms_exam_system_id']=$lms_exam_system_id;
	
	$remove_key=$_GET['lms_exam_system_id'].$_SESSION['reid'];
	mysqli_query($conn,"DELETE FROM lms_answer WHERE lms_answer_identify='$remove_key'");
	
	echo "<script>window.location='take_exam.php';</script>";
}

$join_str="lms_exam_details INNER JOIN lmssubject ON lms_exam_details.lms_exam_subject=lmssubject.sid";
$exam_qury=mysqli_query($conn,"SELECT * FROM $join_str WHERE lms_exam_system_id='$_SESSION[lms_exam_system_id]'");
$exam_resalt=mysqli_fetch_array($exam_qury);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>TAKE EXAM</title>
<style type="text/css">
	*{
		padding: 0px;
		margin: 0px;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		box-sizing: border-box;
	}
	body, html{
		padding: 10px;
	}
	.main-div{
		padding: 10px;
		width: 100%;
		display: block;
		background: #EEEEEE;
		border-radius: 5px;
		margin-bottom: 10px;
		white-space: pre-line;
		transition: 0.5s;
		line-height: 15px;
		font-size: 16px;
	}
	.main-div:hover{
		background-color: rgba(70,130,180,0.2);
	}
	.a-div{
		padding-left: 20px;
	}
	.header-div{
		padding: 10px;
		width: 100%;
		background-color: #000000;
		color: #FFFFFF;
		margin-bottom: 20px;
		text-align: center;
	}
	.Time_dis{
		position: fixed;
		top: 10px;
		right: 0px;
		padding: 10px;
		background-color: darkred;
		color: #FFFFFF;
		font-weight: bold;
		font-size: 16px;
		border-top-left-radius: 50px;
		border-bottom-left-radius: 50px;
		transition: 0.5s;
		text-align: center;
		border-left: 5px solid red;
	}
	.Time_dis p{
		font-size: 11px;
		padding-left: 5px;
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
</style>
</head>

<body>
<div class="Time_dis">
<div id="demo">Time: 0:0:0</div>
<p>Ends automatically</p>
</div>

<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php date_default_timezone_set("Asia/Colombo"); echo date("M d, Y H:i:s",time()+60*$exam_resalt['th_exam_time_duration']); ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML ="Time: " + hours + ":"
  + minutes + ":" + seconds;

  // If the count down is finithed, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "Time: 0:0:0";
	  window.location="results.php";
  }
}, 1000);
</script>	
	
<div class="header-div">
<h2><?php echo $exam_resalt['lms_exam_name']; ?></h2>
<p>Subject: <?php echo $exam_resalt['name']; ?></p>
<p>Total Question: <?php echo $exam_resalt['lms_exam_question']; ?></p>
</div>
	
<?php
$count=0;
$exam_q=mysqli_query($conn,"SELECT * FROM lms_question_answer WHERE lms_question_answer_examid='$_SESSION[lms_exam_system_id]' ORDER BY RAND() LIMIT $exam_resalt[lms_exam_question]");
while($exam_r=mysqli_fetch_array($exam_q)){
$count++;
?>

<div class="main-div">
<div class="q-div"><?php echo $count.") ".$exam_r['lms_question']; ?></div>
<div class="a-div"><label><input type="radio" name="<?php echo $count; ?>" onChange="JavaScript:save_val('1','<?php echo $exam_r['lms_question_answer_id']; ?>');"> <?php echo $exam_r['lms_answer1']; ?></label></div>
<div class="a-div"><label><input type="radio" name="<?php echo $count; ?>" onChange="JavaScript:save_val('2','<?php echo $exam_r['lms_question_answer_id']; ?>');"> <?php echo $exam_r['lms_answer2']; ?></label></div>
<div class="a-div"><label><input type="radio" name="<?php echo $count; ?>" onChange="JavaScript:save_val('3','<?php echo $exam_r['lms_question_answer_id']; ?>');"> <?php echo $exam_r['lms_answer3']; ?></label></div>
<div class="a-div"><label><input type="radio" name="<?php echo $count; ?>" onChange="JavaScript:save_val('4','<?php echo $exam_r['lms_question_answer_id']; ?>');"> <?php echo $exam_r['lms_answer4']; ?></label></div>
</div>
	
<?php } ?>
	
<script>
function save_val(answer_val,question_val){
	console.log(answer_val+","+question_val);
	  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     //document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "ajax_answer_save.php?answer_val="+answer_val+"&question_val="+question_val, true);
  xhttp.send();
}	
</script>
	
<hr>
	
<button type="button" class="sub_bt" onClick="JavaScript:window.location='results.php';">Submit My Paper</button>

</body>
</html>