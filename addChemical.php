
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
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$amount = $_POST['amount'];
	$c = new Chemical();
	$c->addChemical(array("name"=>$name,"amount"=>$amount));
	header("Location: technician.php");
}
  

?>

<div >
<form action="" method="post" >


 
Name: <input type="text" name="name" placeholder="Name" required ><br>
Amount: <input type="number" name="amount" placeholder="Amount" required ><br>


<input type="submit" name="submit" value="Submit" />&nbsp;&nbsp;

</form>

</div>
</body>
</html>