<!DOCTYPE html>
<html>
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
<body>
<?php 
include_once 'userClass.php';
$_SESSION["page"]="viewEquipment";
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

$equipment = new Equipment();
$equipment->getAllEquipmentHomeowner($_SESSION["equiptype"]->type);

if (isset($_POST["add"])){
	header("Location: addEquipmentStock.php");
}

if (isset($_POST["csv"])){
	header("Location: addEquipmentCSV.php");
}

?>
<br>
<table>
  <tr>
    <th>ID</th>
    <th>serial number</th>
    <th>installation date</th>
    <th>uninstallation date</th>
    <th>homeowner</th>
  </tr>	
  <form action="" method="post">
<?php
foreach($equipment->equipmentArray as $c){
	?>
  <tr>
	<?php
		$properties = array('id', 'equipment', 'installationdate','uninstallationdate','homeowner');
		foreach ($properties as $prop) {?>
			<td>
				<?=$c->$prop?>
			</td>
		<?php }
	?>
	</tr>
  <?php
}
?>

</form>
</div>

<?php 
}
?>
   
</body>
</html> 
