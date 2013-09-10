<?php
// added 09/12/2012

function create_key($amount){
	$keyset  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$randkey = "";
	for ($i=0; $i<$amount; $i++)
		{
			if($i == ($amount / 2) )
				$randkey .= '-';
			$randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
		}
	return $randkey;	
}



function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
    // return $message;
  } else {
    return "";
  }
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'layout'.DS.$template);
}

function include_layout_nav($nav="") {
	include(SITE_ROOT.DS.'layout'.DS.$nav);
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function get_per_cat($per){
$perc = "";
	switch ($per){
	case 1:
		$perc = "Administrative";
		break;
	case 2:
		$perc = "Department Head";
		break;
	case 3:
		$perc = "Section Head";
		break;
	case 4:
		$perc = "Staff";
		break;
	}
	return $perc;
}

function get_cat($cat){
$cate = "";
	switch ($cat){
	case 11:
		$cate = "Planning";
		break;
	case 12:
		$cate = "Organizing";
		break;
	case 13:
		$cate = "Leading/Delegation";
		break;
	case 14:
		$cate = "Controlling";
		break;
	case 15:
		$cate = "Staff Development";
		break;
	case 16:
		$cate = "Communication";
		break;
	case 21:
		$cate = "Continuous learning and development initiatives";
		break;
	case 22:
		$cate = "Initiative and empowerment";
		break;
	case 23:
		$cate = "Resilience and agility";
		break;
	case 24:
		$cate = "Resource utilization";
		break;
	case 25:
		$cate = "Excellence";
		break;
	case 26:
		$cate = "Customer relations and satisfaction";
		break;
	case 27:
		$cate = "Timeliness and dependability";
		break;
	case 28:
		$cate = "Social environmental responsibility";
		break;
	case 29:
		$cate = "Institutional commitment of advocacies and values";
		break;
	case 30:
		$cate = "Interpersonal relations";
		break;
	case 31:
		$cate = "School activities involvement";
		break;
	}
	
	return $cate;

}

/**
     * timeBetween()
     * @link http://awcore.com/php/snippets/24/date-in-hours-days-months-format_en
     * @param mixed $start
     * @param mixed $end
     */
    function timeBetween($start,$end){
    	$time = $end - $start;
    
    	if($time <= 60){
    		return 'one moment ago';
    	}
    	if(60 < $time && $time <= 3600){
    		return round($time/60,0).' minutes ago';
    	}
    	if(3600 < $time && $time <= 86400){
    		return round($time/3600,0).' hours ago';
    	}
    	if(86400 < $time && $time <= 604800){
    		return round($time/86400,0).' days ago';
    	}
    	if(604800 < $time && $time <= 2592000){
    		return round($time/604800,0).' weeks ago';
    	}
    	if(2592000 < $time && $time <= 29030400){
    		return round($time/2592000,0).' months ago';
    	}
    	if($time > 29030400){
    		return date('M d y at h:i A',$start);
    	}
    }


	// function getKRAStatus($accepted="",$approved="",$id=0,$cat_id=0)
	function getKRAStatus($accepted="",$approved="",$id=0,$is_creator)
	{
		
		// CHECK CAT_ID 4 - staff, 3 - head
		$status = "";
		
		if($approved == 1 && $accepted == 1){ // BOTH ACCEPTED
				$status = '<img src="../img/10.png" alt="accepted"/>';
		}


		if($is_creator == 'TRUE')
		{
			if($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
				$status = '<img src="../img/55.png" alt="Not Yet Approved"/>';
				
			}

			if($approved == 0 && $accepted == 1){ // ACCEPTED BUT NOT APPROVED
				$status = '<img src="../img/56.png" alt="Not Yet Accepted"/>';
			}

		}else{
	
			if($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
			 	$status = '<a href="#" onclick="$(this).accept_status('.$id.'); return false;"><img src="../img/55.png" alt="Not Yet Approved"/></a>';
			}
		
			if($approved == 0 && $accepted == 1){ // ACCEPTED BUT NOT APPROVED
				$status = '<a href="#" onclick="$(this).approve_status('.$id.'); return false;"><img src="../img/56.png" alt="Not Yet Accepted"/></a>';
			}

		}


		return $status;
	}


	function getKRASubStatus($accepted="",$approved="",$id=0,$is_creator)
	{
		 //echo $accepted . " - " . $approved . " - " . $id . " - " . $cat_id;
		// CHECK CAT_ID 4 - staff, 3 - section head  2 - dept head
		 $status = "";
		if($approved == 1 && $accepted == 1){ // BOTH ACCEPTED
				$status = '<img src="../img/10.png" alt="accepted"/>';
		}


		if($is_creator == 'TRUE')
		{
			if($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
				$status = '<img src="../img/55.png" alt="Not Yet Approved"/>';
			}

			if($approved == 0 && $accepted == 1){ // ACCEPTED BUT NOT APPROVED
				$status = '<img src="../img/56.png" alt="Not Yet Accepted"/>';
			}
		}else{

			if($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
				$status = '<a href="#" onclick="$(this).accept_substatus('.$id.'); return false;"><img src="../img/55.png" alt="Not Yet Approved"/></a>';
			}

			if($approved == 0 && $accepted == 1){ // NOT APPROVED BUT ACCEPTED
		 		$status = '<a href="#" onclick="$(this).approve_substatus('.$id.'); return false;"><img src="../img/56.png" alt="Not Yet Approved"/></a>';	
		 	}
		}


		// if($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
		// 	$status = '<a href="#" onclick="$(this).accept_substatus('.$id.'); return false;"><img src="../img/55.png" alt="Not Yet Approved"/></a>';
		// }

		

		// if($cat_id =='3' || $cat_id == '2'){
		// 	if($approved == 0 && $accepted == 1){ // NOT APPROVED BUT ACCEPTED
		// 		$status = '<a href="#" onclick="$(this).approve_substatus('.$id.'); return false;"><img src="../img/56.png" alt="Not Yet Approved"/></a>';	
		// 	}
		// }else{
		// 	if($approved == 0 && $accepted == 1): // NOT APPROVED BUT ACCEPTED
		// 		$status = '<img src="../img/56.png" alt="Not Yet Approved"/>';	
		// 	endif;
		// }	
	


		// if($cat_id == '4')
		// {
		// 	if($approved == 1 && $accepted == 1){ // BOTH ACCEPTED
		// 		$status = '<img src="../img/10.png" alt="accepted"/>';
		// 	}
		// 	elseif($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
		// 		$status = '<a href="#" onclick="$(this).accept_substatus('.$id.'); return false;"><img src="../img/55.png" alt="Not Yet Approved"/></a>';
		// 	}
		// 	elseif($approved == 0 && $accepted == 1){ // ACCEPTED BUT NOT APPROVED
		// 		$status = '<img src="../img/56.png" alt="Not Yet Accepted"/>';
		// 	}
		// }elseif($cat_id == '3'){
		// 	if($approved == 1 && $accepted == 1){ // BOTH ACCEPTED
		// 		$status = '<img src="../img/10.png" alt="accepted"/>';
		// 	}
		// 	elseif($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
		// 		$status = '<img src="../img/55.png" alt="Not Yet Accepted"/>';
		// 		// /$status = "-";
		// 	}
		// 	elseif($approved == 0 && $accepted == 1){ // NOT APPROVED BUT ACCEPTED
		// 		$status = '<a href="#" onclick="$(this).approve_substatus('.$id.'); return false;"><img src="../img/56.png" alt="Not Yet Approved"/></a>';	
		// 	}
		// }elseif($cat_id == '2'){
		// 	if($approved == 1 && $accepted == 1){ // BOTH ACCEPTED
		// 		$status = '<img src="../img/10.png" alt="accepted"/>';
		// 	}
		// 	elseif($approved == 1 && $accepted == 0){ // APPROVED BUT NOT ACCEPTED
		// 		$status = '<img src="../img/55.png" alt="Not Yet Accepted"/>';
		// 		// /$status = "-";
		// 	}
		// 	elseif($approved == 0 && $accepted == 1){ // NOT APPROVED BUT ACCEPTED
		// 		$status = '<a href="#" onclick="$(this).approve_substatus('.$id.'); return false;"><img src="../img/56.png" alt="Not Yet Approved"/></a>';	
		// 	}
		// }

		return $status;
	}

	function percentToDecimal($thisnum)
	{
	    // $percent = str_replace('%', '', $percent);
	    return $thisnum / 100;
	}   

	function round_up( $value, $precision ) { 
	    $pow = pow ( 10, $precision ); 
	    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
	}

	function round_to_2dp($number){
		return number_format((float)$number, 2, ".","");
	}

	
	function randomPassword(){
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	 
	 // $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	 // return substr(str_shuffle($chars),0,$length);
	}


	// Function to get the client ip address
	function get_client_ip() {
		$ipaddress = '';
		if(isset($_SERVER['HTTP_CLIENT_IP']))
		    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
		    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
		    $ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
		    $ipaddress = $_SERVER['REMOTE_ADDR'];
		else
		    $ipaddress = 'UNKNOWN';

		return $ipaddress;
	}


	function multiexplode ($delimiters,$string) {
	    
	    $ready = str_replace($delimiters, $delimiters[0], $string);
	    $launch = explode($delimiters[0], $ready);
	    return  $launch;
	}

	function getStatus($la="")
	{
		
		
		$la = trim($la);
		//echo $la;
		$findme = 'LI';
		

      	if(strpos($la,'LI')  !== false)
	    {
	       $status = "LOGIN";
	    }
	    elseif (strpos($la,'LO')  !== false) 
	    {
	    	$status = "LOGOUT";
	    }
	    elseif(strpos($la,'RE')  !== false)
		{
			$status = "REQUEST";
		}
		elseif(strpos($la,'AP')  !== false)
		{
			$status = "APPROVED A REQUEST";
		}
		elseif(strpos($la,'DI')  !== false)
		{
			$status = "DISAPPROVED A REQUEST";
		}
		elseif(strpos($la,'RA')  !== false)
		{
			$status = "RECOMMEND APPROVAL";
		}
		elseif(strpos($la,'PO')  !== false)
		{
			$status = "PURCHASE ORDER";
		}
	    else
	    {
	    	$status = "UNKNOWN";	
	    }


		return $status;
	}

	function getRequestStatus($s="")
	{
		
		switch($s)
		{
			case "S:0":
				$request_status = "NEW REQUEST";
			break;

			case "S:1":
				$request_status = '<span style="color:blue;">APPROVE REQUEST</span>';
			break;

			case "S:2":
				$request_status = '<span style="color:red;">DISAPPROVE REQUEST</span>';
			break;

			case "S:3":
				$request_status = "ON HOLD";
			break;

			case "S:4":
				$request_status = '<span style="color:blue;">RECOMMEND APPROVAL</span>';
			break;

			case "S:5":
				$request_status = "PENDING";
			break;

			case "S:6":
				$request_status = "CANVASSED";
			break;

			case "S:7":
				$request_status = '<span style="color:red;">NO BUDGET</span>';
			break;

			case "S:8":
				$request_status = "FOR VERIFICATION";
			break;

			case "S:9":
				$request_status = '<span style="color:blue;">PURCHASE ORDER</span>';
			break;

			case "S:10":
				$request_status = '<span style="color:red;">CANCELLED</span>';
			break;
		}
		
		return $request_status;
	}

	function displayBossPosition($pos="")
	{
		switch($pos)
		{
			case "O:76":
				$p = "CEO";
			break;

			case "O:74":
				$p = "ADMINISTRATOR";
			break;

			case "O:1":
				$p = "DEPARTMENT HEAD";
			break;
		}

		return $p;
	}



	function daily_log_action($action, $message="") {
		$filename = date('Y-m-d')."_log.txt";
		// $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
		$logfile = SITE_ROOT.DS.'logs'.DS.$filename;
		$new = file_exists($logfile) ? false : true;
		if($handle = fopen($logfile, 'a')) { // append
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
			$content = "{$timestamp} | ".get_client_ip()." | {$action}: {$message}\n";
			fwrite($handle, $content);
			fclose($handle);
			if($new) { chmod($logfile, 0755); }
		} else {
			echo "Could not open log file for writing.";
		}
	}


?>