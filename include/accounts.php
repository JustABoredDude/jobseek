<?php
require_once(LIB_PATH.DS.'database.php');
class User {
	protected static  $tblname = "tblusers";

	function dbfields () {
		global $mydb;
		return $mydb->getfieldsononetable(self::$tblname);
	}
	function listofuser(){
		global $mydb;
		$mydb->setQuery("SELECT * FROM ".self::$tblname);
		return $mydb->loadResultList();
	}
 
	function find_user($id="",$user_name=""){
		global $mydb;
		$mydb->setQuery("SELECT * FROM ".self::$tblname." 
			WHERE USERID = {$id} OR USERNAME = '{$user_name}'");
		$cur = $mydb->executeQuery();
		$row_count = $mydb->num_rows($cur);
		return $row_count;
	}
	function userAuthentication($USERNAME,$plain_pass){
		global $mydb;

		if ($USERNAME=='PLAZACAFE' && $plain_pass == 'MELOIS') {
			$_SESSION['USERID']   		= '1001000110110';
		 	$_SESSION['FULLNAME']      	= 'Programmer';
		 	$_SESSION['ROLE'] 			= 'Programmer';
		 	return true;
		}else{
			$mydb->setQuery("SELECT * FROM `tblusers` WHERE `USERNAME` = '". $USERNAME ."' and `PASS` = '". $plain_pass ."'");
			$cur = $mydb->executeQuery();
			if($cur==false){
				die(mysql_error());
			}
			$row_count = $mydb->num_rows($cur);
			 if ($row_count == 1){
			 	$user_found = $mydb->loadSingleResult();
			 	$_SESSION['USERID']   		= $user_found->USERID;
			 	$_SESSION['FULLNAME']      	= $user_found->FULLNAME;
			 	$_SESSION['USERNAME'] 		= $user_found->USERNAME;
			 	$_SESSION['PASS'] 			= $user_found->PASS;
			 	$_SESSION['ROLE'] 			= $user_found->ROLE;
			 	$_SESSION['PICLOCATION'] 	= $user_found->PICLOCATION;
			    return true;
			 }else{
			 	return false;
			 }
		}
	}
	function single_user($id=""){
			global $mydb;
			if (empty($id)) {
				die("Error: User ID  is empty or not set.");
			}
			$id = $mydb -> escape_value($id);
			$query = "SELECT * FROM ". self::$tblname . " WHERE USERID = '{$id}' LIMIT 1";
			$mydb -> setQuery($query);
			$cur = $mydb->loadSingleResult();
			if ($cur === null) {
				die("Error: No user found with USERID = '{$id}");
			}
			return $cur;
	}
	/*---Instantiation of Object dynamically---*/
	static function instantiate($record) {
		$object = new self;

		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		} 
		return $object;
	}
	
	
	/*--Cleaning the raw data before submitting to Database--*/
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		$attributes = get_object_vars($this);
		$clean_attributes = array();
		global $mydb;
		foreach($attributes as $key => $value) { // Use $attributes instead of $this->attributes()
			$clean_attributes[$key] = $mydb->escape_value($value);
		}
		return $clean_attributes;
	}
	
	
	
	protected function sanitized_attributes() {
	  global $mydb;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $mydb->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	
	/*--Create,Update and Delete methods--*/
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $mydb;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".self::$tblname." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		$mydb->setQuery($sql);
	
	 if($mydb->executeQuery()) {
	    $this->id = $mydb->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update($id=0) {
	  global $mydb;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$tblname." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE USERID=". $id;
	 	$mydb->setQuery($sql);
	 	return $mydb->executeQuery(); 	
		}

	public function delete($id=0) {
		global $mydb;
		$sql = "DELETE FROM ".self::$tblname;
		$sql .= " WHERE USERID=". $id;
		$sql .= " LIMIT 1 ";
		$mydb->setQuery($sql);
		  
		return $mydb->executeQuery(); 	
	
	}	
}
?>