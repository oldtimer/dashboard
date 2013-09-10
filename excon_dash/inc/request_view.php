<?php
//require_once(LIB_PATH.DS.'_initialize.php');
require_once(LIB_PATH.DS.'_database.php');
//added 10/16/2012

class Request_view extends DBObject 
{

	protected static $table_name="request_view";
	protected static $db_fields = array('req_id', 'req_number', 'req_dept_id', 'req_requestdate',
								        'req_purpose','req_status','req_notes','req_level','req_unit',
								        'last_update','employees_id','det_id','item_name','item_specs','item_unit',
								        'item_qty','item_cost','cat_id','req_num_items','req_total_cost');
	protected static $gSQL = "SELECT * FROM ";
	
	public $req_id;
	public $req_number;
	public $req_dept_id;
	public $req_requestdate;
	public $req_purpose;
	public $req_status;
	public $req_notes;
	public $req_level;
	public $req_unit;
	public $last_update;
	public $employees_id;	
	public $det_id;
	public $item_name;
	public $item_specs;
	public $item_unit;	
	public $item_qty;
	public $item_cost;
	public $cat_id;
	public $req_num_items;
	public $req_total_cost;


	// public static function displayRequests($employees_id=0)
	// {
	// 	global $database;
	// 	$sql  =  "SELECT 
	// 					req_id,req_number,req_dept_id,req_requestdate,req_purpose,
	// 					req_status,req_notes,req_level,req_unit,last_update,employees_id,
	// 					item_name,item_specs,item_unit,item_qty,item_cost,cat_id 
	// 			  FROM ".self::$table_name;
	// 	$sql .= " WHERE employees_id IN (".$employees_id.")";
	// 	$sql .= " AND req_level = 1";
	// 	$sql .= " AND req_status = 0";
	// 	$sql .= " GROUP BY req_id";

	//     //echo $sql;

	// 	$result_set = $database->query($sql);
	//     $object_array = array();
	    
	//     while ($row = $database->fetch_array($result_set)) 
	//     {
	//       $object_array[] = self::instantiate($row);
	//     }
	    
	//     return $object_array;

	// }
	
	public static function find_by_status_and_level($req_status=0,$req_level=0) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE req_status = {$req_status} AND req_level = {$req_level}");
		// return !empty($result_array) ? array_shift($result_array) : false;
		return $result_array;
 	}

 	public static function find_by_status($req_status=0) {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE req_status = {$req_status}");
		// return !empty($result_array) ? array_shift($result_array) : false;
		return $result_array;
 	}
	
	public static function request_for_canvass() {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (req_status = 4 AND req_level = 2) OR (req_status = 0 AND req_level = 2) ORDER BY req_requestdate DESC");
		// return !empty($result_array) ? array_shift($result_array) : false;
		return $result_array;
 	}
	
	public static function request_for_pr() {
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (req_status = 4 AND req_level = 4) OR (req_status = 8 AND req_level = 4) ORDER BY req_requestdate DESC");
		// return !empty($result_array) ? array_shift($result_array) : false;
		return $result_array;
 	}
	
	public static function find_by_req_id($id=0) {
  $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE req_id={$id}");
	// return !empty($result_array) ? array_shift($result_array) : false;
	return $result_array;
  }

	
	
}
?>