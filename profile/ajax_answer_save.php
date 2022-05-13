<?php
session_start();
include '../dathboard/conn.php';

$lms_answer_identify=$_SESSION['lms_exam_system_id'].$_SESSION['reid'];
$lms_answer_a=$_GET['answer_val'];
$lms_answer_q=$_GET['question_val'];

$lmsck_qury=mysqli_query($conn,"SELECT * FROM lms_answer WHERE lms_answer_identify='$lms_answer_identify' and lms_answer_q='$lms_answer_q'");
$lmsck_resalt=mysqli_fetch_array($lmsck_qury);

if(mysqli_num_rows($lmsck_qury)>0){
mysqli_query($conn,"UPDATE lms_answer SET lms_answer_a='$lms_answer_a' WHERE lms_answer_identify='$lms_answer_identify' and lms_answer_q='$lms_answer_q'");	
}
else{
mysqli_query($conn,"INSERT INTO lms_answer(lms_answer_identify, lms_answer_q, lms_answer_a) VALUES ('$lms_answer_identify','$lms_answer_q','$lms_answer_a')");
}
?>