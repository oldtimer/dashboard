<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'_database.php');

class Employees {
	
	protected static $table_name="employees";
	protected static $db_fields = array('id', 'employee_id', 'surname', 'first_name', 'middle_name','birth_date', 'gender','civil_status','unit_name','department_id','position_id','designation','date_hired','plantilla_step','user_id','per_cat_id', 'section_id', 'dept_head_id', 'sec_head_id', 'e_mail');
	
	public $id;
	public $employee_id;
	public $surname;
	public $first_name;
	public $middle_name;
	public $birth_date;
	public $gender;
	public $civil_status;
	public $unit_name;
	public $department_id;
	public $position_id;
	public $designation;
	public $date_hired;
	public $plantilla_step;
	public $user_id;
	public $per_cat_id;
	public $section_id;
	public $sec_head_id;
	public $dept_head_id;
	public $e_mail;

	
	
  

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name); 
	}
	
	//-added 1/18/2013 gadayan-//
	public static function find_sorted_surname($sort_by="surname") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name . " ORDER BY {$sort_by} ASC"); 
	}
	
	//--Added 12/04/2012 gadayan--//
	public static function find_by_dept_all($dept_id=0) {
		return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE department_id = {$dept_id} AND per_cat_id <> 1 ORDER BY surname"); 
	}
	
	//--Added 12/12/2012 gadayan--//
	public static function find_all_head() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE per_cat_id = 2 OR per_cat_id = 3 ORDER BY surname"); 
	}
	
	//--Added 02/21/2013 gadayan--//
	public static function find_all_staff() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE per_cat_id = 4 ORDER BY surname"); 
	}
	
	// ----------------------
	// Added 11/13/2012 apamparo
	// ----------------------
	public static function find_all_sorted($sort_by="first_name") {
		return self::find_by_sql("SELECT * FROM ".self::$table_name . " ORDER BY {$sort_by} ASC");
	}
	// ---------------------------
	// added 12/05/2012 apamparo
	// ---------------------------
	
	public static function get_head_staff($head_id)
	{
		if(self::has_section_heads($head_id))
			return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE dept_head_id = {$head_id} AND per_cat_id = 3");
		else
			return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE dept_head_id = {$head_id}"); 
	}
	
	public static function count_head_staff($head_id) {
		global $database;
		
		if(self::has_section_heads($head_id))
			$sql = "SELECT COUNT(*) FROM ".self::$table_name . " WHERE dept_head_id = {$head_id} AND per_cat_id = 3";
		else
			$sql = "SELECT COUNT(*) FROM ".self::$table_name . " WHERE dept_head_id = {$head_id}";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);

	}
	
	// check if dept head has section/area heads
	public static function has_section_heads($head_id)
	{
		global $database;
		$sql = "SELECT COUNT(*) FROM ".self::$table_name . " WHERE dept_head_id = {$head_id} AND per_cat_id = 3";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		if((array_shift($row) * 1) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public static function get_section_staff($head_id)
	{
		return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE sec_head_id = {$head_id}"); 
	}
	
	public static function count_section_staff($head_id) {
		global $database;
		
		$sql = "SELECT COUNT(*) FROM ".self::$table_name . " WHERE sec_head_id = {$head_id}";
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}
	
	

	// ----------------------
	// Added 11/22/2012 apamparo
	// modified 11/23/2012
	// ----------------------
	public static function find_by_dept_sorted($dept_id = 0, $heads = false) {
		if($dept_id == 0)
		{
			$head_str = $heads == true ? " WHERE per_cat_id <= 3 " : " ";
			//echo "SELECT * FROM ".self::$table_name . $head_str . " ORDER BY first_name ASC";
			return self::find_by_sql("SELECT * FROM ".self::$table_name . $head_str . " ORDER BY first_name ASC");
		}
		else
		{
			$head_str = $heads == true ? " AND per_cat_id <= 3 " : " ";
			//echo "SELECT * FROM ".self::$table_name . " WHERE department_id = {$dept_id} " . $head_str . "ORDER BY first_name ASC";
			return self::find_by_sql("SELECT * FROM ".self::$table_name . " WHERE department_id = {$dept_id} " . $head_str . "ORDER BY first_name ASC");
		}
	}

  
    public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_user_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE user_id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }
	
	// ----------------------
	// Added 11/07/2012 apamparo
	// ----------------------
	public static function get_unique_dept()
	{
		//return self::find_by_sql("SELECT DISTINCT department_id FROM ".self::$table_name);
		global $database;
		$ids = "";
		$c = 0;
		$sql = "SELECT DISTINCT department_id FROM ".self::$table_name . " ORDER BY department_id ASC";
		$result_set = $database->query($sql);
		
		while($row = $database->fetch_array($result_set))
		{
			$ids[$c] = $row[0];
			$c++;
		}
		
		return implode($ids,",");
	}
	
	public static function get_id_by_dept($dept_id=0)
	{
		
		global $database;
		$ids = "";
		$c = 0;
		$sql = "SELECT id FROM ".self::$table_name . " WHERE department_id = {$dept_id} ORDER BY id ASC";
		$result_set = $database->query($sql);
		//echo $sql;
		while($row = $database->fetch_array($result_set))
		{
			$ids[$c] = $row[0];
			$c++;
		}
		//return $ids;
		return implode($ids,",");
	}
  // ----------------------------
  // Added 11-08-2012 (apamparo)
  // ----------------------------
  public static function get_fullname($id = 0) {
	  global $database;
	  $sql = "SELECT CONCAT(first_name, CONCAT(' ', CONCAT(SUBSTRING(middle_name,1,1), CONCAT('. ', surname) ) ) ) AS fname FROM ".self::$table_name . " WHERE id = {$id} LIMIT 1";
    //echo $sql;
	$result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}
	// ----------------------------
	// Added 11-13-2012 (apamparo)
	// ----------------------------
	public static function get_fullname_by_last($id = 0) {
	  global $database;
	  $sql = "SELECT CONCAT( surname, CONCAT(', ', CONCAT(first_name, CONCAT(' ', CONCAT(SUBSTRING(middle_name,1,1),'.') ) ) ) ) AS fname FROM ".self::$table_name . " WHERE id = {$id} LIMIT 1";
    //echo $sql;
	$result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
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
  

	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// More dynamic, short-form approach:
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
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
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

	//
	//RECOVER PASSWORD THRU EMAIL
	//

	public static function recover_pass($email=""){
		global $database;

		// CHECK DATABASE IF USER EMAIL EXIST
		$sql  = "SELECT user_id,e_mail FROM ".self::$table_name;
		$sql .= " WHERE e_mail='" . $email . "' LIMIT 1";
		$result_set = $database->query($sql);

		$row = $database->fetch_array($result_set);
		$email = $database->affected_rows();
		$update_user_password = new User();
		
		
		// echo $sql;

		//IF USER EMAIL FOUND GENERATE PASSWORD ELSE GENERATE AN ERROR.
		if($email  == TRUE){
			$rand = randomPassword(8);
			$user = $row['e_mail'];
			

		//SEND THE GENERATED PASSWORD TO USERS EMAIL WITH GUIDE.

			$to = $user; // Send email to user
			$subject = 'Employee Performance Evaluation Password Recovery Request'; // Give the email a subject

			$message  = "EVAL Password Recovery Request\r\n";
			$message .= "Here is your password\r\n";
			$message .= "------------------------------------------\r\n";
			$message .= "Password: $rand \r\n";
			$message .= "------------------------------------------\r\n";
			$message .= "Note:\r\n";
			$message .= "After you logged in. Please change your temporary password at the Profile Menu. Thank you.";

			
			$headers = 'From:noreply@www.jblfmu.edu.ph' . "\r\n";  //Set fom headers
			mail($to,$subject,$message,$headers); // send our email

			$recover_this = TRUE;
		
		//UPDATE THE USER DATA ON THE USERS TABLE WITH THE GENERATED PASSWORD.
			$update_user_password->add_password($row['user_id'],$rand);
		
		
		}else{
			$recover_this = FALSE;
			
		}
		
		

		return $recover_this;
		
		
		
		
	}

}

?>