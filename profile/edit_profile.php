<?php
session_start();
if(!isset($_SESSION['reid']))
{		
header('location:login.php');
die();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['reid'];

require_once("../dashboard/config.php"); 

require_once '../dashboard/dbconfig4.php';

require_once("../dashboard/conn.php"); 

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

$edit_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid=$user_id");
$edit_resalt=mysqli_fetch_array($edit_qury);

$edit_lavel=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$edit_resalt[level]'");
$edit_lavel_dis=mysqli_fetch_array($edit_lavel);

$stmt_edit = $DB_con->prepare('SELECT * FROM lmsregister WHERE reid =:regid');

$stmt_edit->execute(array(':regid'=>$user_id));

$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);

$studentID = $edit_resalt['contactnumber'];

extract($edit_row);

	if(isset($_POST['update']))

	{

		$fullname = $_POST['fullname'];


		$contactnumber = (int)$_POST['contactnumber'];

		$address = mysqli_real_escape_string($con,$_POST['address']);
		
		if(!isset($errMSG))

		{

			$stmt = $DB_con->prepare("UPDATE lmsregister SET fullname='$fullname',contactnumber='$contactnumber',address='$address' WHERE reid = '".$user_id."'");

			if($stmt->execute()){
				
				$msg = "User Profile Successfully Updated";

			}

			else
				
			{

				$errMSG = "Sorry Data Could Not Updated !";

			}
			
			}

	}

if(isset($_POST['update'])){
	
	if(!empty($_POST['subjects'])){
	mysqli_query($conn,"DELETE FROM lmsreq_subject WHERE sub_req_reg_no='$contactnumber'");
	foreach($_POST['subjects'] as $subject_list){		
		mysqli_query($conn,"INSERT INTO lmsreq_subject(sub_req_reg_no, sub_req_sub_id) VALUES ('$contactnumber','$subject_list')");
	}
	mysqli_query($conn,"UPDATE lmsregister SET level='$_POST[level]' WHERE reid='$user_id'");
	}	
}


if(isset($_POST['change_password'])){
	
	$old_password=md5(mysqli_real_escape_string($con,$_POST['old_password']));
	$password=md5(mysqli_real_escape_string($con,$_POST['password']));
	$re_password=md5(mysqli_real_escape_string($con,$_POST['re_password']));
	
	if($old_password==$edit_resalt['password']){
		
		if($password==$re_password){
			mysqli_query($con,"UPDATE lmsregister SET password='$password' WHERE reid='$user_id'");
			echo "<script>window.location='../logout.php';</script>";
		}
		else{
			//re pass not match
			echo "<script>window.location='edit_profile.php?re_pass#pass_dis';</script>";
		}
		
	}
	else{
		//current password not match
		echo "<script>window.location='edit_profile.php?current_pass#pass_dis';</script>";
	}
}

