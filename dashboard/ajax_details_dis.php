<?php
require_once("conn.php");
$userID=mysqli_real_escape_string($conn,$_GET['userID']);
$register_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$userID'");
if(mysqli_num_rows($register_qury)>0){
$register_resalt=mysqli_fetch_array($register_qury);
?>
<strong>Student Details</strong><hr>
<strong>Name: </strong><?php echo $register_resalt['fullname']; ?><br>
<strong>Contact: </strong><?php echo "0".(int)$register_resalt['contactnumber']; ?><br>
<?php
}
else{
	echo "<strong>Student Not Found</strong>";
}
?>