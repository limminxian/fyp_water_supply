
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
	$number = $_POST['phonenumber'];
	$street = $_POST['street'];
	$postalcode = $_POST['postal'];
	$role = $_POST['role'];
	//check role	
	if (strcmp($role,"company")==0) {
		$description = $_POST['description'];
		$compName = $_POST['compName'];
		$UEN = $_POST['uen'];
		$a = new Company();
		$hashed = password_hash($password,PASSWORD_DEFAULT);
		$result = $a->addCompany(array("name"=>$name,"email"=>$email,"password"=>$hashed,"number"=>$number,"street"=>$street,"postalcode"=>$postalcode,"description"=>$description,"compName"=>$compName,"UEN"=>$UEN,"role"=>$role));
	}else{
		$block = $_POST['block'];
		$unitno = $_POST['unit'];
		$housetype = $_POST['house'];
		$people = $_POST['people'];
		$a = new Homeowner();
		$hashed = password_hash($password,PASSWORD_DEFAULT);
		$result = $a->addHomeowner(array("name"=>$name,"email"=>$email,"password"=>$hashed,"number"=>$number,"street"=>$street,"postalcode"=>$postalcode,"block"=>$block,"unitno"=>$unitno,"housetype"=>$housetype,"people"=>$people,"role"=>$role));
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
<input type="radio" value="company" id="company" name="role" onclick="companyFuntion()" required>

<label for="company">company</label>

<input type="radio" value="homeowner" id="homeowner" name="role" onclick="homeownerFuntion()" >
 
 <label for="homeowner">homeowner</label>
 <br>
 
Userame: <input type="text" name="name" placeholder="Your Name" required ><br>

Password: <input type="password" id="password" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Please provide a password that is between 8 to 16 characters, at least one uppercase, at least one lowercase, at least one digit, at least one special character');" pattern="^[^\s]*(?=\S{8,16})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])[^\s]*$" oninput="setCustomValidity('')" required ><br>

Re-type Password: <input type="password" id="repassword" name="repassword" onkeyup="checkPassword()" placeholder="Re-type Password" required ><br>

Phone Number: <input type="text" name="phonenumber" placeholder="Phone Number" oninvalid="this.setCustomValidity('Please insert a valid phone number that starts with 6, 8 or 9 and includes 8 digits');" oninput="setCustomValidity('')" pattern = "^(8|9)\d{7}$" required><br>

E-mail: <input type="email" name="email" placeholder="E-mail Address" required ><br>

Street: <input type="text" name="street" placeholder="Street" required><br>

Postal Code: <input type="text" name="postal" placeholder="Postal code" oninvalid="this.setCustomValidity('Please insert a valid postal code that includes 6 digits');" pattern = "^[1-9]\d{5}$" oninput="setCustomValidity('')" required ><br>

<div id="companyForm">

Company Name: <input type="text" class="compForm" name="compName" placeholder="Compant Name" required ><br>

Decription of Business: <input type="text" class="compForm" name="description" placeholder="Description" ><br>

UEN: <input type="text" class="compForm" name="uen" placeholder="UEN" required ><br>

</div>

<div id="homeownerForm">

Block: <input type="text" class="homeForm" name="block" placeholder="block" required ><br>

Unit no: <input type="number" class="homeForm" name="unit" placeholder="unit no" required><br>

<label for="house">House type:</label>

<select name="house" id="house" class="homeForm"  required>
  <option value="HDB">HDB</option>
  <option value="condo">Condo</option>
  <option value="landed">Landed property</option>
</select>
<br>

No. of people: <input type="number" class="homeForm" name="people" placeholder="No of people" required><br>

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
	let collection1 = document.getElementsByClassName("compForm");
	for (let i = 0; i < collection1.length; i++) {
		collection1[i].required = false;
	}
	let collection2 = document.getElementsByClassName("homeForm");
	for (let i = 0; i < collection2.length; i++) {
		collection2[i].required = true;
	}
}

function companyFuntion() {
	document.getElementById("homeownerForm").style.display = "none";
	document.getElementById("companyForm").style.display = "inline";
	let collection1 = document.getElementsByClassName("homeForm");
	for (let i = 0; i < collection1.length; i++) {
		collection1[i].required = false;
	}
	let collection2 = document.getElementsByClassName("compForm");
	for (let i = 0; i < collection2.length; i++) {
		collection2[i].required = true;
	}
}

function checkPassword() {
	var x = document.getElementById("repassword").value;
	var y = document.getElementById("password").value;
	
	if(x.localeCompare(y)!=0){
		document.getElementById("repassword").setCustomValidity("Password do not match");
	}
	else{
		document.getElementById("repassword").setCustomValidity('');
	}
}
</script>

</div>
</body>
</html>