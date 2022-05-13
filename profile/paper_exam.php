<?php
session_start();
include '../dashboard/conn.php';
require_once '../dashboard/dbconfig4.php';

//print_r($_POST);

if(isset($_GET['exam_id'])){

	$exam_id = $_GET['exam_id'];

    $sql = "SELECT * FROM sft_exam_details WHERE sft_exam_id = :id";
    $query = $DB_con->prepare($sql);
    $query->bindParam('id', $exam_id);
    $query->execute();
    

    if ($query->rowCount() == 0) {
		die();
	}

	$result = $query->fetch();

	$exam_name = $result[3]; 
	$exam_time_duration = $result[6]; 


	$sql = "SELECT * FROM sft_mcq_questions WHERE exam_id = :exam_id";
    $query = $DB_con->prepare($sql);
    $query->bindParam('exam_id', $exam_id);
    $query->execute();

    $result = $query->fetchAll();

    //print_r($edit_result);
}else{
	//die();
}




$user_qury=mysqli_query($conn,"SELECT * FROM sftregister WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$image_qury=mysqli_query($conn,"SELECT * FROM sftregister WHERE reid='$_SESSION[reid]'");
$image_resalt=mysqli_fetch_array($image_qury);

if($image_resalt['image']==""){
	$dis_image_path="img/pro_pick.png";
}
else{
	$dis_image_path="uploadImg/".$image_resalt['image'];
}
?>





<!DOCTYPE html>
<html lang="en">
<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- DESCRIPTION -->
	<meta name="description" content=" Science For Technology | sftwaruna.com " />
	
	<!-- OG -->
	<meta property="og:title" content=" Science For Technology | sftwaruna.com " />
	<meta property="og:description" content=" Science For Technology | sftwaruna.com " />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Exam | Science For Technology | sftwaruna.com | Dashboard</title>

	<!-- FAVICONS ICON ============================================= -->
	<?php
	require_once '../favicon.php';
	?>

	<?php
	require_once 'proheadercss.php';
	?>
	
<style type="text/css">
	
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  color: #000000;
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
  background-color: #000000;
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

.question{

  color: #007bff;
  width: 100%;
  padding: 20 20 20 20px;
  background-color: #cccccc;
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
		top: 80px;
		right: 5px;
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
<body class="ttr-opened-sidebar ttr-pinned-sidebar">
	
	<!-- header start -->
	<header class="ttr-header">
		<div class="ttr-header-wrapper">
			<!--sidebar menu toggler start -->
			<div class="ttr-toggle-sidebar ttr-material-button">
				<i class="ti-close ttr-open-icon"></i>
				<i class="ti-menu ttr-close-icon"></i>
			</div>
			<!--sidebar menu toggler end -->
			<!--logo start -->
			<div class="ttr-logo-box">
				<div>
					<a href="../index.php" class="ttr-logo">
						<img class="ttr-logo-mobile" alt="" src="assets/images/logo-mobile.png">
						<img class="ttr-logo-desktop" alt="" src="assets/images/logo-white.png">
					</a>
				</div>
			</div>
			<!--logo end -->
			<div class="ttr-header-menu">
				<!-- header left menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="../index.php" class="ttr-material-button ttr-submenu-toggle">HOME</a>
					</li>
				</ul>
				<!-- header left menu end -->
			</div>
			<div class="ttr-header-right ttr-with-seperator">
				<!-- header right menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="#" class="ttr-material-button ttr-submenu-toggle"><span class="ttr-user-avatar"><img src="<?php echo $dis_image_path; ?>" id="dis_image" style="width: 32px; height: 32px; border-radius: 100%; cursor: pointer; object-fit: cover; background-position: center;"></span></a>
						<div class="ttr-header-submenu">
							<ul>
								<li><a href="student_profile.php">Time Table</a></li>
								<li><a href="../logout.php">Logout</a></li>
							</ul>
						</div>
					</li>
				</ul>
				<!-- header right menu end -->
			</div>
		</div>
	</header>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<?php
	require_once 'sidemenu.php';
	?>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Exam Details</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="student_profile.php"><i class="fa fa-home"></i>Home</a></li>
					<li>Exam</li>
				</ul>
			</div>	

<div class="row">

<div class="col-sm-12">
<form id="quiz" action="results.php" method="POST">
<?php
$q_number = 1;
foreach ($result as $question) {

?>

<h3 class="question"><?php echo $q_number; ?>)  <?php echo $question[2]; ?></h3>
<label class="container">A) <?php echo $question[3] ?>
<input type="radio" value="1" name="q-<?php echo $question[0]; ?>-ans">
<span class="checkmark"></span>
</label>
<label class="container">B) <?php echo $question[4] ?>
<input type="radio" value="2" name="q-<?php echo $question[0]; ?>-ans">
<span class="checkmark"></span>
</label>
<label class="container">C) <?php echo $question[5] ?>
<input type="radio" value="3" name="q-<?php echo $question[0]; ?>-ans">
<span class="checkmark"></span>
</label>
<label class="container">D) <?php echo $question[6] ?>
<input type="radio" value="4" name="q-<?php echo $question[0]; ?>-ans">
<span class="checkmark"></span>
</label>

<?php
$q_number++;
}
?>

<input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
<input type="submit" name="submit" class="btn btn-success submit-btn" value="Submit">
</form>

</div>

<div class="col-sm-4">
<div class="Time_dis">
<div id="demo">Time: 0:0:0</div>
<p>Ends automatically</p>
</div>

</div>

	</div>
	
	</div>
	</div>
	</div>
</main>
	
	<div class="ttr-overlay"></div>

	<?php
	require_once 'profooterjs.php';
	?>
	
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php date_default_timezone_set("Asia/Colombo"); echo date("M d, Y H:i:s",time()+60*$exam_time_duration); ?>").getTime();

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
	  //window.location="results.php";
	  document.getElementById("quiz").submit();
  }
}, 1000);
</script>	

</body>
</html>