<?php

$con = mysqli_connect("localhost","root","","lms");
$uid = $_GET['uid'];
$sid = $_GET['sid'];
$lid = $_GET['lid'];
$date = date("Y-m-d h:i:s");
$check_select = mysqli_query($con,"SELECT * FROM user_attandance WHERE userid = '$uid' AND lid ='$lid'"); 

$numrows=mysqli_num_rows($check_select);

if($numrows > 0){

    echo "data all ready inserted ";
    
}

else{

    $sql = "INSERT INTO user_attandance(userid, subjectid, lid, date) VALUES('$uid', 
    '$sid', '$lid', '$date')";
    mysqli_query($con, $sql);
   
     echo "data inserted successfully";
     


 }

?>
