<?php
session_start();

if(isset($_GET['clear'])){
	unset($_SESSION['up_image_view']);
	header("location:upload_paper.php?exid=$_GET[exid]");
}

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

date_default_timezone_set("Asia/Colombo");
$current_time=date("Y-m-d H:i:s");

$loop=0;
$image_array=array();
if(isset($_POST['upload_btn'])){
	
	$exid=mysqli_real_escape_string($conn,$_GET['exid']);
	
	foreach($_FILES['image_file']['name'] as $image_file){

	$change_name=time().$_SESSION['reid'];
	$upload_path="uploadImg/paper/";
	$upload_file=$upload_path.basename($change_name.$_FILES["image_file"]["name"][$loop]);	
	$upload_real=str_replace(" ","_",$upload_file);
	
	move_uploaded_file($_FILES["image_file"]["tmp_name"][$loop], $upload_real);
	
	$database_name=str_replace(" ","_",$change_name.$_FILES["image_file"]["name"][$loop]);
	
	//echo $database_name;
	//echo $upload_real;
	array_push($image_array,$database_name);
		
	$loop++;
	}
	
	$up_image=json_encode($image_array);
	
	$_SESSION['up_image_view']=$up_image;
	
	if(mysqli_query($conn,"INSERT INTO
	exam_submissions (id, user_id, exam_id, filename, time, marks, status)
	VALUES (NULL, '$_SESSION[reid]', '$exid', '$up_image', '$current_time', '0', '0')")){
		header("location:upload_paper.php");
	}
	
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

	<title>My Exam Submissions | Online Learning Platforms  | Student Panel</title>

	<?php

	require_once 'headercss.php';

	?>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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

						<h2 class="st_title"><i class="uil uil-file-alt"></i> My Exam Submissions</h2>

					</div>					

				</div>				

				<div class="row">

				<!-- Your Profile Views Chart -->

				<div class="col-lg-12 m-b30">

					<div class="widget-box">

						<div class="widget-inner">

							<div class="noti-box-list">

<div class="card-body">

<?php if(!isset($_SESSION['up_image_view'])){ ?>

<p>You can upload multiple images.</p>

	

<form method="post" enctype="multipart/form-data">

<table>

<tbody>

<tr>

<td>

<input name="image_file[]" type="file" multiple="multiple" required="required" class="form-control" accept="image/jpeg">

</td>

<td><button name="upload_btn" type="submit" class="btn btn-success w-100">Upload Image's</button></td>

</tr>

</tbody>

</table>



</form>

<?php } ?>

	

<?php if(isset($_SESSION['up_image_view'])){ ?>

<p class="alert bg-success text-white">Thank you! Your Upload Image Preview.</p>

<?php 

$dis=json_decode($_SESSION['up_image_view']);

foreach($dis as $dis){

?>

<img src="uploadImg/paper/<?php echo $dis; ?>" style="width: 30%; height: 300px; object-fit: contain; border: 1px solid #CCCCCC; margin: 5px;">

<?php

}	

?>

	

<?php } ?>

</div>

							</div>

						</div>

					</div>

				</div>

				<!-- Your Profile Views Chart END-->

			</div>
			
			

			</div>

		</div>
		
		<div id="upload_modal" class="modal" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

    <form action="submissions.php" method="POST"  enctype="multipart/form-data">

      <div class="modal-header">

        <h5 class="modal-title">Upload Answer File</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      		<input type="file" name="file" class="form-control" required="required">

      		<input type="hidden" name="exam_id" id="exam_id">

      </div>

      <div class="modal-footer">

        <input type="submit" name="submit" class="btn btn-primary">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

  	</form>

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

<script type="text/javascript" src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	
<script>

$(".upload_btn").click(function () {
	var id = $(this).data("exam_id");
	console.log(id);
	$("#upload_modal").modal("show");
	$("#exam_id").val(id);
})


$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader( table );
} );
</script>

</body>
</html>