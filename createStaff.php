
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
 
Userame: <input type="text" name="name" placeholder="Your Name" required ><br>

Phone Number: <input type="text" name="phonenumber" placeholder="Phone Number" oninvalid="this.setCustomValidity('Please insert a valid phone number that starts with 6, 8 or 9 and includes 8 digits');" oninput="setCustomValidity('')" pattern = "^(8|9)\d{7}$" required><br>

E-mail: <input type="email" name="email" placeholder="E-mail Address" required ><br>

<br>

<br>
<input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;
<input type="button" onclick="window.location.href='companyAdmin.php';" value="Back" />
<input type="submit" name="logout" value="Logout" />

</form>
</script>

</div>
</body>
</html>