<?php 
require_once("inc/_initialize.php");
$userid = $_GET["uid"];
$userpwd = $_GET["upwd"];

$resetpwd = New User;
$resetpwd->add_password($userid,$userpwd);

echo "1";
?>