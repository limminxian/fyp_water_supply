<?php
include_once 'config.php';
session_start();
class Role {
	// Properties
	public $id;
	public $name;
	public $description;
	public $register;

	// Methods
	
	function setRole($role){
		foreach($role as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addRole($role) {
		foreach($role as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `ROLE` (`NAME`,`DESCRIPTION`,`REGISTER`) VALUES(?,?,?);");
		mysqli_stmt_bind_param($stmt,"ssd", $this->name,$this->description,$this->register);
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
						case "homeowner":
							$_SESSION['loginId']=$row[2];
							return array(TRUE,"homeownerVerifyEmail");
							break;
					}
				}
				else if(strcmp($row[0],"SUSPEND")==0){
					return array(FALSE,"Your account has been suspended");
					
				}
				else if(strcmp($row[0],"REJECT")==0){
					return array(FALSE,"Your company has been rejected");
					
				}
				else{
					return array(FALSE,"Notworking");
				}
			}
		}
	}
	
	function setPassword($password){
		$conn = getdb();
		$this->password = password_hash($password,PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `PASSWORD` = ?,WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$this->password, $_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
	function setStatus(){
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
	public $noofstar;
	public $noofrate;
	public $chemicalArray=[];
	
	function setCompany($company){
		foreach($company as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addCompany($company){
		$this->setCompany($company);		
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
	
	function getAllChemical(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM `CHEMICAL` WHERE COMPANY = (SELECT COMPANY FROM STAFF WHERE ID=?);");
		mysqli_stmt_bind_param($stmt,"d", $_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->chemicalArray=[];
				foreach ($rows as $r) {
					$c = new Chemical();
					$c->setChemical($r);
					array_push($this->chemicalArray,$c);
				}
			}
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
	public $noofpeople;
	public $code;
	
	function setHomeowner($homeowner){
		foreach($homeowner as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addHomeowner($homeowner){
		$this->setHomeowner($homeowner);
		$this->code = rand(100000,999999);
		$conn = getdb();
		parent::addUser($homeowner);
		$stmt = mysqli_prepare($conn,"INSERT INTO `HOMEOWNER` (`ID`, `BLOCKNO`, `UNITNO`, `STREET`, `POSTALCODE`, `HOUSETYPE`, `NOOFPEOPLE`, `CODE`) VALUES(?,?,?,?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"dsssdsdd",$this->id, $this->block,$this->unitno,$this->street,$this->postalcode,$this->housetype,$this->people,$this->code);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mail($this->email,"My subject","try");
		$_SESSION["addUser"]=true;
		header("Location:login.php");
	}
	
	function verifyEmail($code){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT `CODE` FROM `HOMEOWNER` WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"d",$_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$row = mysqli_fetch_array($result, MYSQLI_NUM)[0];
		if(strcmp($row,$code)==0){
			$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `STATUS` = 'ACTIVE' WHERE ID = ?;");
			mysqli_stmt_bind_param($stmt,"d",$_SESSION['loginId']);
			mysqli_stmt_execute($stmt);
			return TRUE;
		}
		else{
			return FALSE;
		}
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
		
	}
	
	function resendCode(){
		$this->code = rand(100000,999999);
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `HOMEOWNER` SET `CODE` = ? WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$this->code,$_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		return TRUE;
	}
	
}

class Staff extends User{
	//properties
	public $company;
	public $ticketArray=[];
	
	function setStaff($staff){
		foreach($staff as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addStaff($staff){
		$this->setStaff($staff);
		$conn = getdb();
		if(parent::addUser($staff)){
			$stmt = mysqli_prepare($conn,"INSERT INTO `Staff` (`ID`, `COMPANY`) SELECT ?,ID FROM COMPANY WHERE ADMIN=?;");
			mysqli_stmt_bind_param($stmt,"dd",$this->id, $_SESSION["loginId"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			$_SESSION["addUser"]=true;
			//check duplicate key
			header("Location:companyAdmin.php");
		}
	}
	
	function setPasswordStatus($password){
		$conn = getdb();
		$this->password = password_hash($password,PASSWORD_DEFAULT);
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `PASSWORD` = ?,`STATUS` = 'ACTIVE' WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$this->password, $_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	}
	
	function getAllTicket(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT T.ID, U.NAME, T.DATE, P.NAME AS TYPE, T.STATUS, T.DESCRIPTION FROM `USERS` U, `TICKET` T, `TICKETTYPE` P, `STAFF` S WHERE U.ID = T.HOMEOWNER AND T.TYPE = P.ID AND T.CUSTOMERSERVICE = S.ID AND T.STATUS='PENDING' AND S.ID = ?;");
		mysqli_stmt_bind_param($stmt,"d",$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->ticketArray=[];
				foreach ($rows as $r) {
					$t = new Ticket();
					$t->setTicket($r);
					array_push($this->ticketArray,$t);
				}
			}
		}
	}
}

class Ticket{
	public $id;
	public $name;
	public $date;
	public $type;
	public $status;
	public $description;
	public $chatArray=[];
	
	function setTicket($ticket){
		foreach($ticket as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function getAllChat(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT C.DATE, C.TICKET as ticketid, U.NAME, C.TEXT FROM `CHAT` C, `TICKET` T, `USERS` U WHERE C.TICKET=T.ID AND U.ID=C.SENDER AND T.ID=? ORDER BY C.DATE;");
		mysqli_stmt_bind_param($stmt,"d",$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);
			}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->chatArray=[];
				foreach ($rows as $r) {
					$c = new Chat();
					$c->setChat($r);
					array_push($this->chatArray,$c);
				}
			}
		}
	}
	
	function closeTicket(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `TICKET` SET `STATUS`= 'CLOSE' WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"d",$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function addChat($text){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `CHAT` (`TICKET`,`SENDER`,`TEXT`) VALUES (?,?,?)");
		mysqli_stmt_bind_param($stmt,"dds",$this->id, $_SESSION['loginId'],$text);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function changeType($type){
		$this->type=$type;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `TICKET` SET `TYPE`= (SELECT `ID` FROM `TICKETTYPE` WHERE NAME=?) WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->type,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
}

class Tikcettype{
	public $id;
	public $name;
	public $description;
	public $toTech;
	
	function setTicketType($tickettype){
		foreach($tickettype as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addTicketType($tickettype){
		$this->setTicketType($tickettype);
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "INSERT INTO `TICKETTYPE` (`NAME`,`DESCRIPTION`,`TOTECH`) VALUES (?,?,?);" );
		mysqli_stmt_bind_param($stmt,"ssd",$this->name,$this->description,$this->toTech);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
}

class Chat{
	public $date;
	public $name;
	public $ticketid;
	public $text;
	
	function setChat($chat){
		foreach($chat as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
}

class Chemical{
	public $id;
	public $name;
	public $amount;
	
	function setChemical($chemical){
		foreach($chemical as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addChemical($chemical){
		$this->setChemical($chemical);
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `CHEMICAL` (`NAME`,`AMOUNT`,`COMPANY`) SELECT ?,?,COMPANY FROM `STAFF` WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt,"sdd",$this->name, $this->amount,$_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
}

class DataManager{
	public $pendingCompanyArray=[];
	public $companyArray=[];
	public $staffArray=[];
	public $topCompanyArray=[];
	public $roleArray=[];
	public $homeownerArray=[];
	
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
					array_push($this->pendingCompanyArray,$c);
				}
			}
		}
	}
	
	function getAllCompany(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,U.NAME,NUMBER,EMAIL,STREET,POSTALCODE,C.DESCRIPTION,STATUS FROM `USERS` U, `COMPANY` C, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='COMPANYADMIN'AND U.ID = C.ADMIN;");
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
	
	function getAllHomeowner(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,U.NAME,NUMBER,EMAIL,BLOCKNO,UNITNO,STREET,POSTALCODE,HOUSETYPE,NOOFPEOPLE,STATUS FROM `USERS` U, `HOMEOWNER` H, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='HOMEOWNER' AND U.ID = H.ID;");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$h = new Homeowner();
					$h->setHomeowner($r);
					array_push($this->homeownerArray,$h);
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
	
	function getTopCompany($count){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM COMPANY ORDER BY NOOFSTAR DESC, NOOFRATE DESC LIMIT ?;");
		mysqli_stmt_bind_param($stmt,"d",$count);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Company();
					$c->setCompany($r);
					array_push($this->topCompanyArray,$c);
				}
			}
		}
	}
	
	function getAllRole(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM ROLE;");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Role();
					$c->setRole($r);
					array_push($this->roleArray,$c);
				}
			}
		}
	}
}
?>