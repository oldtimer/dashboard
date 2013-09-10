<?php
//require_once(LIB_PATH.DS.'_initialize.php');
require_once(LIB_PATH.DS.'_database.php');
//added 10/16/2012

class RequestLogs extends DBObject {

	protected static $table_name="tblrequest_logs";
	protected static $db_fields = array('requestlog_id', 'log_details', 'log_date', 'req_id','employee_id');
	protected static $gSQL = "SELECT * FROM ";
	public $requestlog_id;
	public $log_details;
	public $log_date;
	public $req_id;
	public $employee_id;
	
}
?>