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
include_once 'reports.php';
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
	
	
	
	if(isset ($_POST["type"])){
		$_SESSION["type"]=$_POST["type"];
		//header("Location: ".$_SERVER['PHP_SELF']);
	}
	
	$sub=[];
	$unsub=[];
	$cumulative=[];
	$cumulativeEstimation=[];
	$waterEstimation=[];
	$people=[];
	$area=[];
	$revenue=[];
	
	if(isset($_SESSION["type"])){
		switch($_SESSION["type"]){
			case "estimation":
				$s = new CompanyAdmin();
				$company = $s->getCompany($_SESSION["loginId"]);
				$cumulativeEstimation = getCumulativeSubscriptionEstimation($company);
				$waterEstimation = getWaterUsageEstimation($company);
				break;
			case "subscribers":
				$s = new CompanyAdmin();
				$company = $s->getCompany($_SESSION["loginId"]);
				$sub = getSubscription($company)[0];
				$unsub = getSubscription($company)[1];
				$cumulative = getCumulativeSubscription($company);
				break;
			case "people":
				$people = getNoofpeople($_SESSION["loginId"]);
				$area = getArea($_SESSION["loginId"]);				
				break;
			case "revenue":
				$revenue = getRevenue($_SESSION["loginId"]);
				break;
		}
	}
	else{
		$s = new CompanyAdmin();
		$company = $s->getCompany($_SESSION["loginId"]);
		$sub = getSubscription($company)[0];
		$unsub = getSubscription($company)[1];
		$cumulative = getCumulativeSubscription($company);
	}
 ?>
 
	<form method="post" action="">
		<h3>Type of reports:</h3>
		<select name="type" id="type" onchange="this.form.submit();chart();">
			<?php
			$type = array("subscribers","estimation","people","revenue");
			foreach($type as $t){
				if(isset($_SESSION["type"])){
					if(strcmp($_SESSION["type"],$t)==0){
				?>
						<option value=<?=$t?> selected="selected"><?=$t?></option>
				<?php
					}
					else{
						?>
						<option value=<?=$t?>><?=$t?></option>
						<?php
					}
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
<p id="demo"></p>
<script>
function chart() {
	var c = document.getElementById("type").value;
	switch (c){
		case "estimation":
			estimation();
			break;
		case "people":
			people();
			break;
		case "revenue":
			revenue();
			break;
		case "subscribers":
		default:
			subscription();
			break;
	}
	
	function subscription(){
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Subscribe and unsubscribe count in past 12 months"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				name: "Subscribe count",
				indexLabel: "{y}", //Shows y value on all Data Points
				showInLegend: true,
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($sub); ?>
			},{
				type: "column",
				name: "Unsubscribe count",
				indexLabel: "{y}",
				showInLegend: true,
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",  
				dataPoints: <?php echo json_encode($unsub); ?>
			}]
		});
		chart.render();
		  
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}
		
		var chart2 = new CanvasJS.Chart("chartContainer2", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Cumulative subscribers count in past 12 months"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
			},
			data: [{
				type: "column", //change type to bar, line, area, pie, etc
				name: "Subscribe count",
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($cumulative); ?>
			}]
		});
		chart2.render();	
		
	}
	
	function estimation(){
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Subscribe estimation for next 12 months"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "line", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($cumulativeEstimation); ?>
			}]
		});
		chart.render();
		  
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}
		
		var chart2 = new CanvasJS.Chart("chartContainer2", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Water usage estimation for next 12 months"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "line", //change type to bar, line, area, pie, etc
				name: "Subscribe count",
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($waterEstimation); ?>
			}]
		});
		chart2.render();
		  
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart2.render();
		}
	}
	
	function people(){
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light2", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Homeowner no of people in the house"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "pie", //change type to bar, line, area, pie, etc
				name: "Subscribe count",
				legendText: "{label}",
				indexLabel: "{label} - #percent%", //Shows y value on all Data Points
				showInLegend: true,
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($people); ?>
			}]
		});
		chart.render();
		  
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}
		
		var chart2 = new CanvasJS.Chart("chartContainer2", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light2", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Homeowner Area"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "pie", //change type to bar, line, area, pie, etc
				name: "Subscribe count",
				legendText: "{label}",
				indexLabel: "{label} - #percent%", //Shows y value on all Data Points
				showInLegend: true,
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($area); ?>
			}]
		});
		chart2.render();
		  
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart2.render();
		}
	}
	
	function revenue(){
		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light1", // "light1", "light2", "dark1", "dark2"
			title:{
				text: "Revenue for past 12 months"
			},
			legend:{
				cursor: "pointer",
				verticalAlign: "center",
				horizontalAlign: "right",
				itemclick: toggleDataSeries
			},
			data: [{
				type: "line", //change type to bar, line, area, pie, etc
				indexLabel: "{y}", //Shows y value on all Data Points
				indexLabelFontColor: "#5A5757",
				indexLabelPlacement: "outside",   
				dataPoints: <?php echo json_encode($revenue); ?>
			}]
		});
		chart.render();
		  
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}
	}
}
window.onload = function () {chart();};
</script>
<div id="chartContainer"   style="height: 360px; width: 100%;"></div><br><br><br><br>
<div id="chartContainer2"   style="height: 360px; width: 100%;"></div> 
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
         <?PHP
}
?>
   
</body>
</html> 
