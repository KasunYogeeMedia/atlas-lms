<?php
session_start();
include '../dashboard/conn.php';
require_once("../dashboard/config.php"); 
require_once '../dashboard/dbconfig4.php';
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

$msg = '';

$msg5 = '';	

if(isset($_POST['add_review']))

{

		$uid = $stid;
		
		$tealmsr = $_POST['tealmsr'];
		
		$title = $_POST['title'];
		
		$rate = $_POST['rate'];
		
		$review = $_POST['review'];

		if(empty($tealmsr)){
			$errMSG = "Please Select Tealmsr.";
		}
		else if(empty($title)){
			$errMSG = "Please Enter Title.";
		}
		else if(empty($rate)){
			$errMSG = "Please Select Rate.";
		}
		else if(empty($review)){
			$errMSG = "Please Enter Review.";
		}

		if(!isset($errMSG))

		{

			$stmt = $DB_con->prepare('INSERT INTO lmscomments(uid,tealmsr,title,rate,review,status) VALUES(:uid,:tealmsr,:title,:rate,:review,"1")');
			
			$stmt->bindParam(':uid',$uid);
			
			$stmt->bindParam(':tealmsr',$tealmsr);
			
			$stmt->bindParam(':title',$title);
			
			$stmt->bindParam(':rate',$rate);
			
			$stmt->bindParam(':review',$review);
			
			if($stmt->execute())

			{

				$successMSG = "Successfully! Add Your Review....";

				header("refrelms:2;reviews.php"); // redirects image view page after 5 seconds.

			}

			else

			{

				$errMSG = "error while inserting....";

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
	<title>Review | Online Learning Platforms  | Student Panel</title>
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
					<div class="col-lg-12">
						<h2 class="st_title">Review</h2> 
					</div>
						<form action="reviews.php" method="post">
						<div class="basic_profile">
						<div class="col-lg-12">
							<div class="basic_ptitle">
								<h4>Add Your Review</h4>
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
															<option selected="">Select Teacher</option>
															<?php

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
														<input class="prompt srch_explore" type="text" placeholder="Enter Title" name="title" required>															
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<label class="col-form-label">Rating</label>
												<div class="ui search focus mt-30">
													<div class="ui left icon input swdh11 swdh19">
														<select name="rate" class="form-control simple course" style="color:#000000;" required="">
															<option selected="">Select Star Rating</option>
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
												<textarea class="form-control" type="text" rows="6" placeholder="Enter Your Review" name="review" required></textarea>
											</div>
										</div>
									</div>
							   </div>
						   </div>
						   <div class="col-lg-12 subite-prof">
						   <div class="row">
						   <div class="col-md-6">
								<input type="submit" name="add_review" class="btn btn-primary btn-block" value="Submit Review">	
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
		<br><br>
		<div class="container-fluid">
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12">
									<div class="review_right">
										<div class="review_right_heading">
											<h3>My All Reviews</h3>
											<hr>
										</div>
									</div>
<?php
$count=0;
$list_qury=mysqli_query($conn,"SELECT * FROM lmscomments INNER JOIN lmsregister ON lmscomments.uid=lmsregister.reid where lmscomments.uid='$_SESSION[reid]' and lmscomments.status='1' ORDER BY id DESC");

while($list_resalt=mysqli_fetch_array($list_qury)){
$count++;

?>
									<div class="review_all120">
										<div class="review_item_course_title">
											<a href="#"><?php echo $list_resalt['title']; ?></a>
										</div>
										<div class="review_item">
											<div class="review_usr_dt">
												<?php if($list_resalt['image']==""){$pro_img="../profile/images/hd_dp.jpg";}else{$pro_img="../profile/uploadImg/".$list_resalt['image'];} ?><img src="<?php echo $pro_img; ?>" id="dis_image" style="width: 44px; height: 44px; border-radius: 100%; cursor: pointer; object-fit: cover; background-position: center;">
												<div class="rv1458">
													<h4 class="tutor_name1"><?php echo $list_resalt['fullname']; ?></h4>
													<span class="time_145"><?php echo $list_resalt['add_date']; ?></span>
												</div>
											</div>
											<?php 
						
							if($list_resalt['rate'] == "1"){

								echo '<div class="rating-box mt-20">
												<span class="rating-star full-star"></span>
											</div>';

							}else if($list_resalt['rate'] == "2"){

								echo '<div class="rating-box mt-20">
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
											</div>';

							}else if($list_resalt['rate'] == "3"){

								echo '<div class="rating-box mt-20">
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
											</div>';

							}else if($list_resalt['rate'] == "4"){

								echo '<div class="rating-box mt-20">
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
											</div>';

							}else if($list_resalt['rate'] == "5"){

								echo '<div class="rating-box mt-20">
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
												<span class="rating-star full-star"></span>
											</div>';

							}
						
						?>
											
											<p class="rvds10">"<?php echo $list_resalt['review']; ?>"</p>
											<hr>
											<a href="delete_review.php?rvid=<?php echo $list_resalt["id"]; ?>" class="btn btn-danger">Delete Review</a>
											<a href="edit_reviews.php?rvid=<?php echo $list_resalt["id"]; ?>" class="btn btn-primary">Edit Review</a>
											
										</div>
									</div>
<?php 
}
?>
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