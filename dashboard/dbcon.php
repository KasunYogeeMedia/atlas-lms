<?php
require_once 'db.php';
$con = mysqli_connect("localhost","$udbname","$dbpassword","$dbname");

// mathsck connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
