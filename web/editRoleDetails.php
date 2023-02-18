<!DOCTYPE html>
<html>
<title>Edit Roles</title> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="style.css">
<div id="nav-placeholder">
</div>

<center>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
$(function(){
  $("#nav-placeholder").load("navBarSuper.php");
});
</script>
</head>
<h1>Edit Roles</h1>
<body>
<div class="center bg-img">

<form action="" method="post" class="formcontainer">
<?php 
include_once 'userClass.php';
if(!isset($_SESSION['loginId'])){
	echo "Not allowed! Please login!";
	?>
	
<br><br><input type="button" onclick="window.location.href='login.php';" value="Login" />

<?php

} 
else{
	if(isset($_POST["logout"])){
		unset($_SESSION["loginId"]);
		header("Location: login.php");
	}

	$r = $_SESSION["role"];
	$prop = array("id","name","description");?>
			<form method="post" action="">
			<?php
	foreach($r as $key=>$value){
		if(strcmp($key, "register")==0){
			
			?>
					<p><?=$key?>: 
				<?php
					if(strcmp($value,'1')==0){
						?>
						  <input type="radio" value="1" id="yes" name="register"  checked="checked" required>

							<label for="yes">Yes</label>

							<input type="radio" value="0" id="no" name="register">
							 
							 <label for="no">No</label>
						<?php
					}
					else{
						?>
						  <input type="radio" value="1" id="yes" name="register" required>

							<label for="yes">Yes</label>

							<input type="radio" value="0" id="no" name="register" checked="checked">
							 
							 <label for="no">No</label>
							<?php
					}
			
			
		}
		else {
			?>
			<?=$key?>: <input type="text" name="<?=$key?>" value="<?=$value?>" class="form" required >
			<?php
			
		}
	}?>
	<br>
				<input type="submit"class="formbutton" name="submit" value="save" />
			</form>
	<?php
	if(isset($_POST["submit"])){
		
		$name = $_POST['name'];
		$description = $_POST['description'];
		$register = $_POST['register'];
		//check role	
		$r->updateRole(array("name"=>$name,"description"=>$description,"register"=>$register));
		header("Location: manageRole.php");
	}
	
	if(isset($_POST["logout"])){
		unset($_SESSION["loginId"]);
		header("Location: login.php");
	}
	
}
?>
   
</body>
</html> 
</center>
