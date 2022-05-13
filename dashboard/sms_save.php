<?php
require_once 'db.php';

$conn = mysqli_connect("localhost","$udbname","$dbpassword","$dbname");
$sender_id = $_POST['sender_id'];
$sa_token = $_POST['sa_token'];


$count_att=mysqli_query($conn,"SELECT COUNT(*) FROM lmssms ");
$row = mysqli_fetch_array($count_att);
$total = $row[0];


if($total > 0){
   
     

    if($sender_id == NULL && !empty($sa_token)){
        $sql = "UPDATE lmssms SET sa_token = '$sa_token';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='sms.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='sms.php?error';</script>";
         }
         mysqli_close($conn);
    }else if($sa_token == NULL && !empty($sender_id)){
        $sql = "UPDATE lmssms SET sender_id = '$sender_id';";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='sms.php?edit=$edit&update';</script>";
         } else {
           echo "<script>window.location='sms.php?error';</script>";
         }
         mysqli_close($conn);
      
      }else if($sender_id == NULL && $sa_token == NULL ){     
        
           echo "<script>window.location='sms.php?null';</script>";
        
      
         
        }else if(!empty($sa_token) && !empty($sender_id) ){
        $sql = "UPDATE lmssms SET sender_id = '$sender_id', sa_token= '$sa_token';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='sms.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='sms.php?error';</script>";
         }
         mysqli_close($conn);
    
    
   }   


}else{

    if(isset($_POST['submit'])){    
         
         $sql = "INSERT INTO lmssms (sender_id,sa_token)
         VALUES ('$sender_id','$sa_token')";
         if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='sms.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='sms.php?error';</script>";
         }
         mysqli_close($conn);
    }


 }
?>