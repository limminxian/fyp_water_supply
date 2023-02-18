<?php
include_once 'config.php';
//ini_set('display_errors', '0');
//mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);
//error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require  'phpmailer/src/Exception.php';
require  'phpmailer/src/PHPMailer.php';
require  'phpmailer/src/SMTP.php';
session_start();

//$emailname = 'watersupply02@gmail.com';
//$passwordname = 'ughqjjdtgswonvuj';
// $emailname = 'watersupply03@gmail.com';
// $passwordname = 'uxgaejqdrruvnspk';
// $emailname = 'watersupply04@gmail.com';
// $passwordname = 'tqyicfdtjxprgjjw';
// $emailname = 'watersupply131@gmail.com';
// $passwordname = 'lseyfssimrjhsqda';

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
	
	function updateRole($role){
		foreach($role as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `ROLE` SET `NAME` = ? ,`DESCRIPTION` = ?,`REGISTER` = ? WHERE ID = ? ;");
		mysqli_stmt_bind_param($stmt,"ssdd", $this->name,$this->description,$this->register,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			mysqli_stmt_close($stmt);
			$_SESSION["update"]=true;
		}
	}
}

class Service {
	// Properties
	public $id;
	public $name;
	public $description;
	public $toTech;
	public $status;
	public $ratesArray=[];
	public $createdby;

	// Methods
	
