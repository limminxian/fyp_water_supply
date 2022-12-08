<?php
include_once 'config.php';
session_start();
class Role {
	// Properties
	public $id;
	public $name;
	public $description;

	// Methods
	function addRole($role) {
		foreach($role as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `ROLE` (`NAME`,`DESCRIPTION`) VALUES(?,?);");
		mysqli_stmt_bind_param($stmt,"ss", $this->name,$this->description);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			mysqli_stmt_close($stmt);
			$_SESSION["add"]=true;
		}
	}
  
	function getRole($role){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT `ID` FROM `ROLE` WHERE NAME=? ;" );
		mysqli_stmt_bind_param($stmt,"s", $role);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		return mysqli_fetch_array($result, MYSQLI_NUM)[0];
	}
}

class User{
	//properties
	public $id;
	public $name;
	public $email;
	public $password;
	public $type;
	public $status;
	public $role;
	
	function addUser($user){
		foreach($user as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		$a = new Role();
		$this->role = $a->getRole($this->role);
		$stmt = mysqli_prepare($conn,"INSERT INTO `USER` (`NAME`,`EMAIL`, `PASSWORD`, `TYPE`, `STATUS`) VALUES(?,?,?,?,'PENDING');");
		mysqli_stmt_bind_param($stmt,"sssd", $this->name,$this->email,$this->password,$this->role);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorAddUser"]=mysqli_error($conn);
		}
		else{
			$result = mysqli_query($conn,"select MAX(ID) FROM `USER`;");
			$row = mysqli_fetch_row($result)[0];
			$this->id=$row;
		}
	}
	
	function validateLogin($user){
		foreach($user as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		// $hashed = password_hash($this->password,PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn,"SELECT U.`PASSWORD`, U.`ID`, R.`NAME` FROM `USER` U, `ROLE` R WHERE U.EMAIL = ? AND U.`TYPE` = R.`ID`;");
		mysqli_stmt_bind_param($stmt,"s",$this->email);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);
		}
		else{
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result)==0){
				return array(FALSE,"Email does not exist!");
			}				
			else{
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
			
				if(password_verify($this->password, $row[0])){
					$_SESSION['loginId']=$row[1];
					return array(TRUE,$row[2]);
				}
				else{
					return array(FALSE,"wrong password!");
				}
			}
		}
	}
	
	function getId(){
		return $this->id;
	}
	
}

class Company extends User{

	//properties
	public $id;
	public $number;
	public $street;
	public $postalcode;
	public $description;
	
	function setCompany($company){
		foreach($company as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addCompany($company){
		foreach($company as $key=>$value){
			$this->$key = $value;
		}
		
		$conn = getdb();
		parent::addUser($company);
		$stmt = mysqli_prepare($conn,"INSERT INTO `COMPANY` (`NUMBER`, `STREET`, `POSTALCODE`, `DESCRIPTION`, `ADMIN`) VALUES(?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"ssdsd", $this->number,$this->street,$this->postalcode,$this->description,parent::getId());
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_query($conn,"select MAX(ID) FROM `COMPANY`;");
			$row = mysqli_fetch_row($result)[0];
			$this->id=$row;
			$_SESSION["add"]=true;
			header("Location:login.php");
		}
	}
	
	function appRejCompany($status){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `USER` SET `STATUS` = ? WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$status, $this->id);
		mysqli_stmt_execute($stmt);
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
	}
}

class Homeowner extends User{

	//properties
	public $number;
	public $block;
	public $unitno;
	public $street;
	public $postalcode;
	public $housetype;
	public $people;
	
	function setHomeowner($homeowner){
		foreach($homeowner as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addHomeowner($homeowner){
		foreach($homeowner as $key=>$value){
			$this->$key = $value;
		}
		
		$conn = getdb();
		parent::addUser($homeowner);
		$stmt = mysqli_prepare($conn,"INSERT INTO `HOMEOWNER` (`ID`, `NUMBER`, `BLOCKNO`, `UNITNO`, `STREET`, `POSTALCODE`, `HOUSETYPE`, `NOOFPEOPLE`) VALUES(?,?,?,?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"dssssdsd",$this->id, $this->number,$this->block,$this->unitno,$this->street,$this->postalcode,$this->housetype,$this->people);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mail($this->email,"My subject","try");
		$_SESSION["addUser"]=true;
		header("Location:login.php");
	}
	
	function appRejCompany($status){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `USER` SET `STATUS` = ? WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$status, $this->id);
		mysqli_stmt_execute($stmt);
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
	}
	
}

class DataManager{
	public $companyArray=[];
	public $staffArray=[];
	
	function getAllCompany(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID,NAME,NUMBER,EMAIL,STREET,POSTALCODE,DESCRIPTION,STATUS FROM `USER` U, `COMPANY` C WHERE `TYPE`=2 AND U.`STATUS` = 'PENDING';");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Company();
					$c->setCompany($r);
					array_push($this->companyArray,$c);
				}
			}
		}
	}
	
	function getAllStaff(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID,NAME,NUMBER,EMAIL,TYPE,STATUS FROM `USER` U, `STAFF` S, `COMPANY` C WHERE `TYPE`=4 AND C.ADMIN=? AND S.COMPANY = C.ID ;");
		mysqli_stmt_bind_param($stmt,"d",$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$s = new Staff();
					$s->setStaff($r);
					array_push($this->staffArray,$s);
				}
			}
		}
	}
	
}

class Staff extends User{
	//properties
	public $company;
	
	function setStaff($staff){
		foreach($staff as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
}
?>