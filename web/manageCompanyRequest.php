<!DOCTYPE html>
<html>
<title>IT for rent</title> 
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
<h1>Accept/Reject company page</h1>
<?php

include_once 'userClass.php';

//check token and make sure user do not bypass login
if(!isset($_SESSION['loginId'])){
	echo "Not allowed! Please login!";
	?>
	
<br><input type="button" onclick="window.location.href='login.php';" value="Login" />

<?php

} 
else{
$_SESSION["page"]="manageCompanyRequest";
$company = new DataManager();
$company->getAllPendingCompany();
	
if(isset($_POST["back"])){
	unset($_SESSION["view"]);
	header("Location: superadmin.php");
}
	if(isset($_POST["logout"])){
	unset($_SESSION["loginId"]);
	header("Location: login.php");
}
	// var_dump($allCompany);
// foreach($allCompany as $a=>$r){
	// echo $a.":".$r."<br>";
// }

?>
<table>
  <tr>
    <th>Company Admin</th>
    <th>Name</th>
    <th>Number</th>
    <th>Email</th>
    <th>Street</th>
    <th>Postal Code</th>
    <th>Description</th>
    <th>File</th>
    <th></th>
	<th></th>
  </tr>	
<?php
//view button cliked direct to viewProduct.php
if (isset($_POST["accept"])){
	$c = unserialize(base64_decode($_POST["accept"]));
	$c->appRejCompany("ACTIVE");
	header("Refresh:0");
}
if (isset($_POST["reject"])){
	$c = unserialize(base64_decode($_POST["reject"]));
	$c->appRejCompany("REJECT");
	header("Refresh:0");
}
?>
  <form action="" method="post">
<?php
foreach($company->companyArray as $c){
	?>
  <tr>
	<?php
		$properties = array('id', 'name', 'number', 'email', 'street', 'postalcode', 'description');
		foreach ($properties as $prop) {?>
			<td>
				<?=$c->$prop?>
			</td>
		<?php }
		
	?>
	<td>
		<button  value="<?=base64_encode(serialize($c))?>" name="accept"/>Accept</button>
	</td>
	<td>
		<button  value="<?=base64_encode(serialize($c))?>" name="reject"/>Reject</button>
	</td>
  </tr><?php
}?>
</form>
</body>
<?php }
?>
</html>