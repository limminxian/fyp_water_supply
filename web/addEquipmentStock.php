
<?php
include_once 'config.php';
include_once 'userClass.php';
?>
<!DOCTYPE html>
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
	  $("#nav-placeholder").load("navBarTech.php");
	});
	</script>
</head>
<h1>Add <?=$_SESSION["equiptype"]->name?> Stock</h1>
<div class="center bg-img">
<?php
if (isset($_POST['submit'])) {
	$serial = $_POST['serial'];
	$c = new EquipmentStock();
	$result = $c->addEquipmentStock(array("type"=>$_SESSION["equiptype"]->type,"serial"=>$serial));
	if($result[0]){		
		$_SESSION["success"]=$result[1];
		header("Location: viewEquipmentStock.php");
	}else{		
		echo "<div class='error'>" . $result[1] . "</div>" ;
	}
}
  

?>

<div >
<form action="" method="post" class="formcontainer">


 
Serial: <input class="form" type="text" name="serial" placeholder="Serial Number" required ><br>


<input class="formbutton" type="submit" name="submit" value="Submit" />
</form>

</div>
</body>
</html>
