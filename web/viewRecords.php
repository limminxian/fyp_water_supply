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
	  $("#nav-placeholder").load("navBarComp.php");
	});
	</script>
</head>
<body>
<?php 
include_once 'userClass.php';
$_SESSION["page"]="viewRecords";
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
 ?>
	<form method="post" action="">
		<select name="type" id="type" onchange="this.form.submit()">
		<?php
		$type = array("newsub","area","maintenance","revenue");
		foreach($type as $t){
		?>
			<option value=<?=$t?>><?=$t?></option>
		<?php
		}
		?>
		</select>
	</form>
<?php
$dataPoints = array(
	array("label"=> 'Jan', "y"=> 41),
	array("label"=> 'Feb', "y"=> 35),
	array("label"=> 'Mar', "y"=> 50),
	array("label"=> 'Apr', "y"=> 45),
	array("label"=> 'May', "y"=> 52),
	array("label"=> 'Jun', "y"=> 68),
	array("label"=> 'Jul', "y"=> 38),
	array("label"=> 'Aug', "y"=> 71),
	array("label"=> 'Sep', "y"=> 52),
	array("label"=> 'Oct', "y"=> 60),
	array("label"=> 'Nov', "y"=> 36),
	array("label"=> 'Dec', "y"=> 49)
);
	
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "New subscribers count in 2022"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
         <?PHP
}
?>
   
</body>
</html> 
