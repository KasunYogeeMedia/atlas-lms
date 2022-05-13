<?php
require_once 'conn.php';
?>
<select name="subject" id="" required class="form-control">
<?php
$subject=mysqli_query($conn,"SELECT * FROM lmssubject WHERE class_id='$_GET[level_id]' ORDER BY name");
if(!mysqli_num_rows($subject)>0){
echo "<option hidden='lms'>Subject Not Found</option>";
}
while($subject_resalt=mysqli_fetch_array($subject)){
?>
<option value="<?php echo $subject_resalt['sid']; ?>"><?php echo $subject_resalt['name']; ?></option>
<?php
}
?>
</select>