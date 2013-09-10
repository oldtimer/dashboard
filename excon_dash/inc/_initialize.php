<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'var'.DS.'www'.DS.'excon_dash');

//defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'webroot'.DS.'prrf');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'inc');

//defined('LIB_PATH') ? null : define('LIB_PATH', 'inc');

define('MY_KEY','123');


// load config file first
require_once(LIB_PATH.DS.'_config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'_functions.php');

// load core objects
require_once(LIB_PATH.DS.'_session.php');
require_once(LIB_PATH.DS.'_database.php');
require_once(LIB_PATH.DS.'_database_object.php');


$_SESSION['unit_token'] = 'EXCONUNIT';

$urlp = 'http://foundation.jblfmu.edu.ph';
$urld = 'http://172.16.8.14';


if(isset($_SESSION['user_id']))
{
	if($_SESSION['unit_token'] != $_SESSION['user_unit'])
	{
		 //$session->logout();
		 //redirect_to("http://foundation.jblfmu.edu.ph/index.php"); 
		switch($_SESSION['user_unit'])
		{
			case "AREVALOUNIT":
				redirect_to($urld."/arevalo_eval/dashboard.php");
				break;
			case "BACOLODUNIT":
				redirect_to($urld."/bacolod_eval/dashboard.php");
				break;
			case "MOLOUNIT":
				redirect_to($urld."/molo_eval/dashboard.php");
				break;
			case "FOUNDATIONUNIT":
				redirect_to($urld."/foundation_eval/dashboard.php");
				break;
		}
	}
}


//require_once(LIB_PATH.DS.'pagination.php');

// load database-related classes
// require_once(LIB_PATH.DS.'exams.php');
// require_once(LIB_PATH.DS.'keys.php');
//require_once(LIB_PATH.DS.'competencies.php');

?>