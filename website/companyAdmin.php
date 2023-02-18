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

if (isset($_POST["edit"])){
		$t = unserialize(base64_decode($_POST["edit"]));
		$t->changeStatus("SUSPEND");
		/* header("Location: editHomeownerDetails.php");; */
	}
	
$_SESSION["page"]="companyadmin";

$company = new Company();
$company->getAllStaff();
$c = new CompanyAdmin();
$id = $c->getCompany($_SESSION["loginId"]);
$company->getAllHomeowner($id);
?>


<div class="tab">
  <button class="tablinks" onclick="openUser(event, 'Staff')" id="defaultOpen">Staff</button>
  <button class="tablinks" onclick="openUser(event, 'Homeowner')">Homeowner</button>
</div>

<div id="Staff" class="tabcontent">
	
	<a class="rightButton" href="createStaff.php">Create Staff</a>
	<form action="" method="post">
		<input type="text" name="searchtext" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["search"])) echo $_SESSION["search"] ;?>" />
		<input type="submit" class="edit"name="search" value="search" />
		<input type="submit" class="delete"name="clear" value="clear" />
	</form>
	<table>
	 <tr bgcolor="#488AC7">
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Role</th>
		<th>Status</th>
		<th></th>
		<th></th>
	  </tr>	
	  <form action="" method="post">
	<?php
	foreach($company->staffArray as $s){
		?>
	  <tr>
		<?php
			$properties = array('id', 'name', 'email', 'role', 'status');
			foreach ($properties as $prop) {?>
				<td>
					<?=$s->$prop?>
				</td>
			<?php }
		?>
		<td>
			<button  value="<?=base64_encode(serialize($s))?>" class="edit"name="edit"/>suspend</button>
		</td>
		<td>
			
		</td>
	  </tr><?php
	}
	?>
	</form>
	</table>
</div>

<div id="Homeowner" class="tabcontent">
<form action="" method="post">
		<input type="text" name="searchtext" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["search"])) echo $_SESSION["search"] ;?>" />
		<input type="submit" class="edit"name="search" value="search" />
		<input type="submit" class="delete"name="clear" value="clear" />
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
		<th>Card</th>
		<th></th>
		<th></th>
	  </tr>	
	  <form action="" method="post">
	<?php
	foreach($company->homeownerArray as $h){
		?>
	  <tr>
		<?php
			$properties = array('id', 'name', 'number', 'email', 'unitno', 'street', 'postalcode', 'housetype', 'noofpeople', 'status', 'card' );
			foreach ($properties as $prop) {?>
				<td>
					<?=$h->$prop?>
				</td>
			<?php }
		?>
		<!--td>
			<center>
			<button  value="<?=base64_encode(serialize($h))?>" class="edit"name="editHome"/>suspend</button>
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
