<?php
require_once("../dashboard/config.php");
if(!empty($_POST["cid"])) 
{
$query=mysqli_query($con,"SELECT * FROM lmsclass WHERE course = '" . $_POST["cid"] . "'");
?>
<option selected>Select Class</option>
<?php
while($row=mysqli_fetch_array($query))  
{
?>
<option value="<?php echo $row["cid"]; ?>"><?php echo $row["name"]; ?></option>
<?php
}
}
?>