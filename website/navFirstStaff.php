<div class="topnav">
	<?php
	session_start();
	?>
	<a <?php if(strcmp($_SESSION["page"],'companyAdmin')==0) { ?> class="active" <?php }  ?> href='companyAdmin.php'>Manage Account</a>
	<a <?php if(strcmp($_SESSION["page"],'viewRecords')==0) { ?> class="active" <?php }  ?>href='viewRecords.php'>View Records</a>
	<a <?php if(strcmp($_SESSION["page"],'createRole')==0) { ?> class="active" <?php }  ?> href='serviceRates.php'>Service Rates</a>
	<div class="topnav-right">
		<form action="" method="post">
			<input class="logoutbutton" type="submit" name="logout" value="Logout" />
		</form>
	</div>
</div>