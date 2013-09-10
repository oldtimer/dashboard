<?php
//require_once(LIB_PATH.DS.'_initialize.php');
require_once(LIB_PATH.DS.'_database.php');
//added 10/16/2012

class ActivityLogs extends DBObject {

	protected static $table_name="tblactivity_logs";
	protected static $db_fields = array('id', 'activity_details', 'activity_date', 'employee_id');
	protected static $gSQL = "SELECT * FROM ";
	public $id;
	public $activity_details;
	public $activity_date;
	public $employee_id;
}
?>