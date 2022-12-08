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
		return mysqli_stmt_get_result($stmt);
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
		$roleId = $a->getRole($role);
		$stmt = mysqli_prepare($conn,"INSERT INTO `USER` (`NAME`,`EMAIL`, `PASSWORD`, `TYPE`, `STATUS`) VALUES(?,?,?,?,'PENDING');");
		mysqli_stmt_bind_param($stmt,"sssd", $this->name,$this->email,$this->password,$this->roleId);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorAddUser"]=mysqli_error($conn);
		}
		else{
			mysqli_stmt_close($stmt);
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
		$stmt = mysqli_prepare($conn,"SELECT U.`PASSWORD`, R.`NAME` FROM `USER` U, `ROLE` R WHERE U.EMAIL = ? AND U.`TYPE` = R.`ID`;");
		mysqli_stmt_bind_param($stmt,"s",$this->email);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);
		}
		else{
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result)==0){
				echo "Email does not exist!";
			}				
			else{
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
			
				if(password_verify($this->password, $row[0])){
					$_SESSION['checkLogin']=TRUE;
					header("Location:".$row[1].".php");
				}
				else{
					echo "wrong password!";
				}
			}
		}
	}
	
	function getId(){
		return $this->id;
	}
	
	function getCompany($company){
		// foreach($user as $key=>$value){
			// $this->$key = $value;
		// }
	}
	
	function getAllCompany(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID,NAME,NUMBER,EMAIL,STREET,POSTALCODE,DESCRIPTION,STATUS FROM `USER` U, `COMPANY` C WHERE `TYPE`=2 AND `STATUS` = 'PENDING' AND U.ID=C.ID;");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);
			$companyArray=[];			
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Company();
					$c->setCompany($r);
					array_push($companyArray,$c);
				}
			}
			return $companyArray;
			$_SESSION["add"]=true;
		}
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
		$stmt = mysqli_prepare($conn,"INSERT INTO `COMPANY` (`NUMBER`, `STREET`, `POSTALCODE`, `DESCRIPTION`, `ADMIN`) VALUES(?,?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"dssds", $this->number,$this->street,$this->postalcode,$this->description,parent::$id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
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

class Homeowner extends User{

	//properties
	public $number;
	public $block;
	public $unit;
	public $street;
	public $postalcode;
	public $housetype;
	public $noofpeople;
	
	function setHomeowner($homeowner){
		foreach($homeowner as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addHomeownerDetails($homeowner){
		foreach($homeowner as $key=>$value){
			$this->$key = $value;
		}
		
		$conn = getdb();
		parent::addUser($homeowner);
		$stmt = mysqli_prepare($conn,"INSERT INTO `HOMEOWNER` (`ID`, `NUMBER`, `BLOCK`, `UNIT`, `STREET`, `POSTALCODE`, `HOUSETYPE`, 'NOOFPEOPLE') VALUES(?,?,?,?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"dssssdsd",$this->id, $this->number,$this->block,$this->unit,$this->street,$this->postalcode,$this->housetype,$this->noofpeople);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
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
?>