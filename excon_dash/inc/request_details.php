<?php

//require_once(LIB_PATH.DS.'_initialize.php');
require_once(LIB_PATH.DS.'_database.php');
//added 10/16/2012

class Request_Details extends DBObject {

	protected static $table_name="tblrequest_details";
	protected static $db_fields = array('det_id','req_id', 'item_name', 'item_specs', 'item_unit',
								        'item_qty','item_cost','item_status','item_is_disapproved',
								        'item_is_canceled','po_id','mr_id',
								        'item_on_inv','userid','date_req','req_isupdated','cat_id',
								        'employee_id');
	protected static $gSQL = "SELECT * FROM ";
	
	public $det_id;
	public $req_id;
	public $item_name;
	public $item_specs;
	public $item_unit;
	public $item_qty;
	public $item_cost;
	public $item_status;
	public $item_is_disapproved;
	public $item_is_canceled;
	public $po_id;
	public $mr_id;
	public $item_on_inv;
	public $userid;
	public $date_req;	
	public $req_isupdated;
	public $cat_id;
	public $employee_id;

	/* 08/02/13 -- Niebla*/
	public static function find_by_id($id=0) {
    $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE det_id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }
	
	// 08/08/13 -- Jhomel
	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE det_id=". $database->escape_value($this->det_id);
		//echo $sql;
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	public static function find_by_req_id($id=0) {
  $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE req_id={$id}");
	// return !empty($result_array) ? array_shift($result_array) : false;
	return $result_array;
  }

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".static::$table_name;
	  $sql .= " WHERE det_id=". $database->escape_value($this->det_id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}
}
?>