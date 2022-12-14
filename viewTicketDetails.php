<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
 
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="style.css">
		<div id="nav-placeholder">
		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script>
		$(function(){
		  $("#nav-placeholder").load("navBarCust.php");
		});
		</script>
    </head>
	<?php
		include_once 'userClass.php';
		$_SESSION["page"]="customerservice";
		$ticket = $_SESSION["ticket"];
		//type of ticket
		// $type = new Tickettype;
		// $type->getAllTicketType();
		$type = array("others","maintenance","payment","installation");
		?>
		<div class="formcontainer">
		<?php
		foreach($ticket as $key=>$a){
			if(strcmp($key,"type")==0){
				?>
				<p><?=$key?>: 
				<form method="post" action="">
					<select name="type" id="type" onchange="this.form.submit()">
					<?php
					foreach($type as $t){
						if(strcmp($t,$a)==0){
							?>
							  <option value=<?=$a?> selected="selected"><?=$a?></option>
							<?php
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
				<?php
			}
			else if(strcmp($key,"chatArray")!=0){
				echo "<p>".$key. ": " .$a."</p>";
			}
		}
		?>
		</div>
		<?php
		if(isset($_POST["type"])){
			$ticket->changeType($_POST["type"]);
			unset($_POST);
			header("Location: ".$_SERVER['PHP_SELF']);
			exit;
		}
		
		if(isset($_POST["logout"])){
			unset($_SESSION["loginId"]);
			header("Location: login.php");
		}
		
		if(isset($_POST["submit"])){
			$_SESSION['postdata'] = $_POST['usermsg'];
			unset($_POST);
			header("Location: ".$_SERVER['PHP_SELF']);
			exit;
		}

		if(isset($_POST["close"])){
			$ticket->closeTicket();
			unset($_POST);
			header("Location: customerservice.php");
			exit;
		}

		if (array_key_exists('postdata', $_SESSION)) {
			$text = $_SESSION['postdata'];
			$ticket->addChat($text);
			unset($_SESSION['postdata']);
		}
		
		$ticket->getAllChat();
	?>
    <body>
	
		<form action="" method="post" class="formcontainer">
				<?php
				// $ticettype = new Tickettype();
				
				if(in_array($ticket->type,array("maintenance","installation"))){
				?>
					<input  class="formbutton" type="submit" id="aprvTech" value="Approve to Technician" name="submit"/>
				<?php
				}
				else{
				?>
					<input  class="formbutton" type="submit" value="Close Ticket" name="close""/>
				<?php
				}
				?>
        </form>
			
		<div id="wrapper">
            <div id="menu">
            </div>
 
            <div id="chatbox">
			<?php
			foreach($ticket->chatArray as $t){
			?>
			<div class='msgln'><span class='chat-time'>
			<?php
				echo $t->date;
			?>
			</span> <b class='user-name'>
			<?php 
				echo $t->name;
			?>
			</b>
			<?php
				echo $t->text;
			?>			
			<br></div>
			<?php
			}
			?>
            </div>
 
            <form class="replyTicket" action="" method="post">
                <input class="replyInput" name="usermsg" type="text" id="usermsg" />
				<input class="replyInput" type="submit" id="submit" value="Send" name="submit"/>
            </form>
        </div>
		
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			var newscrollHeight = $("#chatbox")[0].scrollHeight; 
			$("#chatbox").animate({ scrollTop: newscrollHeight }, "normal"); //Autoscroll to bottom of div
		});
		</script>
    </body>
</html>