$jpg_upload=0;
if(isset($_POST['update_picture'])){
if(!$_FILES['user_image']['name']==""){
	if ($_FILES['user_image']['type']=="image/jpeg"){
              $imagename = time().$_FILES['user_image']['name'];
              $source = $_FILES['user_image']['tmp_name'];
              $target = "uploadImg/".str_replace(" ","_",$imagename);
			  $db_send_name = str_replace(" ","_",$imagename);
              move_uploaded_file($source, $target);

              $imagepath = $imagename;
              $save = "uploadImg/" . $imagepath; //This is the new file you saving
              $file = "uploadImg/" . $imagepath; //This is the original file

              list($width, $height) = getimagesize($file) ;

              $modwidth = 400;

              $diff = $width / $modwidth;

              $modheight = $height / $diff;
              $tn = imagecreatetruecolor($modwidth, $modheight) ;
              $image = imagecreatefromjpeg($file) ;
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

              imagejpeg($tn, $save, 100) ;
		mysqli_query($conn,"UPDATE lmsregister SET image='$db_send_name' WHERE reid='$_SESSION[reid]'");
		echo "<script>window.location='edit_profile.php?image_upload';</script>";
	}
	else{
		echo "<script>window.location='edit_profile.php?jpg_image';</script>";
	}
	}
	else{
	}
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="Gambolthemes">
	<meta name="author" content="Gambolthemes">
	<title>Edit Profile | Online Learning Platforms  | Student Panel</title>
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
						<h2 class="st_title">Edit My Profile</h2> 
						<div class="basic_profile">
						<form method="post">
							<div class="basic_ptitle">
								<h4>1. Edit My Profile Details</h4>
								<hr>
							</div>
<?php
if (isset($errMSG)) {
	echo '<h2 style="background-color:#ff0000; text-align:center; width: 100%; color: #ffffff; padding: 8px 8px;">'.$errMSG.'</h2>';
}else if (isset($msg)) {
	echo '<h2 style="background-color:#00ff00;text-align:center; width: 100%; color: #ffffff; padding: 8px 8px;">'.$msg.'</h2>';
}

?>

									<div class="col-lg-12 div-sec">
										<div class="row">
											<div class="col-md-4">
												<label class="col-form-label">Full Name</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<input class="prompt srch_explore" type="text" name="fullname" value="<?php echo $fullname; ?>" required>															
													</div>
												</div>
											</div>
											
											<div class="col-md-2">
												<label class="col-form-label">Phone Number</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<input class="prompt srch_explore" type="text" name="contactnumber"  value="<?php echo "0".(int)$contactnumber; ?>" readonly required>															
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label class="col-form-label">Address</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<input class="prompt srch_explore" type="text" name="address"  value="<?php echo $address; ?>" required>															
													</div>
												</div>
											</div>
								</div>
							</div>

							<div class="basic_ptitle">
								<h4>2. Class Details
								</h4>
							
							</div>
							<div class="col-lg-12">
<?php
$edit_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid=$user_id");
$edit_resalt=mysqli_fetch_array($edit_qury);

$edit_lavel=mysqli_query($conn,"SELECT * FROM lmsclass WHERE cid='$edit_resalt[level]'");

$reg_id = $edit_resalt["contactnumber"];

$edit_lavel_dis=mysqli_fetch_array($edit_lavel);
?>
	
								<div class="row">
									<div class="col-md-5">
								
										<label class="col-form-label">Grade</label>
										<div class="ui search focus mt-30">
											<div class="ui left icon input swdh11 swdh19">
											<span id="class_load">
												<select name="level" required="" id="class_val" onchange="JavaScript:select_subject(this.value);" class="form-control simple" style="border: 2px solid #ccc;">
													<option value="" hidden="yes">Select Grade</option>
					   <?php																															
					   $stmt = $DB_con->prepare('SELECT * FROM lmsclass ORDER BY cid');								
					   $stmt->execute();								
					   if($stmt->rowCount() > 0)								
					   {								
					   while($row=$stmt->fetch(PDO::FETCH_ASSOC))								
					   {								
					   extract($row);								
					   ?>                        
					   <option <?php if($edit_row['level'] == $row['cid']){echo 'selected="selected"'; } ?>  value="<?php echo $row['cid']; ?>"><?php echo $row['name']; ?></option>                        
					   <?php } 								
					   }								
					   ?>                        
												 
													</select>	
												</span>	
											</div>
										</div>
									</div>
								<?php
$selected_subjects  = array();

$query1=mysqli_query($conn,"SELECT * FROM lmsreq_subject WHERE sub_req_reg_no =". $reg_id);

while($result=mysqli_fetch_assoc($query1)){
		$sub_id = $result['sub_req_sub_id'];
		array_push($selected_subjects, $sub_id);
}


?>
<script>
						function select_subject(sub_val){
							  var xhttp = new XMLHttpRequest();
							  xhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
								 document.getElementById("sub_load").innerHTML = this.responseText;
								}
							  };
							  xhttp.open("GET", "sub_load.php?cid="+sub_val, true);
							  xhttp.send();
						}
						</script>
									<div class="col-md-7">

										<label class="col-form-label">Subject</label>
										<div class="ui search focus mt-30">
										<div id="sub_load">
										Subject Not Found
										</div>
						</div>
					</div>

							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-md-12 text-sec">
											<br>
											<hr>
											<span class="badge badge-success" style="font-weight:bold;font-size:16px;color:#ffffff;"><label class="col-form-label">Current Subject :</label>
											<hr style="background-color:#ffffff;">
											<?php
