
<?php
include_once 'config.php';
include_once 'userClass.php';
?>

<html>
<title>IT for rent</title> 

  <style>
  .error{
  padding: 20px;
  background-color: #D91D1D; /* red */
  color: white;
  -moz-animation: cssAnimation 0s ease-in 2s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 2s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 2s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 2s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@keyframes cssAnimation {
    to {
        width:0;
        height:0;
        overflow:hidden;
		padding: 0;
    }
}
@-webkit-keyframes cssAnimation {
    to {
        width:0;
        height:0;
        visibility:hidden;
		padding: 0;
    }
}

#homeownerForm {
	display: none;
}
	
#companyForm {
	display: none;
}	

</style>
<h1>Register</h1>
<?php
if(isset($_POST["logout"])){
	unset($_SESSION["loginId"]);
	header("Location: login.php");
}
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$register = $_POST['register'];
	//check role	
	$a = new Role();
	$result = $a->addRole(array("name"=>$name,"description"=>$description,"register"=>$register));

	if(isset($_SESSION["errorAddUser"]))
	{
		$a=strval($_SESSION["errorAddUser"]);
		echo "<div class='error'>" . $a . "</div>" ;
		UNSET($_SESSION["errorAddUser"]);
	}
}
  

?>

<div >
<form action="" method="post" >

 
Name: <input type="text" name="name" placeholder="Name" required ><br>

Description: <input type="text" name="description" placeholder="Description" required ><br>
<br>

Register allow:
<input type="radio" value="TRUE" id="yes" name="register" required>

<label for="yes">Yes</label>

<input type="radio" value="FALSE" id="no" name="register" >
 
 <label for="no">No</label>
 
<br>

<br>
<input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;
<input type="button" onclick="window.location.href='superAdmin.php';" value="Back" />
<input type="submit" name="logout" value="Logout" />

</form>
</script>

</div>
</body>
</html>