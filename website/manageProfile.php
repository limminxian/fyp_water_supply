<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
	<div id="nav-placeholder">
	</div>

<script src="https://app.simplefileupload.com/buckets/896d1e5895f04667e26b254f89f9b3bc.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script>
	$(function(){
	  $("#nav-placeholder").load("navBarComp.php");
	});
	</script>
</head>
<body>
<?php 
include_once 'userClass.php';
$_SESSION["page"]="uploadLogo";
if(!isset($_SESSION['loginId'])){
	echo "Not allowed! Please login!";
	?>
	
<br><br><input type="button" onclick="window.location.href='login.php';" value="Login" />

<?php

} 
else{
	$a = new Company();
	$p = $a->displayProfileImage($_SESSION["loginId"]);
	if(isset($_POST["logout"])){
		unset($_SESSION["loginId"]);
		header("Location: login.php");
	}
	
	if (isset($_POST['submit'])) {
		$file = $_POST["avatar_url"];
		var_dump($file);
		$result = $a->savePhotoFile($file,$_SESSION["loginId"]);
		header("Location: ".$_SERVER['PHP_SELF']);
	}
?>
<br>


  <form action="" method="post"  class="formcontainer" enctype="multipart/form-data">
	Profile photos: <br>
	<?php
	if($p==""){
	?>
	<img src="companylogos/imgnotfound.jpg" height="100">
	<?php
	}
	else{
		?>
		<img src="<?=$p?>" height="100">
		<?php
	}
	?>
<input type="file" name="avatar_url" id="avatar_url" class="simple-file-upload" data-accepted=".jpg,.png">

	<br>
	<input class="formbutton" type="submit" name="submit" value="Submit" />
</form>
<?php
}
?>
<script>
 function checkFile(){
	var filename = document.getElementById("fileToUpload").value;
	var parts = filename.split('.');
	var ext = parts[parts.length - 1];
	switch (ext.toLowerCase()) {
    case 'jpg':
    case 'png':
		document.getElementById("fileToUpload").setCustomValidity('');
		break;
	default:
		document.getElementById("fileToUpload").setCustomValidity("Please upload a png or jpg file");
	}
 }
</script> 
</body>
</html> 
