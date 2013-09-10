<?php require_once("inc/_initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("index.php"); } ?>


<?php

$user_id = $_POST['user_id'];
$new_pwd = trim($_POST['new_pwd']);
$old_pwd = trim($_POST['old_pwd']);
$confirm_pwd = trim($_POST['confirm_pwd']);


$sql = "SELECT COUNT(*) AS cnt FROM users WHERE user_id={$user_id} AND user_password=password('{$old_pwd}')";


$validate = mysql_query($sql);
$v = mysql_fetch_array($validate);

if ($v['cnt'] <> 1){
	
	exit(json_encode(array(
            'message' => "Password Not Found! Try again."
        )));
}
else
{
	
	$update_pass = "UPDATE users SET user_password = password('{$new_pwd}') WHERE user_id={$user_id}";
	// echo $update_pass;
	$result = mysql_query($update_pass);

	exit(json_encode(array(
        'message' => "Password is updated!"
    )));
}




?>