$a=array();
$sub_qury=mysqli_query($conn,"SELECT * FROM lmsreq_subject INNER JOIN lmssubject ON lmsreq_subject.sub_req_sub_id=lmssubject.sid WHERE sub_req_reg_no='$contactnumber'");
while($sub_resalt=mysqli_fetch_array($sub_qury)){
array_push($a,$sub_resalt['name']);
}
echo join(", ",$a);
?></span>
</div><br>
											</div>
								</div>
							</div>
		
								
						</div>
					</div>




					<div class="col-lg-12 subite-prof">
						<div class="row">
							<div class="col-md-6">
							<input type="submit" name="update" class="btn btn-primary btn-block" value="Update Profile">
							<br>	
							</div>
							<div class="col-md-6">
							<a href="edit_profile.php" class="btn btn-danger btn-block">Close</a>	
							</div>
						</div>
				    </div>
			</div>	
			</form>	
		</div>
		</div>		
		</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="basic_profile">
					<form method="post" enctype="multipart/form-data">
						<?php if(isset($_GET['jpg_image'])){ ?><div class="alert alert-danger"><strong>Fail!</strong> Please select JPG image.</div><?php } ?>
						<?php if(isset($_GET['image_upload'])){ ?><div class="alert alert-info"><strong>Successfully!</strong> Profile update successfully.</div><?php } ?>
						<div class="basic_ptitle">
							<h4>3.Edit My Profile Picture</h4>
							<hr>
						</div>
								<div class="col-lg-12 div-sec">
									<div class="row">
										<div class="col-md-4">
											<label class="col-form-label">Profile Image
											</label>
											<div class="ui search focus mt-30">
												<div class="ui left icon input swdh11 swdh19">
												<label for="up_image"><img src="<?php echo $dis_image_path; ?>" id="dis_image" style="width: 200px; height: 200px; border: 1px solid #EEE; border-radius: 100%; cursor: pointer; object-fit: cover; background-position: center;"></label>
												<input accept="image/jpeg" class="form-control" required type="file" name="user_image" id="up_image" style="display: none;" onChange="JavaScript:dis_name();">
											
<script>
function dis_name(file_name){
var input = document.getElementById("up_image");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);
fReader.onloadend = function(event){
var img = document.getElementById("dis_image");
img.src = event.target.result;
}
}
</script>
												</div>
											</div>
										</div>
							</div>
						</div>
				<div class="col-lg-12 subite-prof">
					<div class="row">
						<div class="col-md-6">
						<input type="submit" name="update_picture" class="btn btn-primary btn-block" value="Update Profile Picture">							
						</div>
						<div class="col-md-6">
							<a href="edit_profile.php" class="btn btn-danger btn-block">Close</a>
						</div>
					</div>	
				</div>
		</form>
		</div>					
		</div>
		</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div class="basic_profile">
					<form class="edit-profile m-b30" method="post">
						<div class="basic_ptitle">
							<h4>Change My Password</h4>
							<hr>
						</div>
								<div class="col-lg-12 div-sec">
									<div class="row">
										<div class="col-md-4">
											<label class="col-form-label">Old Password
											</label>
											<div class="ui search focus mt-30">
												<div class="ui left icon input swdh11 swdh19">
													<input class="form-control" type="password" placeholder="Enter Old Password" name="old_password" required>															
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<label class="col-form-label">New Password
											</label>
											<div class="ui search focus mt-30">
												<div class="ui left icon input swdh11 swdh19">
													<input class="form-control" type="password" placeholder="Enter New Password" name="password" required>														
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<label class="col-form-label">Confirm Password
											</label>
											<div class="ui search focus mt-30">
												<div class="ui left icon input swdh11 swdh19">
													<input class="form-control" type="password" placeholder="Confirm New Password" name="re_password" required>															
												</div>
											</div>
										</div>

							</div>
						</div>
				<div class="col-lg-12 subite-prof">
					<div class="row">
						<div class="col-md-6">
							<input type="submit" name="change_password" class="btn btn-primary btn-block" value="Change Password">
						</div>
						<div class="col-md-6">
							<a href="edit_profile.php" class="btn btn-danger btn-block">Close</a>
						</div>
					</div>	
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
<script>
// Pricing add
	function newMenuItem() {
		var newElem = $('tr.list-item').first().clone();
		newElem.find('input').val('');
		newElem.appendTo('table#item-add');
	}
	if ($("table#item-add").is('*')) {
		$('.add-item').on('click', function (e) {
			e.preventDefault();
			newMenuItem();
		});
		$(document).on("click", "#item-add .delete", function (e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().remove();
		});
	}
</script>
</body>
</html>