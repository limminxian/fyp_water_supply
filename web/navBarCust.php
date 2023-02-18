<div class="topnav">
	<?php
	session_start();
	?>
	<!--a <?php if(strcmp($_SESSION["page"],'ticketType')==0) { ?> class="active" <?php }  ?>href='ticketType.php'>Ticket Type</a-->
	<a <?php if(strcmp($_SESSION["page"],'customerservice')==0) { ?> class="active" <?php }  ?> href='customerservice.php'>View Ticket</a>
	<a <?php if(strcmp($_SESSION["page"],'manageHomeownerProfile')==0) { ?> class="active" <?php }  ?>href='manageHomeownerProfile.php'>Manage Homeowner Profile</a>
	<div class="topnav-right">
		<form action="" method="post">
			<input class="logoutbutton" type="submit" name="logout" value="Logout" />
		</form>
	</div>
</div>