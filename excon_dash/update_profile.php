<?php require_once("inc/_initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to("index.php"); } ?>


<?php
// print_r($_POST);
// die();
// UPDATE USER PROFILE
$id = $_POST['id'];
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$email = $_POST['email'];



 $update_emp = Employees::find_by_id($id);
 $update_emp->first_name = $fname;
 $update_emp->middle_name = $mname;
 $update_emp->surname = $lname;
 $update_emp->e_mail = $email;
 $update_emp->update();

exit(json_encode(array('mensahe' => "Profile is updated!")));

?>