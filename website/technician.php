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
$_SESSION["page"]="technician";
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

if (isset($_POST["addNew"])){
	header("Location: addChemical.php");
}

if (isset($_POST["addstock"])){
	$t = unserialize(base64_decode($_POST["addstock"]));
	$_SESSION["chemical"]=$t;
	header("Location: addChemicalStock.php");
}

if (isset($_POST["addused"])){
	$t = unserialize(base64_decode($_POST["addused"]));
	$_SESSION["chemical"]=$t;
	header("Location: addChemicalUsed.php");
}

if (isset($_POST["view"])){
	$t = unserialize(base64_decode($_POST["view"]));
	$_SESSION["chemical"]=$t;
	header("Location: viewChemicalUsed.php");
}

if (isset($_POST["viewest"])){
	$t = unserialize(base64_decode($_POST["viewest"]));
	$_SESSION["chemical"]=$t;
	header("Location: viewChemicalEstimation.php");
}
if(isset($_SESSION["success"])){		
	echo "<div class='success'>" . $_SESSION["success"]. "</div>" ;
	unset($_SESSION["success"]);
}
$chemical = new Company();
$chemical->getAllChemical();
?>
<br>
<table>
 <tr bgcolor="#488AC7">
    <th>Name</th>
    <th>Amount</th>
    <th>Measurement</th>
    <th>Used per 1L water</th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>	
  <form action="" method="post">
  	<a class="rightButton" href="addChemical.php">Add new chemical</a>
<?php
foreach($chemical->chemicalArray as $c){
	?>
  <tr>
	<?php
		$properties = array('name','amount','measurement','per1lwater');
		foreach ($properties as $prop) {?>
			<td>
				<?=$c->$prop?>
			</td>
		<?php }
	?>
	<td>
		<center>
		<button  value="<?=base64_encode(serialize($c))?>" class="edit"name="viewest"/>VIew estimation usage</button>
	  </center>
	</td>
	<td>
		<center>
		<button  value="<?=base64_encode(serialize($c))?>" class="edit"name="addstock"/>Add stock</button>
	  </center>
	</td>
	<td>
		<center>
		<button  value="<?=base64_encode(serialize($c))?>" class="edit"name="addused"/>Add amount used</button>
	  </center>
	</td>
	<td>
		<center>
		<button  value="<?=base64_encode(serialize($c))?>" class="edit"name="view"/>View amount Used</button>
	</center>
	</td>
	<!--td>
		<center>
		<button  value="<?=base64_encode(serialize($c))?>" class="edit"name="edit"/>edit</button>
	</center>
	</td>
	<td>
		<center>
		
</center>
	</td-->
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
