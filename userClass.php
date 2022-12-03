<?php
include_once 'config.php';
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
  
	// function getRole($role){
		// $conn = getdb();
		// $stmt = mysqli_prepare($conn, "SELECT "$role);
		// if($stmt == false){
			// return "no product";
		// }
		// else{
			// mysqli_stmt_execute($stmt);
			// return mysqli_stmt_get_result($stmt);
		// }
	// }
}

class User{
	//properties
	public $id;
	public $name;
	public $email;
	public $password;
	public $type;
	public $status;
	
	function addUser($user){
		foreach($user as $key=>$value){
			$this->$key = $value;
		}
		$conn = getdb();
		//$hashed = password_hash($this->password,PASSWORD_DEFAULT);
		//  $verify = password_verify($plaintext_password[INPUT], $hash[FROM DATABASE]);
		$stmt = mysqli_prepare($conn,"INSERT INTO `USER` (`NAME`,`EMAIL`, `PASSWORD`, `TYPE`, `STATUS`) VALUES(?,?,?,'2','PENDING');");
		mysqli_stmt_bind_param($stmt,"sss", $this->name,$this->email,$this->password);
		mysqli_stmt_execute($stmt);
		if(mysqli_error($conn)!="" and !empty(mysqli_error($conn))){
			$_SESSION["errorAddUser"]=mysqli_error($conn);
		}
		else{
			mysqli_stmt_close($stmt);
			$_SESSION["addUser"]=true;
			header("Location:login.php");
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
					header("Location:".$row[1].".php");
				}
				else{
					echo "wrong password!";
				}
			}
		}
	}
	
}
?>