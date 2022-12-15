<div class="topnav">
	<?php
	session_start();
	?>
	<a <?php if(strcmp($_SESSION["page"],'superadmin')==0) { ?> class="active" <?php }  ?> href='superadmin.php'>Manage Account</a>
	<a <?php if(strcmp($_SESSION["page"],'manageCompanyRequest')==0) { ?> class="active" <?php }  ?>href='manageCompanyRequest.php'>Company Request</a>
	<a <?php if(strcmp($_SESSION["page"],'manageRole')==0) { ?> class="active" <?php }  ?> href='manageRole.php'>Role Management</a>
	<a <?php if(strcmp($_SESSION["page"],'')==0) { ?> class="active" <?php }  ?> href='manageRole.php'>Service Management</a>
	<div class="topnav-right">
		<form action="" method="post">
			<input class="logoutbutton" type="submit" name="logout" value="Logout" />
		</form>
	</div>
</div>