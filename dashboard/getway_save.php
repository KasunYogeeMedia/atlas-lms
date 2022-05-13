<?php
require_once 'db.php';

$conn = mysqli_connect("localhost","$udbname","$dbpassword","$dbname");
$app_id = $_POST['app_id'];
$hash_salt = $_POST['hash_salt'];
$a_token = $_POST['a_token'];


$count_att=mysqli_query($conn,"SELECT COUNT(*) FROM lmsgetway ");
$row = mysqli_fetch_array($count_att);
$total = $row[0];


if($total > 0){
   
     

    if($app_id == NULL && !empty($a_token) && $hash_salt == NULL){
        $sql = "UPDATE lmsgetway SET a_token = '$a_token';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='getway.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='getway.php?error';</script>";
         }
         mysqli_close($conn);
    }else if($a_token == NULL && !empty($app_id) && $hash_salt == NULL){
        $sql = "UPDATE lmsgetway SET app_id = '$app_id';";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='getway.php?edit=$edit&update';</script>";
         } else {
           echo "<script>window.location='getway.php?error';</script>";
         }
         mysqli_close($conn);
    }else if($a_token == NULL && !empty($hash_salt) && $app_id == NULL){
        $sql = "UPDATE lmsgetway SET hash_salt = '$hash_salt';";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='getway.php?edit=$edit&update';</script>";
         } else {
           echo "<script>window.location='getway.php?error';</script>";
         }
         mysqli_close($conn);
         
      }else if($app_id == NULL && $a_token == NULL && $hash_salt == NULL){     
        
           echo "<script>window.location='getway.php?null';</script>";
        
      
           
    
    
   }   


}else{

    if(isset($_POST['submit'])){    
         
         $sql = "INSERT INTO lmsgetway (app_id, a_token, hash_salt)
         VALUES ('$app_id','$a_token','$hash_salt')";
         if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='getway.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='getway.php?error';</script>";
         }
         mysqli_close($conn);
    }


 }
?>