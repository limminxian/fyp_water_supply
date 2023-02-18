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
		$t->changeStatus("SUSPEND");
		/* 
		$_SESSION["company"]=$t;
		header("Location: editCompanyDetails.php");; */
	}
	
	if (isset($_POST["editHome"])){
		$t = unserialize(base64_decode($_POST["editHome"]));
		$t->changeStatus("SUSPEND");
		/* header("Location: editHomeownerDetails.php");; */
	}
	
	
	$company = new DataManager();
	$homeowner = new DataManager();
	
	if(isset($_POST["searchCom"]) and isset($_POST["searchtextCom"]) and ($_POST["searchtextCom"]!="")){$_SESSION["searchCom"]=$_POST["searchtextCom"];unset($_POST["searchCom"]);}
	if (isset($_SESSION["searchCom"])){
		$company->getSearchCompany($_SESSION["searchCom"]);
	}
	else{
		$company->getAllCompany();
	}
	
	if(isset($_POST["searchHome"]) and isset($_POST["searchtextHome"]) and ($_POST["searchtextHome"]!="")){$_SESSION["searchHome"]=$_POST["searchtextHome"];unset($_POST["searchHome"]);}
	if (isset($_SESSION["searchHome"])){
		$homeowner->getSearchHomeowner($_SESSION["searchHome"]);
	}
	else{
		$homeowner->getAllHomeowner();
	}
	
	if(isset($_POST["clearCom"])){
		unset($_SESSION["searchCom"]);
		header('Location: '.$_SERVER['PHP_SELF']);
	}
	
	if(isset($_POST["clearHome"])){
		unset($_SESSION["searchHome"]);
		header('Location: '.$_SERVER['PHP_SELF']);
	}
?>

<div class="tab">
  <button class="tablinks" onclick="openUser(event, 'Company');this.form.submit()" name="c" <?php if(isset($_SESSION["com"])) {echo 'id="defaultOpen"' ;}else if(!isset($_SESSION["home"])){echo 'id="defaultOpen"' ;}?>>Company</button>
  <button class="tablinks" onclick="openUser(event, 'Homeowner');this.form.submit()" name="h" <?php if(isset($_SESSION["home"])) {echo 'id="defaultOpen"';}?>>Homeowner</button>
</div>

<div id="Company" class="tabcontent">
	<form action="" method="post">
		<input type="text" name="searchtextCom" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["searchCom"])) echo $_SESSION["searchCom"] ;?>" />
		<input type="submit" name="searchCom" class="edit" value="search" />
		<input type="submit" name="clearCom" class="edit" value="clear" />
	</form>
	<br>
	<table>
		
	
		<tr bgcolor="#488AC7">
		<th>Company Admin</th>
		<th>Name</th>
		<th>Number</th>
		<th>Email</th>
		<th>Street</th>
		<th>Postal Code</th>
		<th>Description</th>
		<th>Status</th>
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
			<center>
			<button  value="<?=base64_encode(serialize($c))?>" class="edit"name="editComp"/>SUSPEND</button>
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
		<input type="text" name="searchtextHome" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["searchHome"])) echo $_SESSION["searchHome"] ;?>" />
		<input type="submit" class="edit" name="searchHome" value="search" />
		<input type="submit" name="clearHome" class="edit" value="clear" />
	</form>
	<br>
	<table>
		<tr bgcolor="#488AC7">
	  
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
			<center>
			<button  value="<?=base64_encode(serialize($h))?>" class="edit"name="editHome"/>SUSPEND</button>
		</td>
		<td>
			<center>
			
		  </center>
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
    tablinks[i].id = "";
  }
  document.getElementById(user).style.display = "block";
  evt.currentTarget.className += " active";
  evt.currentTarget.id = "defaultOpen";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();


</script>
<?php 
}
?>
   
</body>
</html> 
