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
	  $("#nav-placeholder").load("navBarComp.php");
	});
	</script>
</head>
<body>
<?php 
include_once 'userClass.php';
$_SESSION["page"]="manageServiceCompany";
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

	if (isset($_POST["suspend"])){
		$t = unserialize(base64_decode($_POST["suspend"]));
		$t->updateService("suspend");
	}
	
	if (isset($_POST["rates"])){
		$t = unserialize(base64_decode($_POST["rates"]));
		$_SESSION["service"]=$t;
		header("Location: viewServiceRates.php");
	}
	
$service = new Company();
$s= $service->getAllService($_SESSION["loginId"]);
if(isset($_SESSION["success"])){		
	echo "<div class='success'>" . $_SESSION["success"]. "</div>" ;
	unset($_SESSION["success"]);
}
?>
<br>

<a class="rightButton" href="createServiceComp.php">Add new service</a>

<table>
  <tr bgcolor="#488AC7">
    <th>Name</th>
    <th>Description</th>
    <th>Latest rate</th>
    <th>Status</th>
	<th></th>
	<th></th>
  </tr>	
  <form action="" method="post">
<?php
foreach($s as $r){
	?>
  <tr>
	<?php
		$properties = array('name', 'description', 'rate','status');
		
		foreach ($properties as $prop) {?>
			<td>
				<?=$r->$prop?>
			</td>
		<?php 
		}?>
			<td>
				<button  value="<?=base64_encode(serialize($r))?>" class="edit"name="rates"/>rates</button>
			</td>
			<?php
		if($r->createdby!=0){
			
			?>
			<td>
				<button  value="<?=base64_encode(serialize($r))?>" class="edit"name="suspend"/>suspend</button>
			</td>
	         
			<?php
		}
		else{?>
			<td>
			</td>
			<?php
		}?>
			</tr>
			<?php
}
?>

</form>
</table>
</div>

<?php 
}
?>
   
</body>
</html> 
