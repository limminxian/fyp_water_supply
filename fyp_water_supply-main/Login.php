<html>
<head>
  <title>Login Page</title>
  <style>

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #203354;
  color: Dark blue;
}

.topnav-right {
  float: right;
}
body, html {
  height: 100%;
  font-family: Arial, Helvetica, times new roman;
}

* {
  box-sizing: border-box;
}

.bg-img {
  /* The image used */
  background-image: url("backdrop.jpg");

  min-height: 900px;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

/* Add styles to the form container */
.container {
  position: absolute;
  left:555px ;
  margin: 20px;
  max-width: 350px;
  padding: 20px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
.button {
  background-color: #7EB6FF;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
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
 <div class="topnav">
  <a class="active" href="#home">Water Supply 💧 </a>
  <a href="homepage.php">Home</a>
  <a href="about page.php">About</a>
  <div class="topnav-right">
    <a href="signUp.php">Register</a>
    <a href="login.php">Login</a>
  </div>
</div>

<div style="padding-left:16px">
  
</div>
<div style="padding-left:16px">
  
</div>

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
createSuperadmin();

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
		$result = $a->validateLogin(array("email"=>$email,"password"=>$password));
		if($result[0]){
			header("Location:".$result[1].".php");
		}else{
			echo $result[1];
		}
	}
}

//clean up the login form
function preVal($str) {
  return trim($str);
}

?>
</div>
</body>