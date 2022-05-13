<style>
	.sub_table{
		    border-collapse: collapse;
            width: auto;
            float: left;
            margin-left: auto;
            text-align:left;
	}
		.sub_table td{
		padding: 0px 5px;
	}
	.checkbox{
	    width:10px;
	}
</style>


<div class="row sub_table">

<?php

require_once("dashboard/conn.php");

$subject_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE class_id='$_GET[cid]' ORDER BY name");
if(!mysqli_num_rows($subject_qury)>0){
echo "Subject Not Found";
}

while($subject_resalt=mysqli_fetch_array($subject_qury)){
?>

<table class="table">
    <tr>
        <td class="checkbox">
            <input type="checkbox" name="subjects[]" class="form-control" style="width: 20px;height: 40px;"
                id="<?php echo $subject_resalt['sid']; ?>" value="<?php echo $subject_resalt['sid']; ?>">
        </td>
        <td>
            <label style="font-size: 15px; font-weight: bold; display: block;"
                for="<?php echo $subject_resalt['sid']; ?>">
                <?php echo $subject_resalt['name']; ?>
            </label>
        </td>
</table>

<?php
}
?>
</div>