<?php
session_start();
session_destroy();
unset($_SESSION['user_id']);
header('location:index.php');
exit();
?>