<?php
session_start();
include '../dashboard/conn.php';
require_once '../dashboard/dbconfig4.php';
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$image_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$image_resalt=mysqli_fetch_array($image_qury);

if($image_resalt['image']==""){
	$dis_image_path="images/hd_dp.jpg";
}
else{
	$dis_image_path="uploadImg/".$image_resalt['image'];
}

if(isset($_GET['type'])){
	if($_GET['type']==1){
		$type="Payed";
	}
	if($_GET['type']==0){
		$type="Free";
	}
}
else{
	header("location:exam_list.php?type=0");
}
unset($_SESSION['exam_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="demolms.lk">
	<meta name="author" content="demolms.lk">
	<title>Exam List | Online Learning Platforms  | Student Panel</title>
	<?php
	require_once 'headercss.php';
	?>
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
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-file-alt"></i><?php echo $type; ?>  Exam List</h2>
					</div>					
				</div>				
				<div class="row">					
					<div class="col-lg-12 col-md-12">
						<ul class="more_options_tt">
							<li>
								<div class="explore_search">
									<div class="ui search focus">
										<div class="ui left icon input swdh11 swdh15">
											<input class="prompt srch_explore" type="text" placeholder="Month">
											<i class="uil uil-search-alt icon icon8"></i>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="col-lg-12 col-md-12">
						<div class="table-responsive mt-30">
							<table id="example" class="table table-bordered" style="margin-top: 10px;">
<thead>
<tr>
<th>Take</th>
<th>Exam Name</th>
<th>Course/Subject/Class</th>
<th>Time</th>
<th>Questions</th>
<th>Time Details</th>
</tr>
</thead>
<tbody>
<?php
$sub_arrey=array();
	
//print_r($_SESSION);
$reg_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$reg_resalt=mysqli_fetch_array($reg_qury);
	
$sub_qury=mysqli_query($conn,"SELECT * FROM lmsreq_subject WHERE sub_req_reg_no='$reg_resalt[contactnumber]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
array_push($sub_arrey,'"'.$sub_resalt['sub_req_sub_id'].'"');
}

$sub_filter=join(",",$sub_arrey);
	
if($_GET['type']==1){
$check_payment=mysqli_query($conn,"SELECT * FROM lmspayment p WHERE p.userID='$_SESSION[reid]' AND p.pay_sub_id IN ($sub_filter)");
if(mysqli_num_rows($check_payment)>0){
$display=1;
}
else{
$display=0;
}
}
else{
$display=1;
}

$join_str="lms_exam_details INNER JOIN lmssubject ON lms_exam_details.lms_exam_subject=lmssubject.sid";
$exam_qury=mysqli_query($conn,"SELECT * FROM $join_str WHERE lms_exam_subject IN ($sub_filter) AND lms_exam_pay_type='$_GET[type]' ORDER BY lms_exam_id DESC");
while($exam_resalt=mysqli_fetch_array($exam_qury)){
if($display==1){
?>

<tr style="text-transform: capitalize;">
<td style="white-space: nowrap;">
<?php
$check_exam=mysqli_query($conn,"SELECT * FROM lms_exam_report r WHERE r.exam_report_user='$_SESSION[reid]' AND r.exam_report_paper='$exam_resalt[lms_exam_id]'");
if(mysqli_num_rows($check_exam)>0){
?>
<a href="#" class="btn btn-success btn-sm">AllReady Take</a>
	
<?php if($exam_resalt['lms_exam_end_time']<date("Y-m-d H:i:s")){ ?>	
<a href="results.php?view=<?php echo $exam_resalt['lms_exam_id']; ?>" style="color: white;" class="btn btn-success btn-sm">View</a>
<?php }else{ ?>
<a href="" style="color: white;" class="btn btn-success btn-sm">Waiting...</a>
<?php } ?>
	
<?php }else{ ?>
<a href="exam.php?exam_id=<?php echo $exam_resalt['lms_exam_id']; ?>" class="btn btn-success btn-sm">Take Exam</a>
<?php } ?>
</td>


<td><?php echo $exam_resalt['lms_exam_name']; ?></td>
<td><?php echo $exam_resalt['name']; ?></td>
<td><?php echo $exam_resalt['lms_exam_time_duration']."Min"; ?></td>
<td><?php echo $exam_resalt['lms_exam_question']; ?></td>
<td style="white-space: nowrap; font-weight: normal;">
Added: <?php echo date("Y-m-d h:i:s A",strtotime($exam_resalt['lms_exam_add_time'])); ?><br>
Start: <?php echo date("Y-m-d h:i:s A",strtotime($exam_resalt['lms_exam_start_time'])); ?><br>
End: <?php echo date("Y-m-d h:i:s A",strtotime($exam_resalt['lms_exam_end_time'])); ?>
</td>
</tr>
<?php
}
}
?>
</tbody>
</table>
            </div>
						</div>
				
					</div>
				</div>
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