<?php

session_start();

require_once '../dashboard/dbconfig4.php';

require_once("../dashboard/config.php"); 

include '../dashboard/conn.php';

if (!isset($_SESSION['reid'])) {

    header('location:../login.php');

    die();

}
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister INNER JOIN lmsclass ON lmsregister.level=lmsclass.cid WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$image_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$image_resalt=mysqli_fetch_array($image_qury);

if($image_resalt['image']==""){
	$dis_image_path="images/hd_dp.jpg";
}
else{
	$dis_image_path="uploadImg/".$image_resalt['image'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="https://siyosip.lk/lms/">
	<meta name="author" content="https://siyosip.lk/lms/">
	<title>Bank Payment | Online Learning Platforms | Student Panel</title>
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
						<h2 class="st_title"><i class="uil uil-file-alt"></i> Bank Payment History</h2>
					</div>					
				</div>				
				<div class="row">					
					<div class="col-lg-12 col-md-12">
						<ul class="more_options_tt">
							<li><button class="more_items_14 active">This Month</button></li>
							<li><button class="more_items_14">Last Month</button></li>
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
							<table class="table ucp-table earning__table" id="content-table">
								<thead class="thead-s">
									<tr>
										<th scope="col">Status</th>
										<th scope="col">Grade/Subject</th>
										<th scope="col">Slip</th>
										<th scope="col">Amount</th>																		
										<th scope="col">Valid Date - Paid Month</th>
										<th scope="col">Pay Date</th>
									</tr>
								</thead>
								<tbody>
<?php
$today_time=date("Y-m-d");

$payment_qury=mysqli_query($conn,"SELECT * FROM lmspayment WHERE paymentMethod='Bank' and userID='$_SESSION[reid]' ORDER BY pid DESC");
while($payment_resalt=mysqli_fetch_array($payment_qury)){
?>
									<tr>										
										<td><?php
if($payment_resalt['status']==0){
?>
<span class="badge badge-warning">Pending</span>
<?php
}
elseif($payment_resalt['status']==1){
?>
<span class="badge badge-success">Active</span>
<?php
}
elseif($payment_resalt['status']==2){
?>
<span class="badge badge-danger">Reject</span>
<?php
}
?></td>	
										<td><span class="badge badge-warning"><?php
$sub_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE sid='$payment_resalt[pay_sub_id]'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
?> <?php echo $sub_resalt['name']; ?>

- 

<?php
$cl_qury=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$sub_resalt[class_id]'");
while($cl_resalt=mysqli_fetch_array($cl_qury)){
?> <?php echo $cl_resalt['name']; ?> <?php }} ?> 
</span></td>	
										<td><a href="<?php echo "$url/profile/uploadslip/".$payment_resalt['fileName']; ?>" target="_blank" class="badge badge-primary">View Slip</a></td>	
										<td><span class="badge badge-primary">Rs.<?php echo number_format($payment_resalt['amount'],2); ?></span></td>	
										<td><a href="#"><span class="badge badge-success" style="font-size:14px;">Valid Date : <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($payment_resalt['expiredate']),"M d, Y"); ?> - Paid Month : <i class="fa fa-check-circle"></i> <?php echo date_format(date_create($payment_resalt['pay_month']),"F"); ?></span></a></td>
										<td><?php echo date_format(date_create($payment_resalt['created_at']),"M d, Y | h:i:s A"); ?></td>	
									</tr>
<?php
}
?>
								</tbody>				
							</table>
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