	function setService($service){
		foreach($service as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addService($service) {
		foreach($service as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `SERVICETYPE` (`NAME`,`DESCRIPTION`,`TOTECH`,`CREATEDBY`,STATUS) VALUES(?,?,?,?,'ACTIVE');");
		mysqli_stmt_bind_param($stmt,"ssdd", $this->name,$this->description,$this->toTech,$_SESSION["loginId"]);
		try{
			mysqli_stmt_execute($stmt);
		}catch(mysqli_sql_exception $e){
			return mysqli_error($conn);
		}
		$_SESSION["success"]="Service created successfully";
	}
	
	function getAllRate($service){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT * FROM `SERVICERATE` WHERE SERVICE=? and COMPANY=?;" );
		mysqli_stmt_bind_param($stmt,"dd", $service->id,$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		//return mysqli_fetch_array($result, MYSQLI_NUM)[0];
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->ratesArray=[];
				foreach ($rows as $r) {
					$c = new Rate();
					$c->setRate($r);
					array_push($this->ratesArray,$c);
				}
			}
	}
	
	function updateService($status){
		$this->status = $status;
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `SERVICETYPE` SET `STATUS` = ? WHERE ID = ? ;");
		mysqli_stmt_bind_param($stmt,"sd", $this->status,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			mysqli_stmt_close($stmt);
			$_SESSION["update"]=true;
		}
	}
}

class Rate {
	// Properties
	public $effectdate;
	public $service;
	public $rate;
	public $company;

	// Methods
	
	function setRate($rate){
		foreach($rate as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addRate($r) {
		$conn = getdb();
		echo $r["effectdate"];
		$stmt = mysqli_prepare($conn,"INSERT INTO `SERVICERATE` (`EFFECTDATE`,`SERVICE`,`RATE`,`COMPANY`) VALUES(?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"sddd", $r["effectdate"],$r["service"],$r["rate"],$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			mysqli_stmt_close($stmt);
			$_SESSION["add"]=true;
		}
	}
	
	function getRate($service){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT * FROM `SERVICERATE` WHERE SERVICE=? and COMPANY=?;" );
		mysqli_stmt_bind_param($stmt,"dd", $service->id,$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		//return mysqli_fetch_array($result, MYSQLI_NUM)[0];
			$rates=[];
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Rate();
					$c->setRate($r);
					array_push($this->rateArray,$c);
				}
			}
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
		try{
			mysqli_stmt_execute($stmt);
		}catch(mysqli_sql_exception $e){
			return array(False,mysqli_error($conn));
		}
		$result = mysqli_query($conn,"select MAX(ID) FROM `USERS`;");
		$row = mysqli_fetch_row($result)[0];
		$this->id=$row;
		return array(TRUE,"Account created successfully");
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
				
				if(password_verify($this->password, $row[1])){
					if(strcmp($row[0],"ACTIVE")==0){
						$_SESSION['loginId']=$row[2];
						return array(TRUE,$row[3]);
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
						return array(FALSE,$row[0]);
					}
					
				}
				else{
					return array(FALSE,"wrong password!");
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
	
	
	function getEmail($id){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT `EMAIL` FROM `USERS` WHERE ID=? ;" );
		mysqli_stmt_bind_param($stmt,"s", $id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		return mysqli_fetch_array($result, MYSQLI_NUM)[0];
	}
	
}

class Company extends User{

	//properties
	//public $id;
	public $id;
	public $compName;
	public $number;
	public $street;
	public $postalcode;
	public $description;
	public $noofstar;
	public $noofrate;
	public $acrapath;
	public $photopath;
	public $chemicalArray=[];
	public $equipmentArray=[];
	public $staffArray=[];
	public $homeownerArray=[];
	public $serviceArray=[];
	public $subscribers=[];
	public $waterUse=[];
	
	function setCompany($company){
		foreach($company as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addCompany($company){
		$this->setCompany($company);		
		$conn = getdb();
		$r = parent::addUser($company);
		if($r[0]){
			$admin=parent::getId();
			$this->saveAcraFile();
			$stmt = mysqli_prepare($conn,"INSERT INTO `COMPANY` (`NAME`,`STREET`, `POSTALCODE`, `DESCRIPTION`, `ACRAPATH`,`PHOTOPATH`, `ADMIN`) VALUES(?,?,?,?,?,'imgnotfound.jpg',?);");
			mysqli_stmt_bind_param($stmt,"ssdssd",$this->compName, $this->street,$this->postalcode,$this->description,$this->acrapath,$admin);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			
			$result = mysqli_query($conn,"select MAX(ID) FROM `COMPANY`;");
			$row = mysqli_fetch_row($result)[0];
			$this->id=$row;
			$_SESSION["success"]="Company created successfully";
		}
		else{
			return $r;
		}
	}
	
	function appRejCompany($status){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `STATUS` = ? WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$status, $this->id);
		mysqli_stmt_execute($stmt);
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
		$mail = new PHPMailer(true);
		$email = $emailname;
		$password = $passwordname;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'watersupply03@gmail.com'; //gmail name
		$mail->Password = 'uxgaejqdrruvnspk';//gmail app password
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->setFrom('watersupply03@gmail.com');
		$mail->addAddress($this->email);
		
		$mail->isHTML(true);
		
		$mail->Subject = "Company acceptance result";
		$mail->Body = "Your account is ". $status .". From fypwatersupply.";
		
		$mail->send();
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
	
	function getAllEquipment(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT *,COUNT(S.SERIAL) AS STOCKAMOUNT FROM `EQUIPTYPE` E,EQUIPSTOCK S LEFT JOIN EQUIPMENT M ON M.EQUIPMENT = S.SERIAL WHERE M.EQUIPMENT IS NULL AND E.COMPANY = (SELECT COMPANY FROM STAFF WHERE ID=?) AND E.ID=S.TYPE GROUP BY S.TYPE;");
		mysqli_stmt_bind_param($stmt,"d", $_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->equipmentArray=[];
				foreach ($rows as $r) {
					$c = new Equipment();
					$c->setEquipment($r);
					array_push($this->equipmentArray,$c);
				}
			}
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
	}
	
	function changeStatus($status){
		$this->status=$status;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `USERS` SET `STATUS`= ? WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->status,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function deleteCompany(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "DELETE FROM COMPANY WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"d",$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function getAllStaff(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID,U.NAME,EMAIL,R.NAME AS 'ROLE',STATUS FROM `USERS` U, `STAFF` S, `COMPANY` C, `ROLE` R WHERE R.`NAME` in ('customerservice','technician') AND U.ID=S.ID AND C.ADMIN=? AND S.COMPANY = C.ID AND R.ID = U.TYPE ORDER BY U.ID;");
		mysqli_stmt_bind_param($stmt,"d",$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getAllHomeowner($companyId){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,U.NAME,U.NUMBER,U.EMAIL,BLOCKNO,UNITNO,H.STREET,H.POSTALCODE,HOUSETYPE,NOOFPEOPLE,U.STATUS,CARD FROM `USERS` U, `HOMEOWNER` H, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='HOMEOWNER' AND U.ID = H.ID AND H.SUBSCRIBE=?;");
		mysqli_stmt_bind_param($stmt,"d",$companyId);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->homeownerArray=[];
				foreach ($rows as $r) {
					$h = new Homeowner();
					$h->setHomeowner($r);
					array_push($this->homeownerArray,$h);
				}
			}
		}
	}
	
	function getAllService($admin){
		$service=[];
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT S.*, R.* FROM SERVICETYPE S LEFT JOIN (SELECT A.SERVICE,RATE,MAXDATE FROM SERVICERATE A INNER JOIN (SELECT SERVICE,MAX(EFFECTDATE) AS MAXDATE FROM SERVICERATE GROUP BY SERVICE ) B ON A.SERVICE = B.SERVICE AND A.EFFECTDATE = B.MAXDATE)R ON R.SERVICE=S.ID WHERE CREATEDBY IN ((SELECT ID FROM USERS WHERE TYPE=(SELECT ID FROM ROLE WHERE NAME='superadmin')),?);");
		mysqli_stmt_bind_param($stmt,"d",$admin);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Service();
					$c->setService($r);
					array_push($service,$c);
				}
			}
			return $service;
		}
	}
	
	function saveAcraFile(){
		// Where the file is going to be stored
		$target_dir = "acra/";
		$filename = parent::getId();
		$path = pathinfo($this->acrapath['name']);
		$ext = $path['extension'];
		$temp_name = $this->acrapath['tmp_name'];
		$this->acrapath = $filename.".".$ext;
		$path_filename_ext = $target_dir.$filename.".".$ext;
		
		// Check if file already exists
		if (file_exists($path_filename_ext)) {}else{
			move_uploaded_file($temp_name,$path_filename_ext);
			
		}
	}
	
	function savePhotoFile($photopath,$admin){
		$this->photopath=$photopath;
		// Where the file is going to be stored
		$target_dir = "companylogos/";
		$filename = $admin;
		$path = pathinfo($this->photopath['name']);
		$ext = $path['extension'];
		$temp_name = $this->photopath['tmp_name'];
		$this->photopath = $filename.".".$ext;
		$path_filename_ext = $target_dir.$filename.".".$ext;
		
		move_uploaded_file($temp_name,$path_filename_ext);
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE COMPANY SET PHOTOPATH = ? WHERE `ADMIN` =  ?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->photopath,$admin);
		mysqli_stmt_execute($stmt);
	}
	
	function downloadAcraFile(){
		$file = "acra/".$this->acrapath;
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
	}
	
	function displayProfileImage($admin){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT PHOTOPATH FROM COMPANY WHERE `ADMIN`=?;" );
		mysqli_stmt_bind_param($stmt,"d",$admin);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
		else{
			$result = mysqli_stmt_get_result($stmt);
			return( mysqli_fetch_all($result, MYSQLI_ASSOC)[0]["PHOTOPATH"]);
		}
	}
	
	function getCumulativeSubscribers($company){
		$subscribers=[];
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT S.YEARMONTH,S.SUBSCRIBER,U.SUBSCRIBER AS UNSUBSCRIBER FROM (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'subscribe' AND COMPANY=? GROUP BY YEARMONTH) S LEFT JOIN (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'unsubscribe' AND COMPANY=? GROUP BY YEARMONTH) U ON S.YEARMONTH = U.YEARMONTH UNION SELECT U.YEARMONTH,S.SUBSCRIBER,U.SUBSCRIBER AS UNSUBSCRIBER FROM (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'subscribe' AND COMPANY=? GROUP BY YEARMONTH) S RIGHT JOIN (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'unsubscribe' AND COMPANY=? GROUP BY YEARMONTH) U ON S.YEARMONTH = U.YEARMONTH ;");
		/* $stmt = mysqli_prepare($conn,"SELECT S.YEARMONTH,S.SUBSCRIBER,U.SUBSCRIBER AS UNSUBSCRIBER FROM (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'subscribed' AND COMPANY=? GROUP BY YEARMONTH) S LEFT JOIN (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'unsubscribed' AND COMPANY=? GROUP BY YEARMONTH) U ON S.YEARMONTH = U.YEARMONTH UNION SELECT U.YEARMONTH,S.SUBSCRIBER,U.SUBSCRIBER AS UNSUBSCRIBER FROM (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'subscribed' AND COMPANY=? GROUP BY YEARMONTH) S RIGHT JOIN (SELECT EXTRACT(YEAR_MONTH FROM DATE) AS YEARMONTH, COUNT(HOMEOWNER) AS SUBSCRIBER FROM SUBSCRIBE WHERE CATEGORY = 'unsubscribed' AND COMPANY=? GROUP BY YEARMONTH) U ON S.YEARMONTH = U.YEARMONTH ;;"); */
		
		mysqli_stmt_bind_param($stmt,"dddd",$company,$company,$company,$company);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					array_push($subscribers,$r);
				}
			}
			return $subscribers;
		}
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
	public $area;
	public $card;
	
	function setHomeowner($homeowner){
		foreach($homeowner as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addHomeowner($homeowner){
		$this->setHomeowner($homeowner);
		$a = array("NORTH"=>array("69","70","71","72","73","75","76"),"NORTHEAST"=>array("53","54","55","56","57","79","80","82"),"CETRAL"=>array("01","02","03","04","05","06","07","08","09","10","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","58","59","77","78"),"EAST"=>array("42","43","44","45","46","47","48","49","50","51","52","81"),"WEST"=>array("11","12","13","60","61","62","63","64","65","66","67","68"));
		foreach($a as $key=>$value){
			if (in_array(substr($this->postalcode,0,2),$value)){
				$this->area=$key;
			}
			//echo substr($this->postalcode,0,2);
		}
		$this->code = rand(100000,999999);
		$this->sendEmail($this->email);
		parent::addUser($homeowner);
		$conn = getdb();
		//parent::addUser($homeowner);
		$stmt = mysqli_prepare($conn,"INSERT INTO `HOMEOWNER` (`ID`, `BLOCKNO`, `UNITNO`, `STREET`, `POSTALCODE`, `HOUSETYPE`, `NOOFPEOPLE`, `AREA`) VALUES(?,?,?,?,?,?,?,?);");
		mysqli_stmt_bind_param($stmt,"dsssdsds",$this->id, $this->block,$this->unitno,$this->street,$this->postalcode,$this->housetype,$this->people,$this->area);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		// mail($this->email,"My subject","try");
		$_SESSION["addUser"]=true;
		header("Location:login.php");
	}
	
	function sendEmail($email){
		$mail = new PHPMailer(true);
		
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'watersupply03@gmail.com'; //gmail name
		$mail->Password = 'uxgaejqdrruvnspk';//gmail app password
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		$mail->setFrom('watersupply03@gmail.com');
		
		$mail->addAddress($email);
		
		$mail->isHTML(true);
		
		$mail->Subject = "Email verification code";
		$mail->Body = "This is your 6 digit code from fypwatersupply: ".$this->code.". Please use it to verify your email.";
		
		$mail->send();
	}
	
	function verifyEmail($code){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT `CODE` FROM `USERS` WHERE ID = ?;");
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
	
	function resendCode($email){
		$this->code = rand(100000,999999);
		$conn = getdb();
		$this->sendEmail($email);
		$stmt = mysqli_prepare($conn,"UPDATE `USERS` SET `CODE` = ? WHERE ID = ?;");
		mysqli_stmt_bind_param($stmt,"sd",$this->code,$_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		return TRUE;
	}
	
/* 	function changeStatus($status){
		$this->status=$status;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `USERS` SET `STATUS`= ? WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->status,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	} */
	
	function deleteHomeowner(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "DELETE FROM HOMEOWNER WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"d",$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function changeStatus($status){
		$this->status=$status;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `USERS` SET `STATUS`= ? WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->status,parent::getId());
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
}

class Staff extends User{
	//properties
	public $company;
	public $workload;
	public $ticketArray=[];
	public $ticketTypeArray=[];
	
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
			$stmt = mysqli_prepare($conn,"INSERT INTO `Staff` (`ID`, `WORKLOAD`, `COMPANY`) SELECT ?,0,ID FROM COMPANY WHERE ADMIN=?;");
			mysqli_stmt_bind_param($stmt,"dd",$this->id, $_SESSION["loginId"]);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			$_SESSION["addUser"]=true;
			//check duplicate key
			header("Location:companyadmin.php");
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
	
	function changeStatus($status){
		$this->status=$status;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `USERS` SET `STATUS`= ? WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->status,$this->id);
		mysqli_stmt_execute($stmt);
	}
	
	function getAllTicket(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT T.ID, U.NAME, T.CREATEDATE, ST.TOTECH, ST.NAME AS TYPE, T.STATUS, T.DESCRIPTION FROM `USERS` U, `TICKET` T, `SERVICETYPE` ST, `STAFF` S WHERE U.ID = T.HOMEOWNER AND T.TYPE = ST.ID AND T.CUSTOMERSERVICE = S.ID AND T.STATUS IN ('pending','open') AND S.ID = ?;");
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
	
	function getAllTicketType(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM TICKETTYPE WHERE COMPANY = (SELECT COMPANY FROM STAFF WHERE ID=?);");
		mysqli_stmt_bind_param($stmt,"d",$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($c);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->ticketTypeArray=[];
				foreach ($rows as $r) {
					$t = new Tickettype();
					$t->setTicketType($r);
					array_push($this->ticketTypeArray,$t);
				}
			}
		}
	}
	
	function getCompany($staffId){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT COMPANY FROM `STAFF` WHERE ID=?;" );
		mysqli_stmt_bind_param($stmt,"d", $staffId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		return mysqli_fetch_all($result, MYSQLI_ASSOC)[0]["COMPANY"];
	}
	
	function approvedToTech($ticket){
		$id = parent::getId();
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `STAFF` SET `WORKLOAD`= WORKLOAD + 1 WHERE `ID` =?;" );
		$stmt2 = mysqli_prepare($conn, "INSERT INTO `TASK` (TECHNICIAN,TICKET) VALUES (?,?);" );
		mysqli_stmt_bind_param($stmt,"d",$id);
		mysqli_stmt_bind_param($stmt2,"dd",$id,$ticket);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_execute($stmt2);
	}
}

class CompanyAdmin{
	
	function getCompany($id){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT ID FROM `COMPANY` WHERE ADMIN=?;" );
		mysqli_stmt_bind_param($stmt,"d", $id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$t = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
		return $t["ID"];
	}
}

class Task{
	function getTechnician($ticket){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT U.`NAME` FROM USERS U,`TASK` T WHERE T.TICKET=? AND U.ID=T.TECHNICIAN ;" );
		mysqli_stmt_bind_param($stmt,"d", $ticket);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		return mysqli_fetch_array($result, MYSQLI_NUM)[0];
	}
}

class Ticket{
	public $id;
	public $name;
	public $createdate;
	public $type;
	public $totech;
	public $status;
	public $description;
	public $chatArray=[];
	public $techArray=[];
	
	function setTicket($ticket){
		foreach($ticket as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function getAllChat(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT C.CREATEDATE, C.TICKET as ticketid, U.NAME, C.TEXT FROM `CHAT` C, `TICKET` T, `USERS` U WHERE C.TICKET=T.ID AND U.ID=C.SENDER AND T.ID=? ORDER BY C.CREATEDATE;");
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
	
	function updateStatus($status){
		$this->status=$status;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `TICKET` SET `STATUS`= ? WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->status,$this->id);
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
		$this->type=$type->name;
		$this->totech=$type->totech;
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "UPDATE `TICKET` SET `TYPE`= (SELECT `ID` FROM `SERVICETYPE` WHERE NAME=?) WHERE `ID` =?;" );
		mysqli_stmt_bind_param($stmt,"sd",$this->type,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function getAllTechnician(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT U.ID,NAME,WORKLOAD FROM USERS U , STAFF S WHERE U.ID=S.ID AND `COMPANY` =  (SELECT COMPANY FROM STAFF WHERE ID = ?) AND TYPE = (SELECT ID FROM ROLE WHERE NAME = 'technician') ORDER BY WORKLOAD;" );
		mysqli_stmt_bind_param($stmt,"d",$_SESSION["loginId"]);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->techArray=[];
				foreach ($rows as $r) {
					$h = new Staff();
					$h->setStaff($r);
					array_push($this->techArray,$h);
				}
			}
		}
	}
	
	function getAllType($company){
		$conn = getdb();
		$stmt = mysqli_prepare($conn, "SELECT S.* FROM SERVICETYPE S WHERE CREATEDBY IN ((SELECT ID FROM USERS WHERE TYPE=(SELECT ID FROM ROLE WHERE NAME='superadmin')),(SELECT ADMIN FROM COMPANY WHERE ID=?));" );
		mysqli_stmt_bind_param($stmt,"d",$company);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$service=[];
				foreach ($rows as $r) {
					$h = new Service();
					$h->setService($r);
					array_push($service,$h);
				}
			}
			return $service;
		}
	}
}

class Chat{
	public $createdate;
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
	public $measurement;
	public $per1lwater;
	public $chemicalUsedArray=[];
	
	function setChemical($chemical){
		foreach($chemical as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addChemical($chemical,$admin){
		$this->setChemical($chemical);
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `CHEMICAL` (`NAME`,`AMOUNT`,`COMPANY`, `MEASUREMENT`,`PER1LWATER`) SELECT ?,?, COMPANY,?,? FROM `STAFF` WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt,"sdsdd",$this->name, $this->amount,$this->measurement,$this->per1lwater,$admin);
		try{
			mysqli_stmt_execute($stmt);
		}catch(mysqli_sql_exception $e){
			return array(False,mysqli_error($conn));
		}
		return array(TRUE,"Chemical added successfully");
	}
	
	function addChemicalStock($a){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"UPDATE CHEMICAL SET `AMOUNT` = AMOUNT + ? WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt,"dd",$a,$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function addChemicalUsed($a){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `CHEMICALUSED` (`CHEMICAL`,`AMOUNT`) SELECT ?,?");
		$stmt2 = mysqli_prepare($conn,"UPDATE CHEMICAL SET `AMOUNT` = AMOUNT - ? WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt,"dd",$this->id, $a);
		mysqli_stmt_bind_param($stmt2,"dd",$a,$this->id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_execute($stmt2);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function getChemicalUsed(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT USEDATE, AMOUNT FROM CHEMICALUSED WHERE CHEMICAL=?;");
		mysqli_stmt_bind_param($stmt,"d",$this->id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->chemicalUsedArray=[];
				foreach ($rows as $r) {
					array_push($this->chemicalUsedArray,$r);
				}
			}
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);
		}
	}
	
	function getPer1L(){
		$chemicalused=[];
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT PER1LWATER FROM CHEMICAL WHERE ID=?;");
		mysqli_stmt_bind_param($stmt,"d",$this->id);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
			
		}
	}
}

class Equipment{
	public $id;
	public $name;
	public $description;
	public $stockamount;
	public $company;
	public $servicedate;
	public $equipmentArray=[];
	
	function setEquipment($equipment){
		foreach($equipment as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addEquipment($equipment){
		$this->setEquipment($equipment);
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `EQUIPTYPE` (`NAME`,`DESCRIPTION`,`COMPANY`) SELECT ?,?,COMPANY FROM `STAFF` WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt,"ssd",$this->name, $this->description,$_SESSION['loginId']);
		try{
			mysqli_stmt_execute($stmt);
		}catch(mysqli_sql_exception $e){
			return array(False,mysqli_error($conn));
		}
		return array(TRUE,"Equipment added successfully");
	}
	
	function getAllEquipment($type){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,'SELECT * FROM `EQUIPSTOCK` S LEFT JOIN EQUIPMENT M ON M.EQUIPMENT = S.SERIAL WHERE M.EQUIPMENT IS NULL AND S.TYPE = ?;');
		mysqli_stmt_bind_param($stmt,"d", $type);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->equipmentArray=[];
				foreach ($rows as $r) {
					$c = new EquipmentStock();
					$c->setEquipment($r);
					array_push($this->equipmentArray,$c);
				}
			}
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
	}
	
	function getAllEquipmentHomeowner($type){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT E.*, C.SERVICEDATE AS INSTALLATIONDATE, U.SERVICEDATE AS UNINSTALLATIONDATE FROM `EQUIPSTOCK` T, TASK K, TICKET C, `EQUIPMENT` E LEFT JOIN (SELECT E2.EQUIPMENT, C2.SERVICEDATE FROM `EQUIPSTOCK` T2, TASK K2, TICKET C2, `EQUIPMENT` E2 WHERE E2.EQUIPMENT = T2.SERIAL AND E2.UNINSTALLTASK=K2.ID AND C2.ID=K2.TICKET )U ON E.EQUIPMENT = U.EQUIPMENT WHERE E.EQUIPMENT = T.SERIAL AND T.TYPE=? AND E.INSTALLTASK=K.ID AND C.ID=K.TICKET;");
		mysqli_stmt_bind_param($stmt,"d", $type);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				$this->equipmentArray=[];
				foreach ($rows as $r) {
					$c = new Equipment();
					$c->setEquipment($r);
					array_push($this->equipmentArray,$c);
				}
			}
		echo mysqli_error($conn);
		mysqli_stmt_close($stmt);
	}
}

class EquipmentStock{
	public $type;
	public $id;
	public $serial;
	public $purchasedate;
	
	function setEquipment($equipment){
		foreach($equipment as $key=>$value){
			$lowerKey = strtolower($key);
			$this->$lowerKey = $value;
		}
	}
	
	function addEquipmentStock($equipment){
		$this->setEquipment($equipment);
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"INSERT INTO `EQUIPSTOCK` (`TYPE`,`SERIAL`,`PURCHASEDATE`,`COMPANY`) SELECT ?,?,CURRENT_DATE,COMPANY FROM `STAFF` WHERE `ID`=?");
		mysqli_stmt_bind_param($stmt,"dsd",$this->type, $this->serial,$_SESSION['loginId']);
		try{
			mysqli_stmt_execute($stmt);
		}catch(mysqli_sql_exception $e){
			return array(False,mysqli_error($conn));
		}
		return array(TRUE,"EquipmentStock added successfully");
	}
}

class DataManager{
	public $pendingCompanyArray=[];
	public $companyArray=[];
	public $topCompanyArray=[];
	public $searchCompanyArray=[];
	
	public $roleArray=[];
	public $serviceArray=[];
	
	public $homeownerArray=[];
	
	
	
	function getAllPendingCompany(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,U.NAME,U.NUMBER,EMAIL,STREET,POSTALCODE,C.DESCRIPTION,C.ACRAPATH,STATUS FROM `USERS` U, `COMPANY` C, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='COMPANYADMIN' AND U.`STATUS` = 'PENDING' AND U.ID = C.ADMIN;");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,C.NAME,U.NUMBER,EMAIL,STREET,POSTALCODE,C.DESCRIPTION,C.ACRAPATH,STATUS FROM `USERS` U, `COMPANY` C, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='COMPANYADMIN'AND U.ID = C.ADMIN;");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getAllHomeownerCompany($id){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT U.ID AS ID,U.NAME,NUMBER,EMAIL,BLOCKNO,UNITNO,STREET,POSTALCODE,HOUSETYPE,NOOFPEOPLE,STATUS FROM `USERS` U, `HOMEOWNER` H, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='HOMEOWNER' AND U.ID = H.ID AND COMPANY=?;");
		mysqli_stmt_bind_param($stmt,"d",$_SESSION['loginId']);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getSearchHomeowner($search){
		$conn = getdb();
		
		$s = explode(" ", $search);
		$sql = "SELECT U.ID AS ID,U.NAME,NUMBER,EMAIL,BLOCKNO,UNITNO,STREET,POSTALCODE,HOUSETYPE,NOOFPEOPLE,STATUS FROM `USERS` U, `HOMEOWNER` H, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='HOMEOWNER' AND U.ID = H.ID AND CONCAT_WS('',U.ID,U.NAME, BLOCKNO,STREET,POSTALCODE,HOUSETYPE) LIKE '%".$s[0]."%'";
		if(count($s)>1){
			for($i=1;$i<count($s);$i++){
				$sql .=" AND CONCAT_WS('',U.ID,U.NAME, BLOCKNO,STREET,POSTALCODE,HOUSETYPE) LIKE '%".$s[$i]."%'";
			}
		}
		
		$stmt = mysqli_prepare($conn,$sql);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getTopCompany($count){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM COMPANY ORDER BY NOOFSTAR DESC, NOOFRATE DESC LIMIT ?;");
		mysqli_stmt_bind_param($stmt,"d",$count);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getSearchCompany($search){
		$conn = getdb();
		
		$s = explode(" ", $search);
		$sql = "SELECT U.ID AS ID,C.NAME,U.NUMBER,EMAIL,STREET,POSTALCODE,C.DESCRIPTION,STATUS FROM `USERS` U, `COMPANY` C, `ROLE` R WHERE U.`TYPE`= R.ID AND R.NAME ='COMPANYADMIN'AND U.ID = C.ADMIN AND CONCAT_WS('',U.ID,U.NAME, STREET,POSTALCODE,C.DESCRIPTION) LIKE '%".$s[0]."%'";
		if(count($s)>1){
			for($i=1;$i<count($s);$i++){
				$sql .=" AND CONCAT_WS('',U.ID,U.NAME, STREET,POSTALCODE,C.DESCRIPTION) LIKE '%".$s[$i]."%'";
			}
		}
		
		$stmt = mysqli_prepare($conn,$sql);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getAllRole(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM ROLE;");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
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
	
	function getAllService(){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT * FROM SERVICETYPE WHERE CREATEDBY IN (SELECT ID FROM USERS WHERE TYPE = (SELECT ID FROM ROLE WHERE NAME ='SUPERADMIN') );");
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					$c = new Service();
					$c->setService($r);
					array_push($this->serviceArray,$c);
				}
			}
		}
	}
	
	function getAllWaterUse($company){
		$waterusage=[];
		$conn = getdb();
		$current = date("Y-m-01",strtotime("-12 month"));
		$stmt = mysqli_prepare($conn,"SELECT EXTRACT(YEAR_MONTH FROM RECORDDATE) AS RECORD, SUM(NOOFPEOPLE) AS NOOFPEOPLE, SUM(`WATERUSAGE(L)`) AS WATERUSAGE FROM WATERUSAGE W, HOMEOWNER H WHERE H.SUBSCRIBE = ? AND STR_TO_DATE (RECORDDATE, '%Y-%m-%d') >= STR_TO_DATE(?, '%Y-%m-%d')  AND H.ID = W.HOMEOWNER GROUP BY RECORD;");
		mysqli_stmt_bind_param($stmt,"ds",$company,$current);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					array_push($waterusage,$r);
				}
			}
			return $waterusage;
		}
	}
	
	function getMeanHomeowner($company){
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT CEILING(AVG(NOOFPEOPLE)) AS NOOFPEOPLEMEAN FROM HOMEOWNER H WHERE H.SUBSCRIBE = ?;");
		mysqli_stmt_bind_param($stmt,"d",$company,);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);		
			$rows = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
			return $rows;
		}
	}
	
	function getUniqueNoofpeople($company){
		$homeowner=[];
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT DISTINCT(NOOFPEOPLE) AS NOOFPEOPLE FROM HOMEOWNER H WHERE H.SUBSCRIBE = (SELECT ID FROM COMPANY WHERE ADMIN = ?);");
		mysqli_stmt_bind_param($stmt,"d",$company,);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);				
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					array_push($homeowner,$r);
				}
			}
			return $homeowner;
		}
	}
	
	function getAreaHomeowner($company){
		$homeowner=[];
		$conn = getdb();
		$stmt = mysqli_prepare($conn,"SELECT AREA, COUNT(ID) AS HOMEOWNER FROM HOMEOWNER H WHERE H.SUBSCRIBE = (SELECT ID FROM COMPANY WHERE ADMIN = ?) GROUP BY AREA;");
		mysqli_stmt_bind_param($stmt,"d",$company,);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);				
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					array_push($homeowner,$r);
				}
			}
			return $homeowner;
		}
	}
	
	function getRevenue($company){
		$revenue=[];
		$conn = getdb();
		$current = date("Y-m-01",strtotime("-12 month"));
		$stmt = mysqli_prepare($conn,"SELECT EXTRACT(YEAR_MONTH FROM PAIDDATE) AS PAIDDATE, SUM(AMOUNT) AS AMOUNT FROM BILL B WHERE B.COMPANY = (SELECT ID FROM COMPANY WHERE ADMIN = ?) AND PAIDDATE > ? GROUP BY PAIDDATE;");
		mysqli_stmt_bind_param($stmt,"ds",$company,$current);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorView"]=mysqli_error($conn);}
		else{
			$result = mysqli_stmt_get_result($stmt);				
			while ($rows = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
				foreach ($rows as $r) {
					array_push($revenue,$r);
				}
			}
			return $revenue;
		}
	}
}

?>