<?php
//require_once(LIB_PATH.DS.'_initialize.php');
require_once(LIB_PATH.DS.'_database.php');
//added 10/16/2012

class Departments extends DatabaseObject {

	protected static $table_name="departments";
	protected static $db_fields = array('id', 'name', 'section_head_id', 'dept_head_id', 'is_section','dept_id');
	protected static $gSQL = "SELECT * FROM ";
	public $id;
	public $name;
	public $section_head_id;
	public $dept_head_id;
	public $is_section;
	public $dept_id;
	
	public static function find_by_head($dept_head_id="")
	{
		$sql = self::$gSQL . self::$table_name . " WHERE dept_head_id = " . $dept_head_id;
		return self::find_by_sql($sql);
	}
	public static function find_dept_by_section($section_id="")
	{
		$sql = self::$gSQL . self::$table_name . " WHERE section_id = " . $section_id . " AND is_section = '1' LIMIT 1";
		return self::find_by_sql($sql);
	}
	//find all
	
	// ----------------------
	// Added 11/13/2012 apamparo
	// ----------------------
	
	public static function find_all_sorted() {
	
		$sql = self::$gSQL . self::$table_name . " ORDER BY name ASC";
		return self::find_by_sql($sql);
	}
	
	public static function get_name($id = 0) {
	  global $database;
	  $sql = "SELECT name FROM ".self::$table_name . " WHERE id = {$id} LIMIT 1";
    //echo $sql;
	$result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	
	public static function find_all() {
	
		$sql = self::$gSQL . self::$table_name;
		return self::find_by_sql($sql);
	}
	
	public static function find_by_sql($sql="") {
    global $database;
	  $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
	
	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;

		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		
		$attributes = $this->sanitized_attributes();
		array_shift($attributes);
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		$sql=str_replace("'NULL'","NULL",$sql);
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

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
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
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