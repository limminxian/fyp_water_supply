<<<<<<< HEAD
<html>
<head>
  <title>Login Page</title>
  <style>

body{
  font-family: arial;
}

button{
  background-color: pink;
  border-radius: 8px;
  padding: 10px;
  text-align: center;
  font-size: 16px;
  font-weight:bold;
  margin: 0 auto;
    display: block;
  cursor: pointer;
}

input {
  padding: 10px;
}

button:hover {
  background-color: lightgray;
}

.signup {
  padding: 20px;
  background-color: #83FF9F; /* light green */
  color: black;
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
 </head>
 
 <body>
 <h1>Login</h1>
  <br>
  <br>
  <div align="center">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <p>
    <label for="email" >Email</label><br>
    <input type="text" name="email">
  </p>
  
  <p>
      <label for="password">Password</label><br>
      <input type="password" name="password" autocomplete="off">
 </p>
    <p><button>Login</button></p>
	<input type="button" onclick="window.location.href='signup.php';" value="Company Signup" />
 </form>
 
 <?php
include_once 'config.php';
include_once 'userClass.php';
$check = true;

createTables();

if(isset($_SESSION["signup"]))
{
	echo "<div class='signup'>Sign up successfully please wait to be approved</div>" ;
	UNSET($_SESSION["signup"]);
}

//Submission of the form
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	//email validation
	$email = preVal($_POST['email']);
  
	if(empty($email)) {
		echo "<p>Please enter the email!</p>";
		$check = false;
	} 
	
	//password validation
	$password = preVal($_POST['password']);
  
	if(empty($password))
	{
		echo "<p>Please enter the password!</p>";
		$check = false;
	}
	
	if ($check){
		$a = new User();
		$a->validateLogin(array("email"=>$email,"password"=>$password));
	}
}

//clean up the login form
function preVal($str) {
  return trim($str);
}

?>
</div>
</body>
=======
<html>
<head>
  <title>Login Page</title>
  <style>


.signup {
  padding: 20px;
  background-color: #83FF9F; /* light green */
  color: black;
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
 </head>
 
 <body>
 <h1>Login</h1>
  <br>
  <br>
  <div align="center">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <p>
    <label for="email" >Email</label><br>
    <input type="text" name="email">
  </p>
  
  <p>
      <label for="password">Password</label><br>
      <input type="password" name="password" autocomplete="off">
 </p>
    <p><button>Login</button></p>
	<input type="button" onclick="window.location.href='signup.php';" value="Company Signup" />
 </form>
 
 <?php
include_once 'config.php';
include_once 'userClass.php';
$check = true;

createTables();

if(isset($_SESSION["signup"]))
{
	echo "<div class='signup'>Sign up successfully please wait to be approved</div>" ;
	UNSET($_SESSION["signup"]);
}

//Submission of the form
if($_SERVER['REQUEST_METHOD'] == 'POST') {

	//email validation
	$email = preVal($_POST['email']);
  
	if(empty($email)) {
		echo "<p>Please enter the email!</p>";
		$check = false;
	} 
	
	//password validation
	$password = preVal($_POST['password']);
  
	if(empty($password))
	{
		echo "<p>Please enter the password!</p>";
		$check = false;
	}
	
	if ($check){
		$a = new User();
		$a->validateLogin(array("email"=>$email,"password"=>$password));
	}
}

//clean up the login form
function preVal($str) {
  return trim($str);
}

?>
</div>
</body>
>>>>>>> ddb2060f951b7b6278dd99d680c7853cd98661ea
</html>