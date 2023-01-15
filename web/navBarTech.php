<div class="topnav">
	<?php
	session_start();
	?>
	<a <?php if(strcmp($_SESSION["page"],'technician')==0) { ?> class="active" <?php }  ?> href='technician.php'>View Chemical</a>
	<a <?php if(strcmp($_SESSION["page"],'viewEquipment')==0) { ?> class="active" <?php }  ?>href='viewEquipment.php'>View Equipment</a>
	<a <?php if(strcmp($_SESSION["page"],'downloadTech')==0) { ?> class="active" <?php }  ?>href='downloadTech.php'>Download Technician App</a>
	<div class="topnav-right">
		<form action="" method="post">
			<input class="logoutbutton" type="submit" name="logout" value="Logout" />
		</form>
	</div>
</div>