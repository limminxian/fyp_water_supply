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
 </head>
 <?php
	include_once 'config.php';
	include_once 'userClass.php';
 ?>
 <body>
 <h1>Login</h1>
  <br>
  <?php
  if(isset($_SESSION["error"])){
		echo "<div class='error'>".$_SESSION["error"]."</div>" ;
		UNSET($_SESSION["error"]);
  }
	?>
  <br>
  <div class="center bg-img">
  <form action="" method="post" class="formcontainer">
  <p>
    <label for="email" >Email</label><br>
    <input class="form" type="text" name="email">
  </p>
  
  <p>
      <label for="password">Password</label><br>
      <input class="form" type="password" name="password" autocomplete="off">
 </p>
    <input class="formbutton" type="submit" name="submit" value="Login" />
 </form>
 

 <?php
$check = true;


//Submission of the form
if(isset($_POST["submit"])) {

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
			// '<?php echo $result[1]; ?'
		}else{
			$_SESSION["error"] = $result[1];
			header("Refresh:0");
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