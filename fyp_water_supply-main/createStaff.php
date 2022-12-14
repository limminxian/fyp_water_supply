<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="#home">Water Supply 💧 </a>
  <a href="homepage.php">Home</a>
  <div class="topnav-right">
    <a href="login.php">Logout</a>
  </div>
</div>

<div style="padding-left:16px">
  
</div>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
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

  min-height: 700px;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

/* Add styles to the form container */
.container {
  position: absolute;
  left:630px ;
  margin: 20px;
  max-width: 350px;
  padding: 18px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 8px 0 22px 0;
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


<?php
include_once 'config.php';
include_once 'userClass.php';
?>

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

#homeownerForm {
	display: none;
}
	
#companyForm {
	display: none;
}	

</style>

<div class="bg-img">
  <form action="/action_page.php" class="container">
<div class="center">

<h1>Register</h1>
<?php
if(isset($_POST["logout"])){
	unset($_SESSION["loginId"]);
	header("Location: login.php");
}
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$number = $_POST['phonenumber'];
	$role = $_POST['role'];
	//check role	
	$a = new Staff();
	$result = $a->addStaff(array("name"=>$name,"email"=>$email,"number"=>$number,"role"=>$role,"password"=>$name));

	if(isset($_SESSION["errorAddUser"]))
	{
		$a=strval($_SESSION["errorAddUser"]);
		echo "<div class='error'>" . $a . "</div>" ;
		UNSET($_SESSION["errorAddUser"]);
	}
}
  

?>

<div >
<form action="" method="post" >

Role:
<input type="radio" value="technician" id="technician" name="role" required>

<label for="technician">technican</label>

<input type="radio" value="customerservice" id="customerservice" name="role" >
 
 <label for="customerservice">customer service</label>
 <br>
 
Username: <input type="text" name="name" placeholder="Your Name" required ><br>

Phone Number: <input type="text" name="phonenumber" placeholder="Phone Number" oninvalid="this.setCustomValidity('Please insert a valid phone number that starts with 6, 8 or 9 and includes 8 digits');" oninput="setCustomValidity('')" pattern = "^(8|9)\d{7}$" required><br>

E-mail: <input type="email" name="email" placeholder="E-mail Address" required ><br>

<br>

<br>
<input type="submit" class="button" name="submit" value="Submit" />&nbsp;&nbsp;
<input type="button" class="button" onclick="window.location.href='companyAdmin.php';" value="Back" />
<input type="submit" class="button" name="logout" value="Logout" />

</form>
</script>

</div>
</body>
</html>