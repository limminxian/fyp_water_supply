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
  $("#nav-placeholder").load("navBarSuper.php");
});
</script>

</head>

<body>
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
	
	$_SESSION["page"]="superadmin";
	
	if(isset($_POST["clear"])){
		unset($_POST["searchtext"]);
		unset($_SESSION["search"]);
	}
	
	if (isset($_POST["editComp"])){
		$t = unserialize(base64_decode($_POST["editComp"]));
		$_SESSION["company"]=$t;
		header("Location: editCompanyDetails.php");;
	}
	
	if (isset($_POST["editHome"])){
		$t = unserialize(base64_decode($_POST["editHome"]));
		$_SESSION["homeowner"]=$t;
		header("Location: editHomeownerDetails.php");;
	}
	
	if (isset($_POST["deleteComp"])){
		$t = unserialize(base64_decode($_POST["deleteComp"]));
		echo '
		<script>
		  let text = "Confirm delete?";
		  if (confirm(text) == true) {
			  ';echo($t->deleteCompany());echo'
			  }
		</script>';
	}
	
	if (isset($_POST["deleteHome"])){
		echo '<script>
		confirm("home");
		</script>';
	}
	
	$company = new DataManager();
	$homeowner = new DataManager();
	
	if(isset($_POST["search"]) and isset($_POST["searchtext"]) and ($_POST["searchtext"]!="")){$_SESSION["search"]=$_POST["searchtext"];}
	if (isset($_SESSION["search"])){
		$company->getSearchCompany($_SESSION["search"]);
	}
	else{
		$company->getAllCompany();
	}
?>

<div class="tab">
  <button class="tablinks" onclick="openUser(event, 'Company')" id="defaultOpen">Company</button>
  <button class="tablinks" onclick="openUser(event, 'Homeowner')">Homeowner</button>
</div>

<div id="Company" class="tabcontent">
	<form action="" method="post">
		<input type="text" name="searchtext" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["search"])) echo $_SESSION["search"] ;?>" />
		<input type="submit" name="search" value="search" />
		<input type="submit" name="clear" value="clear" />
	</form>
	<br>
	<table>
	  <tr>
		<th>Company Admin</th>
		<th>Name</th>
		<th>Number</th>
		<th>Email</th>
		<th>Street</th>
		<th>Postal Code</th>
		<th>Description</th>
		<th>Status</th>
		<th></th>
		<th></th>
	  </tr>	
	  <form action="" method="post">
	<?php
	foreach($company->companyArray as $c){
		?>
	  <tr>
		<?php
			$properties = array('id', 'name', 'number', 'email', 'street', 'postalcode', 'description', 'status');
			foreach ($properties as $prop) {?>
				<td>
					<?=$c->$prop?>
				</td>
			<?php }
		?>
		<td>
			<button  value="<?=base64_encode(serialize($c))?>" name="editComp"/>edit</button>
		</td>
		<td>
			<button  value="<?=base64_encode(serialize($c))?>" name="deleteComp"/>delete</button>
		</td>
		</tr>
	  <?php
	}
	?>

	</form>
	</table>
</div>

<div id="Homeowner" class="tabcontent">

	<form action="" method="post">
		<input type="text" name="searchtext" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["search"])) echo $_SESSION["search"] ;?>" />
		<input type="submit" name="search" value="search" />
	</form>
    <?php
	$homeowner->getAllHomeowner();
	?>
	<br>
	<table>
	  <tr>
		<th>ID</th>
		<th>Name</th>
		<th>Number</th>
		<th>Email</th>
		<th>Unit No</th>
		<th>Street</th>
		<th>Postal Code</th>
		<th>House Type</th>
		<th>No of people</th>
		<th>Status</th>
		<th></th>
		<th></th>
	  </tr>	
	  <form action="" method="post">
	<?php
	foreach($homeowner->homeownerArray as $h){
		?>
	  <tr>
		<?php
			$properties = array('id', 'name', 'number', 'email', 'unitno', 'street', 'postalcode', 'housetype', 'noofpeople', 'status' );
			foreach ($properties as $prop) {?>
				<td>
					<?=$h->$prop?>
				</td>
			<?php }
		?>
		<td>
			<button  value="<?=base64_encode(serialize($h))?>" name="editHome"/>edit</button>
		</td>
		<td>
			<button  value="<?=base64_encode(serialize($h))?>" name="deleteHome"/>delete</button>
		</td>
		</tr>
	  <?php
	}
	?>

	</form>
	</table>
</div>

<script>


function openUser(evt, user) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(user).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();


</script>
<?php 
}
?>
   
</body>
</html> 
