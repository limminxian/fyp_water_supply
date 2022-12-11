
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
	$password = $_POST['password'];
	$a = new User();
	$a->setPassword($password);
	header("Location: ".$_SESSION['role'].".php");
}
  

?>

<div >
<form action="" method="post" >
First time user. Please set your password that is between 8 to 16 characters, at least one uppercase, at least one lowercase, at least one digit, at least one special character.

Password: <input type="password" id="password" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Please provide a password that matched rules above');" pattern="^[^\s]*(?=\S{8,16})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])[^\s]*$" oninput="setCustomValidity('')" required ><br>

Re-type Password: <input type="password" id="repassword" name="repassword" onkeyup="checkPassword()" placeholder="Re-type Password" required ><br>

</div>

<br>

<br>

<input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;
</form>



<script>

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