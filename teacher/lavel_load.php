<select name="level" id="class_val" onChange="JavaScript:select_subject(this.value);" class="form-control simple course" required="" style="color:000000;">
<?php
require_once("../dashboard/conn.php");

$class_qury=mysqli_query($conn,"SELECT * FROM lmsclass WHERE course='$_GET[id]' ORDER BY name");
if(mysqli_num_rows($class_qury)>0){
echo "<option value=''>Select Level</option>";
}
else{
echo "<option value=''>Level Not Found</option>";
}
while($class_resalt=mysqli_fetch_array($class_qury)){
?>
<option value="<?php echo $class_resalt['cid']; ?>"><?php echo $class_resalt['name']; ?></option>
<?php
}
?>
</select>