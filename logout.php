<?php
require_once 'dashboard/conn.php';
session_start();
session_unset();
session_destroy();
setcookie("reid","", time()-60, "/");
header('location:$url');
die();
?>