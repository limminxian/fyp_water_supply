
<?php
include_once 'config.php';
include_once 'userClass.php';
?>

<html>
<title>IT for rent</title> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="style.css">

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<h1>First time login</h1>
<?php
if (isset($_POST['submit'])) {
	$password = $_POST['password'];
	$a = new Staff();
	$a->setPasswordStatus($password);
	header("Location: ".$_SESSION['role'].".php");
}
  

?>

<div class="center bg-img">
<form action="" method="post" class="formcontainer">

Password: <input class="form" type="password" id="password" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Please provide a password that matched rules above');" pattern="^[^\s]*(?=\S{8,16})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])[^\s]*$" oninput="setCustomValidity('')" required ><br>

Re-type Password: <input class="form" type="password" id="repassword" name="repassword" onkeyup="checkPassword()" placeholder="Re-type Password" required ><br>


<input class="formbutton" type="submit" name="submit" value="Submit" />
</div>

<br>

<br>
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