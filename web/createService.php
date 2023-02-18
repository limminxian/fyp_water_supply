<!DOCTYPE html>
<?php
include_once 'config.php';
include_once 'userClass.php';

?>

<html>
<title>create service</title> 

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
  $("#nav-placeholder").load("navBarSuper.php");
});
</script>

</head>

<h1>Create Service </h1>
<?php
if(isset($_POST["logout"])){
	unset($_SESSION["loginId"]);
	header("Location: login.php");
}
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$tech = $_POST['tech'];
	//check role	
	$a = new Service();
	$result = $a->addService(array("name"=>$name,"description"=>$description,"toTech"=>$tech));
	if($result!=""){
		echo "<div class='error'>" . $result . "</div>" ;
	}else{
		header("Location: manageServiceSuperadmin.php");
	}
}

?>

<div class="center bg-img">

<form action="" method="post" class="formcontainer">

 
Name: <input type="text" name="name" placeholder="Name" class="form" required ><br>

Description: <input type="text" name="description" placeholder="Description" class="form" required ><br>

Send To Technician Automatically:
<input type="radio" value="1" id="yes" name="tech" required>

<label for="yes">Yes</label>

<input type="radio" value="0" id="no" name="tech" >
 
 <label for="no">No</label>
 
<br>
<br>

<br>
<input class="formbutton" type="submit" name="submit" value="Submit" />

</form>
</script>

</div>
</body>
</html>
