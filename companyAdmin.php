<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>
<?php 
include_once 'userClass.php';
if(!isset($_SESSION['checkLogin'])){
	echo "Not allowed! Please login!";
	?>
	
<br><br><input type="button" onclick="window.location.href='login.php';" value="Login" />

<?php

} 
else{
	
$staff = new DataManager();
$staff->getAllStaff();
?>
<div class="topnav">
  <a class="active" href="#account">Manage Account</a>
  <a class="active" href="#record">View Records</a>
  <a class="active" href="#service">Service Rates</a>
  
</div>

<div class="tab">
  <button class="tablinks" onclick="openUser(event, 'Staff')" id="defaultOpen">Staff</button>
  <button class="tablinks" onclick="openUser(event, 'Homeowner')">Homeowner</button>
</div>

<div id="Staff" class="tabcontent">
	<input type="button" onclick="window.location.href='createStaff.php';" value="Create Staff" />
<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Number</th>
    <th>Email</th>
    <th>Type</th>
    <th>Status</th>
    <th></th>
	<th></th>
  </tr>	
  <form action="" method="post">
<?php
foreach($staff->staffArray as $s){
	?>
  <tr>
	<?php
		$properties = array('id', 'name', 'number', 'email', 'type', 'status');
		foreach ($properties as $prop) {?>
			<td>
				<?=$s->$prop?>
			</td>
		<?php }
	?>
	<td>
		<button  value="<?=base64_encode(serialize($s))?>" name="edit"/>Edit</button>
	</td>
	<td>
		<button  value="<?=base64_encode(serialize($s))?>" name="delete"/>Delete</button>
	</td>
  </tr><?php
}
if(isset($_POST["back"])){
	unset($_SESSION["view"]);
	header("Location: superadmin.php");
}
?>
		<p>
			<input type="submit" name="back" value="Back" />
		</p>
</form>
</div>

<div id="Homeowner" class="tabcontent">
  <h3>Homeowner</h3>
  <p>Homeowner</p> 
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
