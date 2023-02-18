
<?php
include_once 'config.php';
include_once 'userClass.php';
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['phonenumber'];
	$street = $_POST['street'];
	$postalcode = $_POST['postal'];
	$role = $_POST['role'];
	//check role	
	if (strcmp($role,"companyadmin")==0) {
		$description = $_POST['description'];
		$compName = $_POST['compName'];
		$UEN = $_POST['uen'];
		$file = $_FILES["fileToUpload"];
		$a = new Company();
		$result = $a->addCompany(array("name"=>$name,"email"=>$email,"password"=>$password,"number"=>$number,"street"=>$street,"postalcode"=>$postalcode,"description"=>$description,"compName"=>$compName,"UEN"=>$UEN,"acrapath"=>$file,"role"=>$role));		
		if($result!=""){		
			echo "<div class='error'>" . $result[1] . "</div>" ;
			unset($_POST['role']);
		}else{		
			//header("Location: signUp.php");
			header("Location: login.php");
		}
	}else{
		$block = $_POST['block'];
		//if(isset($_POST['unit'])){}
		$unitno = $_POST['unit'];
		$housetype = $_POST['house'];
		$people = $_POST['people'];
		$a = new Homeowner();
		$result = $a->addHomeowner(array("name"=>$name,"email"=>$email,"password"=>$password,"number"=>$number,"street"=>$street,"postalcode"=>$postalcode,"block"=>$block,"unitno"=>$unitno,"housetype"=>$housetype,"people"=>$people,"role"=>$role));
		if($result[0]){		
			echo "<div class='success'>" . $result[1] . "</div>" ;
			header("Location: login.php");
		}else{		
			echo "<div class='error'>" . $result[1] . "</div>" ;
			unset($_POST['role']);
		}
	}
	
	
}
  

?>
<html>
<head>
<div id="nav-placeholder">
</div>

<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
$(function(){
  $("#nav-placeholder").load("navBarIndex.php");
});
</script>
	<h1>Register</h1>
</head>
<div class="center bg-img">
<form action="" method="post" class="formcontainer" enctype="multipart/form-data" >

Role:
<input type="radio" value="companyadmin" id="companyadmin" name="role" onclick="companyFuntion()" required>

<label for="companyadmin">company admin</label>

<input type="radio" value="homeowner" id="homeowner" name="role" onclick="homeownerFuntion()" >
 
<label for="homeowner">homeowner</label>
 <br>
 
Username: 
<input class="form" type="text" name="name" placeholder="Your Name" required ><br>

Password: <input class="form" type="password" id="password" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Please provide a password that matched rules above');" pattern="^[^\s]*(?=\S{8,16})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])[^\s]*$" oninput="setCustomValidity('')" required >
<br>
Re-type Password: <input class="form" type="password" id="repassword" name="repassword" onkeyup="checkPassword()" placeholder="Re-type Password" required ><br>

Phone Number: <input class="form" type="text" name="phonenumber" placeholder="Phone Number" oninvalid="this.setCustomValidity('Please insert a valid phone number that starts with 6, 8 or 9 and includes 8 digits');" oninput="setCustomValidity('')" pattern = "^(8|9)\d{7}$" required><br>

E-mail: <input class="form" type="email" name="email" placeholder="E-mail Address" required ><br>

Street: <input class="form" type="text" name="street" placeholder="Street" required><br>

Postal Code: <input class="form" type="text" name="postal" placeholder="Postal code" oninvalid="this.setCustomValidity('Please insert a valid postal code that includes 6 digits');" pattern = "^[1-9]\d{5}$" oninput="setCustomValidity('')" required ><br>

<div id="companyForm">

Company Name: <input type="text" class="form compForm" name="compName" placeholder="Compant Name" required ><br>

Decription of Business: <input type="text" class="form compForm" name="description" placeholder="Description" ><br>

UEN: <input type="text" class="form compForm" name="uen" placeholder="UEN" required ><br>

ACRA certificate: <input type="file" class="form compForm" name="fileToUpload" id="fileToUpload" onchange="checkFile()" required>

</div>

<div id="homeownerForm">

Block: <input type="text" class="form homeForm" name="block" placeholder="block" required ><br>

Unit no: <input type="number" title="" class="form homeForm" name="unit" placeholder="unit no"><br>

<label for="house">House type:</label>

<select name="house" id="house" class="form homeForm"  required>
  <option value="oneRoomFlat">1-Room Flat</option>
  <option value="twoRoomFlat">2-Room Flat</option>
  <option value="threeRoomFlat">3-Room Flat</option>
  <option value="fourRoomFlat">4-Room Flat</option>
  <option value="fiveRoomFlat">5-Room Flat</option>
  <option value="executiveFlat">Executive Flat</option>
  <option value="executiveCondo">Executive Condo</option>
  <option value="privateCondo">Private Condo</option>
  <option value="apartment">Apartment</option>
  <option value="semidetached">Semi Detached House</option>
  <option value="terracce">Terrace House</option>
  <option value="shophouse">Shop House</option>
  <option value="bungalow">Bungalow House</option>
</select>
<br>

No. of people: <input type="number" class="form homeForm" name="people" placeholder="No of people" required><br>

</div>

<br>

<br>

<input class="formbutton" type="submit" name="submit" value="Submit" />&nbsp;&nbsp;

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

function checkFile(){
	var filename = document.getElementById("fileToUpload").value;
	var parts = filename.split('.');
	var ext = parts[parts.length - 1];
	switch (ext.toLowerCase()) {
    case 'jpg':
    case 'pdf':
		document.getElementById("fileToUpload").setCustomValidity('');
		break;
	default:
		document.getElementById("fileToUpload").setCustomValidity("Please upload a pdf or jpg file");
	}
		
	
}



</script>

</div>
</body>
</html>
