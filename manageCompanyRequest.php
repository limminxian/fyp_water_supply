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
session_start();
//check token and make sure user do not bypass login
// if(!isset($_SESSION['checkAdmin'])){
	// echo "Not allowed! Please login!";
	// ?>
	
<!--<br><br><input type="button" onclick="window.location.href='login.php';" value="Login" />-->

<?php
// } 
// else{
	//display product

$company = new 	
	
foreach($_SESSION["view"] as $a=>$r){
	echo $a.":".$r."<br>";
}
if(isset($_POST["back"])){
	unset($_SESSION["view"]);
	header("Location: admin.php");
}
?>
<form action="" method="post">
		<p>
			<input type="submit" name="back" value="Back" />
		</p>
</form>
<!-- <?php
// }
// ?>-->
</body>
</html>
