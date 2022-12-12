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

if (isset($_POST["view"])){
	$t = unserialize(base64_decode($_POST["view"]));
	$_SESSION["ticket"]=$t;
	header("Location: viewTicketDetails.php");exit();
}

$ticket = new Staff();
$ticket->getAllTicket();
?>
<div class="topnav">
  <a class="active" href="#manage">View ticket</a>
  <a href='manageCompanyRequest.php'>Manage Homeowner Profile</a>
  <form action="post">
	<input type="submit" name="logout" value="Logout" />
	</form>
  
</div>

<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Date</th>
    <th>Service Type</th>
    <th>Status</th>
    <th></th>
	<th></th>
  </tr>	
  <form action="" method="post">
<?php
foreach($ticket->ticketArray as $t){
	?>
  <tr>
	<?php
		$properties = array('id', 'name', 'date', 'type', 'status');
		foreach ($properties as $prop) {?>
			<td>
				<?=$t->$prop?>
			</td>
		<?php }
	?>
	<td>
		<button  value="<?=base64_encode(serialize($t))?>" name="view"/>View</button>
	</td>
  </tr>
  </table>
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
