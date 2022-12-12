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

$chemical = new Company();
$chemical->getAllChemical();
?>
<div class="topnav">
  <a class="active" href="#manage">View Equipment</a>
  <a href="viewChemical.php">View Chemical</a>
  <form action="post">
	<input type="submit" name="logout" value="Logout" />
	</form>
  
</div>

<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Amount</th>
    <th></th>
    <th></th>
    <th></th>
	<th></th>
  </tr>	
  <form action="" method="post">
  
		<button name="addNew"/>Add new chemical</button>
<?php
foreach($chemical->chemicalArray as $c){
	?>
  <tr>
	<?php
		$properties = array('id', 'name', 'amount');
		foreach ($properties as $prop) {?>
			<td>
				<?=$c->$prop?>
			</td>
		<?php }
	?>
	<td>
		<button  value="<?=base64_encode(serialize($c))?>" name="add"/>Add amount used</button>
	</td>
	<td>
		<button  value="<?=base64_encode(serialize($c))?>" name="view"/>View amount Used</button>
	</td>
	<td>
		<button  value="<?=base64_encode(serialize($c))?>" name="edit"/>edit</button>
	</td>
	<td>
		<button  value="<?=base64_encode(serialize($c))?>" name="delete"/>delete</button>
	</td>
	</tr>
  <?php
}
?>
		<p>
			<input type="submit" name="back" value="Back" />
			<input type="submit" name="logout" value="Logout" />
		</p>
</form>
</div>

<?php 
}
?>
   
</body>
</html> 
