<?php
session_start();
include '../dashboard/conn.php';
require_once '../dashboard/dbconfig4.php';
$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$image_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$image_resalt=mysqli_fetch_array($image_qury);

if($image_resalt['image']==""){
	$dis_image_path="img/pro_pick.png";
}
else{
	$dis_image_path="uploadImg/".$image_resalt['image'];
}

class imageUpload

{

	var $name = '';

	var $upload_path='uploadImg/';

	var $max_file_size=5000000;

	function __construct($name)

	{

		$this->name = $name;

	}

	private function checkExt($ext)

	{
		if($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif" ) {

			return 0;

		}else{

			return 1;

		}

	}

	private function checkFileSize($size)

	{

  		if ($size > $this->max_file_size) {

    		return 0;

  		}else{

    		return 1;

  		}

	}

	public function generateRandomString($length = 10) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	
    	for ($i = 0; $i < $length; $i++) {
        	$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	
    	return $randomString;
	}

	public function setUploadPath($path)

	{

		$this->upload_path = $path;

	}

	public function setMaxfileSize($size)

	{

		$this->max_file_size = $size;

	}

	public function upload()

	{

    	$img = basename($_FILES[$this->name]["name"]);

    	$ext = pathinfo($img,PATHINFO_EXTENSION);

    	$name = pathinfo($img,PATHINFO_FILENAME);

    	$size = $_FILES[$this->name]["size"];

    	if (!$this->checkExt($ext) || !$this->checkFileSize($size) || !getimagesize($_FILES[$this->name]["tmp_name"])) {

    		return 0;

		}else{

        	//$img_name = random_string(50);

        	$img_name = $this->generateRandomString(20);

        	$img_name = $img_name .'.'.$ext;

        	$img_path = $this->upload_path . $img_name;

        	//echo $img_path;

        	if (move_uploaded_file($_FILES[$this->name]["tmp_name"], $img_path)) {

        		return $img_name;

        	}else{

        		return 0;

        	}

    	}

    }

}

date_default_timezone_set('Asia/Colombo');

if (isset($_POST['submit'])) {

$user_id  = $_SESSION['reid'];
$exam_id  = $_POST['exam_id'];


$img = new imageUpload("file");
if ($filename = $img->upload()) {
	$success = 1;

$sql = "INSERT INTO exam_submissions (user_id, exam_id, filename) VALUES (".$user_id.", ".$exam_id.", '".$filename. "')";

mysqli_query($conn, $sql);

}else{
	$error = 1;
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
						<h2 class="st_title"><i class="uil uil-file-alt"></i>My Exam Submissions</h2>
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
							<table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
<thead>
<tr>
<td>#</td>
<td>Exam Details</td>
<td>Upload</td>
<td>Submitted Date/Time</td>
<td>Due Date/Time</td>
<td>Marks</td>
<td>Status</td>
<td>Remak</td>
</tr>
</thead>
<tbody>
	
<?php
$cont=0;
$list_qury=mysqli_query($conn,"SELECT e.exid,s.name sname,e.examname,e.edate,e.exam_end_date,e.starttime,e.endtime
FROM lmsonlineexams e LEFT JOIN lmssubject c ON e.subject=c.sid
LEFT JOIN lmssubject s on e.subject=s.sid
ORDER BY e.exid DESC");
while($list_resalt=mysqli_fetch_assoc($list_qury)){
$cont++;
$check_qury=mysqli_query($conn,"SELECT * FROM exam_submissions e WHERE e.user_id='$_SESSION[reid]' AND e.exam_id='$list_resalt[exid]'");
if(mysqli_num_rows($check_qury)>0){
$check_resalt=mysqli_fetch_assoc($check_qury);
$rate=rate_count($check_resalt['marks']);
$mark=$check_resalt['marks']."%";
$submit_time=date("M d, Y h:i:s A",strtotime($check_resalt['time']));
$upload_btn=false;
if($check_resalt['status']==1){
$status="Receive and mark";
}
else{
$status="Pending approval";
}

}
else{
$rate="N/A";
$mark="N/A";
$submit_time="N/A";
$upload_btn=true;
$status="Open";
}
?>
	
<tr>
<td><?php echo $cont; ?></td>
<td style="font-weight: normal; text-transform: capitalize;" class="<?php if(isset($_GET['exid'])){ if($_GET['exid']==$list_resalt['exid']){echo "bg-info";} } ?>">
<?php echo $list_resalt['examname']; ?><br>
<?php echo $list_resalt['sname']; ?>
</td>
<td style="font-weight: normal;">
	
<?php 
$current_date=date("Y-m-d H:i:s");
if($list_resalt['edate']<$current_date&&$current_date<$list_resalt['exam_end_date']){ ?>
	
<?php if($upload_btn==true){ ?><a href="upload_paper.php?exid=<?php echo $list_resalt['exid']; ?>&clear" class="btn btn-sm btn-success">Upload Answer</a><?php } ?>
<?php if($upload_btn==false){ ?><a href="#" class="btn btn-sm" style="background-color: darkred;">Allready uploaded</a><?php } ?>
	
<?php }else{ ?>
<a href="#" class="btn btn-sm" style="background-color: darkred;">Exam Expired</a>
<?php } ?>
<td style="font-weight: normal;"><?php echo $submit_time; ?></td>
<td style="font-weight: normal;">
<?php echo date("Y-m-d h:i:s A",strtotime($list_resalt['edate'])); ?><br>
<?php echo date("Y-m-d h:i:s A",strtotime($list_resalt['exam_end_date'])); ?>
</td>
<td style="font-weight: normal;" align="center"><?php echo $mark; ?><br><span class="badge badge-info"><?php echo $rate; ?></span></td>
<td style="font-weight: normal;"><?php echo $status; ?></td>
<td style="font-weight: normal; white-space: pre;"><?php if(isset($check_resalt)){ echo $check_resalt['remark']; } ?></td>
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
</script>s

</body>

</html>