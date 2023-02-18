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
  $("#nav-placeholder").load("navBarCust.php");
});
</script>
</head>
<body>
<?php 
include_once 'userClass.php';
$_SESSION["page"]="customerservice";
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
<br>

<table>
 <tr bgcolor="#488AC7">
    <th>ID</th>
    <th>Name</th>
    <th>Date</th>
    <th>Service Type</th>
    <th>Status</th>
    <th></th>
  </tr>	
  <form action="" method="post">
<?php
foreach($ticket->ticketArray as $t){
	?>
  <tr>
	<?php
		$properties = array('id', 'name', 'createdate', 'type', 'status');
		foreach ($properties as $prop) {?>
			<td>
				<?=$t->$prop?>
			</td>
		<?php }
	?>
	<td>
		<center>
		<button  value="<?=base64_encode(serialize($t))?>" class="edit"name="view"/>View</button>
	  </center>
	</td>
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
