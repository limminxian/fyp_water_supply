<div class="topnav">
	<?php
	session_start();
	?>
	<a <?php if(strcmp($_SESSION["page"],'superadmin')==0) { ?> class="active" <?php }  ?> href='superadmin.php'>Manage Account</a>
	<a <?php if(strcmp($_SESSION["page"],'manageCompanyRequest')==0) { ?> class="active" <?php }  ?>href='manageCompanyRequest.php'>Company Request</a>
	<a <?php if(strcmp($_SESSION["page"],'createRole')==0) { ?> class="active" <?php }  ?> href='createRole.php'>Create Role</a>
	<a <?php if(strcmp($_SESSION["page"],'createTickteType')==0) { ?> class="active" <?php }  ?> href='createTickteType.php'>Create Ticket Type</a>
	<div class="topnav-right">
		<form action="" method="post">
			<input class="logoutbutton" type="submit" name="logout" value="Logout" />
		</form>
	</div>
</div>