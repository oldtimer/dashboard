<?php 
	
	// To add logout logs $session->user_name must be added to Sessions
	// as of now, $session->user_name is not added.

	 require_once("inc/_initialize.php");

     $e = Employees::find_by_user_id($_SESSION['user_id']); 

     $log_activity = new ActivityLogs();
     $log_activity->activity_details = 'LO:'.$e->id."/".date('Y-m-d H:i:s')."/".get_client_ip();
     $log_activity->activity_date = date('Y-m-d H:i:s');
     $log_activity->employee_id = $e->id;
     $log_activity->save();


	$log_user = User::find_by_id($_SESSION['user_id']);
	daily_log_action('Logout', "{$log_user->user_name} logged out.");

	$session->logout();
	redirect_to("index.php");

	

 ?>