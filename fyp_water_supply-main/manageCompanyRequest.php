<html>
<title>IT for rent</title> 
<style>

 h1{ 
     background-color: #78aeff;
     text-align: center; 
     color: #0f2647;
  }
  
  body{
    margin: 0;
    padding: 0;
	vertical-align: middle;
    font-family: sans-serif;
    background-size: cover;
	min-height:100vh;
	width:100%; 
	background-color: edf1f7;
	background-position:center; 
	background-size:cover; position:relative;
	color:  #0f2647;
  }
  
  input[type=button],input[type=submit],button {
	  background-color: #78aeff;
  }
</style>
<body>
<h1>Accept/Reject company page</h1>
<?php

include_once 'userClass.php';

//check token and make sure user do not bypass login
if(!isset($_SESSION['loginId'])){
	echo "Not allowed! Please login!";
	?>
	
<<br><br><input type="button" onclick="window.location.href='login.php';" value="Login" />

<?php

} 
else{

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
}
?>
		<p>
			<input type="submit" name="back" value="Back" />
			<input type="submit" name="logout" value="Logout" />
		</p>
</form>
</body>
<?php }
?>
</html>