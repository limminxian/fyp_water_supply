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
	public $number;
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
		$this->type = $a->getRole($this->role);
		$this->password = password_hash($this->password,PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn,"INSERT INTO `USERS` (`NUMBER`,`NAME`,`EMAIL`, `PASSWORD`, `TYPE`, `STATUS`) VALUES(?,?,?,?,?,'PENDING');");
		mysqli_stmt_bind_param($stmt,"ssssd",$this->number, $this->name,$this->email,$this->password,$this->type);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorAddUser"]=mysqli_error($conn);
			return False;
		}
		else{
			$result = mysqli_query($conn,"select MAX(ID) FROM `USERS`;");
			$row = mysqli_fetch_row($result)[0];
			$this->id=$row;
			return TRUE;
		}
	}
	
	function validateLogin($user){
		foreach($user as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		// $hashed = password_hash($this->password,PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn,"SELECT STATUS, U.`PASSWORD`, U.`ID`, R.`NAME` FROM `USERS` U, `ROLE` R WHERE U.EMAIL = ? AND U.`TYPE` = R.`ID`;");
		mysqli_stmt_bind_param($stmt,"s",$this->email);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);
		}
		else{
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result)==0){
				return array(FALSE,"Email does not exist!");
			}else{
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
				
				if(strcmp($row[0],"ACTIVE")==0){
					if(password_verify($this->password, $row[1])){
						$_SESSION['loginId']=$row[2];
						return array(TRUE,$row[3]);
					}
					else{
						return array(FALSE,"wrong password!");
					}
				}
				
				else if(strcmp($row[0],"PENDING")==0){
					switch($row[3]){
						case "companyadmin":
							return array(FALSE,"Your company is being verified. An email will be sent to you when the verification is done.");
							break;
						case "customerservice":
						case "technician":
							$_SESSION['role']=$row[3];
							$_SESSION['loginId']=$row[2];
							return array(TRUE,"staffFirstLogin");
							break;
					}
					
				}
				
				else if(strcmp($row[0],"SUSPEND")==0){
					return array(FALSE,"Your sccount has been suspended");
					
				}
				else if(strcmp($row[0],"REJECT")==0){
					return array(FALSE,"Your company has been rejected");
					
				}
				
				else{
					var_dump($row);
				}
			}
		}
	}
	
	function setPassword($password){
		$conn = getdb();
		$this->password = password_hash($password,PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `PASSWORD` = ?,`STATUS` = 'ACTIVE' WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$this->password, $_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
	function getId(){
		return $this->id;
	}
	
}

class Company extends User{

	//properties
	public $id;
	public $compName;
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
		$stmt = mysqli_prepare($conn,"INSERT INTO `COMPANY` (`NAME`,`STREET`, `POSTALCODE`, `DESCRIPTION`, `ADMIN`) VALUES(?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"ssdsd",$this->compName, $this->street,$this->postalcode,$this->description,parent::getId());
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
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `STATUS` = ? WHERE ID = ?;");
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
		$stmt = mysqli_prepare($conn,"INSERT INTO `HOMEOWNER` (`ID`, `BLOCKNO`, `UNITNO`, `STREET`, `POSTALCODE`, `HOUSETYPE`, `NOOFPEOPLE`) VALUES(?,?,?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"dsssdsd",$this->id, $this->block,$this->unitno,$this->street,$this->postalcode,$this->housetype,$this->people);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		mail($this->email,"My subject","try");
		$_SESSION["addUser"]=true;
		header("Location:login.php");
	}
	
	function appRejCompany($status){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `STATUS` = ? WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$status, $this->id);
		mysqli_stmt_execute($stmt);
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
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
	
	function addStaff($staff){
		foreach($staff as $key=>$value){
			$this->$key = $value;
		}
		
		$conn = getdb();
		if(parent::addUser($staff)){
			$stmt = mysqli_prepare($conn,"INSERT INTO `Staff` (`ID`, `COMPANY`) SELECT ?,ID FROM COMPANY WHERE ADMIN=?;");
			mysqli_stmt_bind_param($stmt,"dd",$this->id, $_SESSION["loginId"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			$_SESSION["addUser"]=true;
			header("Location:companyAdmin.php");
		}
	}
}

class DataManager{
	public $companyArray=[];
	public $staffArray=[];
	
	function getAllPendingCompany(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,U.NAME,NUMBER,EMAIL,STREET,POSTALCODE,C.DESCRIPTION,STATUS FROM `USERS` U, `COMPANY` C, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='COMPANYADMIN' AND U.`STATUS` = 'PENDING' AND U.ID = C.ADMIN;");
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
		$stmt = mysqli_prepare($conn,"SELECT U.ID,U.NAME,EMAIL,R.NAME AS 'ROLE',STATUS FROM `USERS` U, `STAFF` S, `COMPANY` C, `ROLE` R WHERE R.`NAME` in ('customerservice','technician') AND U.ID=S.ID AND C.ADMIN=? AND S.COMPANY = C.ID AND R.ID = U.TYPE ORDER BY U.ID;");
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
?>