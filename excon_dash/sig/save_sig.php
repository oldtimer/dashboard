<?php
	require_once("../inc/_initialize.php");
	require_once("../inc/_sigs.php");
	
if(isset($_POST['imgData']))
{

	$img = $_POST['imgData'];
	$oImg = $img;
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = "_data/img" . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	
	$sig = new Sigs();
	$sig->employee_id = 35;
	$sig->sig = $oImg;
	$sig->save();
	
	echo "SET";
}
else
{
	echo "NOT SET";
}
?>