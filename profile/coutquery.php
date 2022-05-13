<?php	
							
require_once '../dashboard/dbconfig4.php';

$stmt = $DB_con->prepare('SELECT COUNT(*) AS free_lesson_count FROM lmslesson where type="Free"');
$stmt->execute();
$result = $stmt->fetch();
$total_free_lesson = $result['free_lesson_count'];

$stmt = $DB_con->prepare('SELECT COUNT(*) AS paid_lesson_count FROM lmslesson where type="Paid"');
$stmt->execute();
$result = $stmt->fetch();
$total_paid_lesson = $result['paid_lesson_count'];

$stmt = $DB_con->prepare('SELECT COUNT(*) AS free_class_schlmsle_count FROM lmsclass_schlmsle where classtype="Free"');
$stmt->execute();
$result = $stmt->fetch();
$total_free_class_schlmsle = $result['free_class_schlmsle_count'];

$stmt = $DB_con->prepare('SELECT COUNT(*) AS paid_class_schlmsle_count FROM lmsclass_schlmsle where classtype="Payed"');
$stmt->execute();
$result = $stmt->fetch();
$total_paid_class_schlmsle = $result['paid_class_schlmsle_count'];

?>