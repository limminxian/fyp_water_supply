
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
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$number = $_POST['number'];
	$street = $_POST['street'];
	$postalcode = $_POST['postal'];
	$description = $_POST['description'];
	$checker = TRUE;

	//validation
	
	if ($_POST['role']=="c") {
		$a = new User();
		$hashed = password_hash($password,PASSWORD_DEFAULT);
		$result = $a->addUser(array("name"=>$name,"email"=>$email,"password"=>$hashed,"number"=>$number,"street"=>$street,"postalcode"=>$postalcode,"description"=>$description));
	}else{
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

<div >
  <form action="" method="post" >

Role:
<input type="radio" value="company" id="company" name="role" onclick="companyFuntion()" <?php if (isset($_POST["role"])) if($_POST["role"]  == "company" ) echo 'checked'; ?> required>

<label for="company">company</label>

<input type="radio" value="homeowner" id="homeowner" name="role" onclick="homeownerFuntion()" <?php if (isset($_POST["role"])) if($_POST["role"]  == "homeowner" ) echo 'checked'; ?>>
 
 <label for="homeowner">homeowner</label>
 <br>
 
Userame: <input type="text" name="name" placeholder="Your Name" value="<?php if (isset($_POST["name"])) echo $_POST["name"];?>" required ><br>

Password: <input type="password" id="password" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Please provide a password that is between 8 to 16 characters, at least one uppercase, at least one lowercase, at least one digit, at least one special character');" pattern="^[^\s]*(?=\S{8,16})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])[^\s]*$" oninput="setCustomValidity('')" required ><br>

Re-type Password: <input type="password" id="repassword" name="repassword" onkeyup="checkPassword()" placeholder="Re-type Password" required ><br>

Phone Number: <input type="text" name="phone number" placeholder="Phone Number" oninvalid="this.setCustomValidity('Please insert a valid phone number that starts with 6, 8 or 9 and includes 8 digits');" pattern = "^(8|9)\d{7}$" oninput="setCustomValidity('')" required><br>

E-mail: <input type="email" name="email" placeholder="E-mail Address" value="<?php if (isset($_POST["email"])) echo $_POST["email"];?>" oninput="setCustomValidity('')" required ><br>

Street: <input type="text" name="street" placeholder="Street" required><br>

Postal Code: <input type="text" name="postal" placeholder="Postal code" value="<?php if (isset($_POST["email"])) echo $_POST["email"];?>"  oninvalid="this.setCustomValidity('Please insert a valid postal code that includes 6 digits');" pattern = "^[1-9]\d{5}$" oninput="setCustomValidity('')" required ><br>

<div id="companyForm">

Company Name: <input type="text" name="compName" placeholder="Compant Name" required ><br>

Decription of Business: <input type="text" name="description" placeholder="Description" ><br>

UEN: <input type="text" name="uen" placeholder="UEN" required ><br>

</div>

<div id="homeownerForm">

Block: <input type="text" name="block" placeholder="block" required ><br>

Unit no: <input type="number" name="unit" placeholder="unit" value="<?php if (isset($_POST["email"])) echo $_POST["email"];?>" required><br>

<label for="house">House type:</label>

<select name="house" id="house" required>
  <option value="HDB">HDB</option>
  <option value="condo">Condo</option>
  <option value="landed">Landed property</option>
</select>
<br>

No. of people: <input type="text" name="people" placeholder="No of people" value="<?php if (isset($_POST["email"])) echo $_POST["email"];?>" required><br>

</div>

<br>

<br>

<input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;
<input type="button" onclick="window.location.href='login.php';" value="Login" />

</form>



<script>
function homeownerFuntion() {
	document.getElementById("companyForm").style.display = "none";
	document.getElementById("homeownerForm").style.display = "inline";
}
function companyFuntion() {
	document.getElementById("homeownerForm").style.display = "none";
	document.getElementById("companyForm").style.display = "inline";
}
function checkPassword() {
	var x = document.getElementById("repassword").value;
	var y = document.getElementById("password").value;
	
	if(x.localeCompare(y)!=0){
		document.getElementById("repassword").setCustomValidity("Password do not match");
	}
	else{
		document.getElementById("repassword").setCustomValidity("");
	}
}
</script>

</div>
</body>
</html>