<?phpsession_start();require_once '../dashboard/dbconfig4.php';require_once("../dashboard/config.php"); include '../dashboard/conn.php';if (!isset($_SESSION['reid'])) {    header('location:../login.php');    die();}
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister INNER JOIN lmsclass ON lmsregister.level=lmsclass.cid WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$image_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$image_resalt=mysqli_fetch_array($image_qury);

$stid=$image_resalt['reid'];

if($image_resalt['image']==""){
	$dis_image_path="images/hd_dp.jpg";
}
else{
	$dis_image_path="uploadImg/".$image_resalt['image'];
}

if(isset($_GET['rvid']) && !empty($_GET['rvid']))

	{

		$id = $_GET['rvid'];

		$stmt_edit = $DB_con->prepare('SELECT * FROM lmscomments WHERE id=:rvid');

		$stmt_edit->execute(array(':rvid'=>$id));

		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);

		extract($edit_row);

	}

	else

	{

		header("Location: reviews.php");

	}	

	if(isset($_POST['update']))

	{

		$tealmsr = $_POST['tealmsr'];

		$title = $_POST['title'];
		
		$rate = $_POST['rate'];
		
		$review = $_POST['review'];

		if(!isset($errMSG))

		{

			$stmt = $DB_con->prepare('UPDATE lmscomments

									     SET tealmsr=:tealmsr,	
		
										     title=:title,
											 
											 rate=:rate,
											 
											 review=:review

								       WHERE id=:rvid');

			$stmt->bindParam(':tealmsr',$tealmsr);
			
			$stmt->bindParam(':title',$title);
			
			$stmt->bindParam(':rate',$rate);

			$stmt->bindParam(':review',$review);

			$stmt->bindParam(':rvid',$id);

			if($stmt->execute()){

				$successMSG = "Review Successfully Updated ...";
				
				echo "<script type='text/javascript'>window.location.href = 'reviews.php';</script>";

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
	<meta name="viewport" content="width=device-width, shrink-to-fit=9">
	<meta name="description" content="Gambolthemes">
	<meta name="author" content="Gambolthemes">
	<title>Edit Reviews | Online Learning Platforms | Student Panel</title>
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
						<h2 class="st_title">Review</h2> 
						<form action="" class="edit-profile m-b30" method="POST">
						<div class="basic_profile">
							<div class="col-lg-12">
							<div class="basic_ptitle">
								<h4>Edit Your Review</h4>
								<hr>
							</div>
						</div>
									<div class="col-lg-12 div-sec">
									<?php

			if(isset($errMSG)){

			?>

            <div class="alert alert-danger">

            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>

            <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a></div>

            <?php

			}

			else if(isset($successMSG)){

			?>

			<div class="alert alert-success">

              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>

			<a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a></div>

			<?php

			}

			?>
				
										<div class="row">
											<div class="col-md-3">
												<label class="col-form-label">Teacher</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<select name="tealmsr" class="form-control simple course" style="color:000000;" required="">
															<option value="<?php

						$id = $tealmsr;  

						$query = $DB_con->prepare('SELECT tid FROM lmstealmsr WHERE tid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['tid'];

						 ?>"><?php

						$id = $tealmsr;  

						$query = $DB_con->prepare('SELECT fullname FROM lmstealmsr WHERE tid='.$id);

						$query->execute();

						$result = $query->fetch();

						echo $result['fullname'];

						 ?></option>
											<?php
											
											require_once '../dashboard/dbconfig4.php';
											
											$stmt = $DB_con->prepare('SELECT * FROM lmstealmsr ORDER BY tid');

											$stmt->execute();

											if($stmt->rowCount() > 0)

											{

											while($row=$stmt->fetch(PDO::FETCH_ASSOC))

											{

											extract($row);

											?>
											<option value="<?php echo $row['tid']; ?>"><?php echo $row['fullname']; ?></option>
											<?php 
											}
											}
											?>
														</select>														
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label">Title</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<input class="prompt srch_explore" type="text" placeholder="Enter Title" name="title" value="<?php echo $title; ?>" required>															
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label class="col-form-label">Rating</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<select name="rate" class="form-control simple course" style="color:#000000;" required="">
															<option value="<?php echo $rate; ?>"><?php echo $rate; ?> Star</option>
															<option value="1">1 Star</option>
															<option value="2">2 Star</option>
															<option value="3">3 Star</option>
															<option value="4">4 Star</option>
															<option value="5">5 Star</option>
															</select>													
													</div>
												</div>
											</div>	
								</div>
							</div>
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-12">
								
										<label class="col-form-label">Review</label>
										<div class="ui search focus mt-30">
											<div class="ui left icon input swdh11 swdh19">
												<textarea class="form-control" type="text" rows="6" placeholder="Enter Your Review" name="review" required><?php echo $review; ?></textarea>
											</div>
										</div>
									</div>
							   </div>
						   </div>
						   <div class="col-lg-12 subite-prof">
						   <div class="row">
						   <div class="col-md-6">
								<input type="submit" name="update" class="btn btn-primary btn-block" value="Edit Review">	
						  </div>
						  <div class="col-md-6">
								<a href="review.php" class="btn btn-danger btn-block">Close</a>
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