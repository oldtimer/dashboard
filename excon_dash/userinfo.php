<?php 
require_once("inc/_initialize.php");
$userid = $_GET["uid"];

$rs = new MySQLDatabase;

$str = "SELECT user_name, surname, first_name, middle_name
				FROM users u JOIN employees e ON u.user_id = e.user_id
				WHERE u.user_id = {$userid} LIMIT 1";

$dn = $rs->query($str);
$rt = mysql_fetch_array($dn);

echo "Name: " . $rt[1] . ", " . $rt[2] . " " . $rt[3] . "<br />";
echo "Username: " . $rt[0];

?>