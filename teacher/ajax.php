<?php
require_once("config.php");


if(isset($_POST["pid"])) 
{
$query =mysqli_query($con,"SELECT * FROM class WHERE course = '" . $_POST["pid"] . "'");
?>
<option value="">ඔබගේ පන්තිය තෝරන්න</option>
<?php
while($row=mysqli_fetch_array($query))  
{
?>
<option value="<?php echo $row["name"]; ?>"  data-id="<?php echo $row['id'];?>"><?php echo $row["name"]; ?></option>
<?php
}
}

if(isset($_POST["cid"])) 
{
$query =mysqli_query($con,"SELECT * FROM subject WHERE class_id = '" . $_POST["cid"] . "'");
?>
<?php
while($row=mysqli_fetch_array($query))  
{
?>
<option value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
<?php
}
}


?>
