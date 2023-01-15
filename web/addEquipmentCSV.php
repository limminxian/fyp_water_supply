<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>
<body>

<?php 
include_once 'userClass.php';
$_SESSION["page"]="viewEquipment";
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
    <div id="wrap">
        <div class="container">
            <div class="row">
                <form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
                        <!-- Form Name -->
                        <legend>Form Name</legend>
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
	<?php 
	$e= new EquipmentStock();
	if(isset($_POST["Import"])){
		$filename=$_FILES["file"]["tmp_name"];  
		
		if($_FILES["file"]["size"] > 0)
		{
			$file = fopen($filename, "r");
				while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
				{
					//var_dump($getData);
					$e->addEquipmentStock(array("type"=>$_SESSION["equiptype"]->id,"serial"=>$getData[0]));
				 
			if(isset($_SESSION["errorAddStock"]))
			{
				echo "<script type=\"text/javascript\">
				  alert(\"Invalid File:Please Upload CSV File.\");
				  window.location = \"viewEquipmentStock.php\"
				  </script>";  
			}
			else {
				echo "<script type=\"text/javascript\">
				alert(\"CSV File has been successfully Imported.\");
				window.location = \"viewEquipmentStock.php\"
			  </script>";
			}
			   }
		  
				fclose($file);  
		}
	}
}
?>
</body>
</html>