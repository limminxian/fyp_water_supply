<!DOCTYPE html>
<?php
include_once 'config.php';
include_once 'userClass.php';

?>

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

<h1>Add Rate</h1>
<?php
if(isset($_POST["logout"])){
	unset($_SESSION["loginId"]);
	header("Location: login.php");
}
if (isset($_POST['submit'])) {
	$effectdate = $_POST['effectdate'];
	$r = $_POST['rate'];
	//check role	
	$service = $_SESSION["service"];
	$rate= new Rate();
	$result = $rate->addRate(array("service"=>$service->id,"effectdate"=>$effectdate,"rate"=>$r));

	if(isset($_SESSION["errorAddUser"]))
	{
		$service=strval($_SESSION["errorAddUser"]);
		echo "<div class='error'>" . $service . "</div>" ;
		UNSET($_SESSION["errorAddUser"]);
	}
	
	header("Location: viewServiceRates.php");
	
}
  

?>

<div class="center bg-img">

<form action="" method="post" class="formcontainer">

 
<label for="effectdate">Effective date:</label>
<input type="date" id="effectdate" name="effectdate"> <br>

Rate: <input type="number" step="0.01" name="rate" placeholder="rate" class="form" required ><br>
 
<br>

<br>
<input class="formbutton" type="submit" name="submit" value="Submit" />

</form>
</script>

</div>
</body>
</html>
