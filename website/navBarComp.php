<div class="topnav">
	<?php
	session_start();
	?>
	<a <?php if(strcmp($_SESSION["page"],'companyadmin')==0) { ?> class="active" <?php }  ?> href='companyadmin.php'>Manage Account</a>
	<a <?php if(strcmp($_SESSION["page"],'viewRecords')==0) { ?> class="active" <?php }  ?>href='viewRecords.php'>View Records</a>
	<a <?php if(strcmp($_SESSION["page"],'manageServiceCompany')==0) { ?> class="active" <?php }  ?> href='manageServiceCompanyadmin.php'>Service Type</a>	
	<a <?php if(strcmp($_SESSION["page"],'uploadLogo')==0) { ?> class="active" <?php }  ?> href='manageProfile.php'>Upload Profile Photo</a>
	<div class="topnav-right">
		<form action="" method="post">
			<input class="logoutbutton" type="submit" name="logout" value="Logout" />
		</form>
	</div>
</div>