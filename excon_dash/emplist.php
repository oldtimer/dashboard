<?php 
require_once("inc/_initialize.php");
$dept = $_GET["strname"];

$rs = new MySQLDatabase;

if ($dept==""){
	$str = "SELECT distinct(user_id) as user_id, surname, first_name, middle_name 
					FROM employees ORDER by surname";
}else{
	$str = "SELECT distinct(user_id) as user_id, surname, first_name, middle_name 
					FROM employees WHERE department_id = {$dept} ORDER by surname";
}

$dn = $rs->query($str);

	echo "<select size='10' style='width:320px;' onchange='view(this.value)'/>";
  while($e = mysql_fetch_array($dn)){
  
				echo "<option value='{$e[0]}'>";
				echo $e[1] . ", ";
				echo $e[2] . " ";
				echo $e[3] . "<br />";
				echo "</option>";
    }
	echo "</select>";


?>