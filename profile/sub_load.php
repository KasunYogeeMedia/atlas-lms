<style>
	.sub_table{
		border-collapse: collapse;
		width: auto;
	}
	.sub_table td{
		padding: 0px 5px;
	}
</style>
<div class="ui search focus mt-30">
<table class="table table-bordered tabl-div">
<tbody>
<?php


session_start();
require_once("../dashboard/conn.php");

$user_qury=mysqli_query($conn,"SELECT * FROM lmsregister WHERE reid='$_SESSION[reid]'");
$user_resalt=mysqli_fetch_array($user_qury);

$reg_id = $user_resalt['contactnumber'];

$selected_subjects  = array();

$query1=mysqli_query($conn,"SELECT * FROM lmsreq_subject WHERE sub_req_reg_no =". $reg_id);

while($result=mysqli_fetch_assoc($query1)){
		$sub_id = $result['sub_req_sub_id'];
		array_push($selected_subjects, $sub_id);
}

$subject_qury=mysqli_query($conn,"SELECT * FROM lmssubject WHERE class_id='$_GET[cid]' ORDER BY name");
if(!mysqli_num_rows($subject_qury)>0){
echo "Subject Not Found";
}


while($subject_resalt=mysqli_fetch_array($subject_qury)){
	


		$checked_result=mysqli_query($conn,"SELECT *
										FROM lmssubject sm 
										INNER JOIN lmsreq_subject es ON sm.sid=es.sub_req_sub_id
										WHERE es.sub_req_sub_id='$subject_resalt[sid]' and es.sub_req_reg_no = '$user_resalt[contactnumber]'
										ORDER BY sm.sid");
				
		$sub_resalt=mysqli_fetch_array($checked_result);

		
		//echo $sub_resalt['sid'];
		echo $sub_resalt['pay_sub_id'];
						
						
	
	
	
	
?>
<tr>
<?php



	if(in_array($subject_resalt['sid'], $selected_subjects))
	{
?>
		<td><input type="checkbox" checked= "checked"  name="subjects[]" style="width: 20px" id="<?php echo $subject_resalt['sid']; ?>" value="<?php echo $subject_resalt['sid']; ?>"></td>
		<td><label style="font-size: 16px; font-weight: bold; display: block;" for="<?php echo $subject_resalt['sid']; ?>"><?php echo $subject_resalt['name']; ?></label></td>
<?php	
	}else{
?>

		<td><input type="checkbox" name="subjects[]" style="width: 20px" id="<?php echo $subject_resalt['sid']; ?>" value="<?php echo $subject_resalt['sid']; ?>"></td>
		<td><label style="font-size: 16px; font-weight: bold; display: block;" for="<?php echo $subject_resalt['sid']; ?>"><?php echo $subject_resalt['name']; ?></label></td>

<?php
} 
?>

</tr>

<?php
}
?>
</tbody>
</table>
</div>