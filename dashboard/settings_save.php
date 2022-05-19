<?php
require_once 'db.php';

$conn = mysqli_connect("localhost","$udbname","$dbpassword","$dbname");
$rgname_prefix = $_POST['rgname_prefix'];
$ap_name = $_POST['ap_name'];
if (isset($_POST['submit'])) {
   $main_logo = $_FILES["main_logo"]["name"];
   $tempname = $_FILES["main_logo"]["tmp_name"];    
   $folder = "settings/logo/".$main_logo;
  
}

$count_att=mysqli_query($conn,"SELECT COUNT(*) FROM settings ");
$row = mysqli_fetch_array($count_att);
$total = $row[0];


if($total > 0){
   
     

    if($main_logo == NULL && $rgname_prefix == NULL && !empty($ap_name)){
        $sql = "UPDATE settings SET application_name = '$ap_name';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='settings.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='settings.php?error';</script>";
         }
         mysqli_close($conn);
    }else if($main_logo == NULL && $ap_name == NULL && !empty($rgname_prefix)){
        $sql = "UPDATE settings SET reg_prefix = UPPER('$rgname_prefix');";
        if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='settings.php?edit=$edit&update';</script>";
         } else {
           echo "<script>window.location='settings.php?error';</script>";
         }
         mysqli_close($conn);
      
      }else if($rgname_prefix == NULL && $ap_name == NULL && !empty($main_logo)){     
         $sql = "UPDATE settings SET main_logo = '$main_logo';";
        if (mysqli_query($conn, $sql)) {
               if (move_uploaded_file($tempname, $folder))  {
                  $msg = "Image uploaded successfully";
            }else{
                  $msg = "Failed to upload image";
            }
         echo "<script>window.location='settings.php?edit=$edit&update';</script>";
         } else {
           echo "<script>window.location='settings.php?error';</script>";
         }
         mysqli_close($conn);
      }else if($rgname_prefix == NULL && !empty($ap_name) && !empty($main_logo)){    
         $sql = "UPDATE settings SET application_name = '$ap_name', main_logo = '$main_logo';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='settings.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='settings.php?error';</script>";
         }
         mysqli_close($conn);
      }else if(!empty($rgname_prefix) && $ap_name == NULL && !empty($main_logo)){ 
         $sql = "UPDATE settings SET reg_prefix = '$rgname_prefix', main_logo = '$main_logo';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='settings.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='settings.php?error';</script>";
         }
         mysqli_close($conn);
         
        }else if(!empty($ap_name) && !empty($rgname_prefix) && !empty($main_logo) ){
        $sql = "UPDATE settings SET reg_prefix = UPPER('$rgname_prefix'), application_name= '$ap_name', main_logo= '$main_logo';";
        if (mysqli_query($conn, $sql)) {
         echo "<script>window.location='settings.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='settings.php?error';</script>";
         }
         mysqli_close($conn);
    
    
   }   


}else{

    if(isset($_POST['submit'])){    
         $main_logo = $_FILES["main_logo"]["name"];
         $tempname = $_FILES["main_logo"]["tmp_name"];    
         $folder = "settings/logo".$filename;
         $sql = "INSERT INTO settings (reg_prefix,application_name)
         VALUES (UPPER('$rgname_prefix'),'$ap_name', '$main_logo')";
         if (mysqli_query($conn, $sql)) {
            echo "<script>window.location='add_class_schedule.php?edit=$edit&update';</script>";
         } else {
            echo "<script>window.location='add_class_schedule.php?error';</script>";
         }
         mysqli_close($conn);
    }


 }
?>