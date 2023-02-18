
<?php
include_once 'config.php';
include_once 'userClass.php';
?>
<!DOCTYPE html>
<html>
<title>IT for rent</title> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="style.css">
<div id="nav-placeholder">
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
$(function(){
  $("#nav-placeholder").load("navBarComp.php");
});
</script>
</head>
<h1>Create Staff</h1>
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

<div class="center bg-img">
<form action="" method="post" class="formcontainer" >

Role:
<input type="radio" value="technician" id="technician" name="role" required>

<label for="technician">technican</label>

<input type="radio" value="customerservice" id="customerservice" name="role" >
 
 <label for="customerservice">customer service</label>
 <br>
 
Userame: <input type="text" name="name" placeholder="Your Name" class="form" required><br>

Phone Number: <input type="text" name="phonenumber" placeholder="Phone Number" oninvalid="this.setCustomValidity('Please insert a valid phone number that starts with 6, 8 or 9 and includes 8 digits');" oninput="setCustomValidity('')" pattern = "^(8|9)\d{7}$" class="form" required><br>

E-mail: <input type="email" name="email" placeholder="E-mail Address" class="form" required ><br>

<br>

<br>
<input type="submit" name="submit" value="Submit" class="formbutton"/>

</form>

</div>
</body>
</html>
