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
  $("#nav-placeholder").load("navBarSuper.php");
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

	$company = $_SESSION["company"];
	$status = array("PENDING","ACTIVE","SUSPEND");
	$prop = array("id","name","number","email","street","postalcode","description","noofstar");
	foreach($company as $key=>$value){
		if(in_array($key,$prop)){
			echo "<p>".$key. ": " .$value."</p>";
		}
		else if(strcmp($key, "status")==0){?>
					<p><?=$key?>: 
			<form method="post" action="">
				<select name="status" id="status" onchange="this.form.submit()">
				<?php
				foreach($status as $t){
					if(strcmp($t,$value)==0){
						?>
						  <option value=<?=$value?> selected="selected"><?=$value?></option>
						<?php
					}
					else{
						?>
							<option value=<?=$t?>><?=$t?></option>
							<?php
					}
				}
			?>
				</select>
			</form>
			<?php
		}
	}
	
	if(isset($_POST["status"])){
		$company->changeStatus($_POST["status"]);
		unset($_POST);
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
	}
	
	if(isset($_POST["logout"])){
		unset($_SESSION["loginId"]);
		header("Location: login.php");
	}
	
}
?>
   
</body>
</html> 
