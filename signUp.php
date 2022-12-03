<html>
<title>IT for rent</title> 

  <style>
  .error{
  padding: 20px;
  background-color: #D91D1D; /* red */
  color: white;
  -moz-animation: cssAnimation 0s ease-in 2s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 2s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 2s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 2s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@keyframes cssAnimation {
    to {
        width:0;
        height:0;
        overflow:hidden;
		padding: 0;
    }
}
@-webkit-keyframes cssAnimation {
    to {
        width:0;
        height:0;
        visibility:hidden;
		padding: 0;
    }
}

</style>
<h1>Register</h1>
<?php
include_once 'config.php';
include_once 'userClass.php';
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['number'];
	$street = $_POST['street'];
	$postalcode = $_POST['postal'];
	$description = $_POST['description'];
	$checker = TRUE;

	//validation
	if(empty($name)) {
		$nameError = "**Please insert your name**";
		$checker = FALSE; 
	} 
  
	if(empty($email)) {
		$emailError = "**Please insert your email**";
		$checker = FALSE;
	}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {   
		$emailError = "**Please insert a valid email**";
		$checker = FALSE;
	}
  
	if (empty($password))  { 
	$passwordError = "**Please insert your password**";
    $checker = FALSE;}
	else if (!preg_match('/^[^\s]*(?=\S{8,16})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])[^\s]*$/',
					$password))
	{
		$passwordError ="password must be between 8 to 16 characters, at least one uppercase, at least one lowercase, at least one digit, at least one special character";
		$checker = FALSE;
	}
	
	if ($checker) {
		$a = new User();
		$hashed = password_hash($password,PASSWORD_DEFAULT);
		$result = $a->addUser(array("name"=>$name,"email"=>$email,"password"=>$hashed,"number"=>$number,"street"=>$street,"postalcode"=>$postalcode,"description"=>$description));
	}

	if(isset($_SESSION["errorAddUser"]))
	{
		$a=strval($_SESSION["errorAddUser"]);
		echo "<div class='error'>" . $a . "</div>" ;
		UNSET($_SESSION["errorAddUser"]);
	}
}
  

?>

<div>
  <form action="" method="post">
  
Userame: <input type="text" name="name" placeholder="Your Name" value="<?php if (isset($_POST["name"])) echo $_POST["name"];?>"><br>
<?php if(isset($nameError)) { ?>
<p><?php echo $nameError ?> </p>
<?php } ?>

Password: <input type="password" name="password" placeholder="Password" ><br>
<?php if(isset($passwordError)) { ?>
  <p><?php echo $passwordError ?> </p>
<?php } ?>

Re-type Password: <input type="password" name="password" placeholder="Password" ><br>
<?php if(isset($retypePasswordError)) { ?>
  <p><?php echo $retypePasswordError ?> </p>
<?php } ?>

Company Name: <input type="text" name="compName" placeholder="Compant Name" ><br>
<?php if(isset($passwordError)) { ?>
  <p><?php echo $passwordError ?> </p>
<?php } ?>

Number: <input type="text" name="number" placeholder="Number" ><br>
<?php if(isset($retypePasswordError)) { ?>
  <p><?php echo $retypePasswordError ?> </p>
<?php } ?>

E-mail: <input type="text" name="email" placeholder="E-mail Address" value="<?php if (isset($_POST["email"])) echo $_POST["email"];?>"><br>
<?php if(isset($emailError)) { ?>
  <p><?php echo $emailError ?> </p>
<?php } ?>

Street: <input type="text" name="street" placeholder="Street" ><br>
<?php if(isset($retypePasswordError)) { ?>
  <p><?php echo $retypePasswordError ?> </p>
<?php } ?>

Postal Code: <input type="text" name="postal" placeholder="Postal code" value="<?php if (isset($_POST["email"])) echo $_POST["email"];?>"><br>
<?php if(isset($emailError)) { ?>
  <p><?php echo $emailError ?> </p>
<?php } ?>

Decription of Business: <input type="text" name="description" placeholder="Description" ><br>
<?php if(isset($passwordError)) { ?>
  <p><?php echo $passwordError ?> </p>
<?php } ?>


<br>

<input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;
<input type="button" onclick="window.location.href='login.php';" value="Login" />
</div>
</body>
</html>