<?php 
require_once 'conn.php';

if(isset($_GET['pi_id'])){
	mysqli_query($conn,"DELETE FROM paper_image WHERE pi_id='$_GET[pi_id]'");
}

if(isset($_POST['upload_btn'])){
	$change_name=time();
	$upload_path="paper_img/";
	$upload_file=$upload_path.basename($change_name.$_FILES["fileName"]["name"]);	
	$upload_real=str_replace(" ","_",$upload_file);
	
	move_uploaded_file($_FILES["fileName"]["tmp_name"], $upload_real);
	
	$database_name=str_replace(" ","_",$change_name.$_FILES["fileName"]["name"]);
	
	mysqli_query($conn,"INSERT INTO paper_image (pi_id, pi_exam_id, pi_image) VALUES (NULL, '$_GET[exam_id]', '$database_name')");
	
/*	echo $database_name."<br>";
	echo $upload_real;*/
}
?>
<form method="post" enctype="multipart/form-data" style="width: 100px; display: inline-block; vertical-align: top; margin: 5px;" onSubmit="change_name();">
	<label style="cursor: pointer;"><img src="images/img_upload.png" id="yourImgTag" style="width: 100px; height: 100px; object-fit: cover;">
	<input name="fileName" type="file" required="required" id="fileName" style="display: none;" onChange="dis_name();" accept="image/jpeg"></label>
	<button name="upload_btn" type="submit" style="display: block; width: 100%; margin-top: 5px;" id="sub_btn">Upload</button>
</form>

<style>
	*{
		padding: 0px;
		margin: 0px;
		box-sizing: border-box;
	}
	.img-div{
		width: 100px;
		border: 1px solid #EEEEEE;
		display: inline-block;
		vertical-align: top;
		margin: 5px;
	}
	.img-div textarea{
		width: 100%;
		resize: vertical;
		font-size: 10px;
	}
	.img-div img{
		width: 100%;
		height: 100px;
		object-fit: cover;
	}
	.img-div span{
		width: 20px;
		height: 20px;
		text-align: center;
		line-height: 20px;
		background-color: red;
		color: white;
		position: absolute;
		opacity: 0.5;
		border-radius: 100%;
		transition-duration: 0.5s;
		cursor: pointer;
		margin-top: 2px;
		margin-left: 2px;
	}
	.img-div span:hover{
		opacity: 1;
	}
</style>

<?php 
$img_qury=mysqli_query($conn,"SELECT * FROM paper_image WHERE pi_exam_id='$_GET[exam_id]' ORDER BY pi_id DESC ");
while($img_resalt=mysqli_fetch_assoc($img_qury)){
?>
<div class="img-div">
<a href="image_upload.php?pi_id=<?php echo $img_resalt['pi_id']; ?>&exam_id=<?php echo $_GET['exam_id']; ?>" onClick="return confirm('Image Remove?');"><span>&times;</span></a>
<img src="<?php echo $url;?>/lms/test/dashboard/paper_img/<?php echo $img_resalt['pi_image']; ?>">
<textarea readonly="readonly" onClick="this.select();"><?php echo "$url/lms/dashboard/paper_img/".$img_resalt['pi_image']; ?></textarea>
</div>
<?php } ?>

<script>
function dis_name(file_name){
var input = document.getElementById("fileName");
var fReader = new FileReader();
fReader.readAsDataURL(input.files[0]);
fReader.onloadend = function(event){
var img = document.getElementById("yourImgTag");
img.src = event.target.result;
}
}
	
function change_name(){
	document.getElementById('sub_btn').innerHTML="Uploading...";
}
</script>