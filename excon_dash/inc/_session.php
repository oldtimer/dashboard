<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions

class Session {
	
	private $logged_in=false;
	public $user_id;
  public $user_type;
	public $keyval;
	public $grp;
	public $qnum;
	public $lname;
	public $fname;
	public $stime;
	public $etime;
	public $ltime;
  public $department_id;
  public $pid;
  public $employee_id; // EMPLOYEE ID
	
  public $rand_interval;
	
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
    if($this->logged_in) {
      // actions to take right away if user is logged in
    } else {
      // actions to take right away if user is not logged in
    }
	}
	
  public function is_logged_in() {
    return $this->logged_in;
  }

	public function login($user,$user_type,$user_unit) {
    // database should find user based on username/password
    if($user && $user_type){
      // $this->user_id = $_SESSION['user_id'] = $user->user_id;
      $_SESSION['user_id'] = $user;
      $_SESSION['user_type'] = $user_type;
      $_SESSION['user_unit'] = $user_unit;
      // $_SESSION['unit_token'] = 'EXCONUNIT'; // THIS SHOULD BE SET FROM THE DATABASE
      //$_SESSION['id'] = $emp_id;
      $this->logged_in = true;
    }
  }
  
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $_SESSION = array();
    session_destroy();
    $this->logged_in = false;
  }

	public function message($msg="") {
	  if(!empty($msg)) {
	    // then this is "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = $msg;
	  } else {
	    // then this is "get message"
			return $this->message;
	  }
	}

	private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
  
	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
	}

  // public function set_user_session($user_id="")
  // {		
  //     $_SESSION['user_id'] = $user_id;
  // }


  public function set_employee_session($pid,$empid,$department_id){
    if($pid && $empid){
      // $this->user_id = $_SESSION['user_id'] = $user->user_id;
      $_SESSION['per_cat_id'] = $pid;
      $_SESSION['employee_id'] = $empid;
      $_SESSION['department_id'] = $department_id;
    }
  }

  public function set_school_year_id($id){
    if($id){
      $_SESSION['school_year_id'] = $id;
    }
  }

  public function set_rating_period($sem){
    if($sem){
      $_SESSION['sem'] = $sem;
    }
  }
	
}

$session = new Session();
$message = $session->message();

?>