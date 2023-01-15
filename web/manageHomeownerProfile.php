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
  $("#nav-placeholder").load("navBarCUst.php");
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
	
$_SESSION["page"]="manageHomeownerProfile";

$company = new Company();
$staff = new Staff();
$companyId=$staff->getCompany($_SESSION["loginId"]);
$company->getAllHomeowner($companyId);
?>

<form action="" method="post">
		<input type="text" name="searchtext" placeholder="use space for multiple string" value="<?php if (isset($_SESSION["search"])) echo $_SESSION["search"] ;?>" />
		<input type="submit" name="search" value="search" />
	</form>
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

<?php 
}
?>
   
</body>
</html> 
