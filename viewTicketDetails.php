<html>
	<style>
	* {
    margin: 0;
    padding: 0;
  }
   
  body {
    margin: 20px auto;
    font-family: "Lato";
    font-weight: 300;
  }
   
  form {
    padding: 15px 25px;
    display: flex;
    gap: 10px;
    justify-content: center;
  }
   
  form label {
    font-size: 1.5rem;
    font-weight: bold;
  }
   
  input {
    font-family: "Lato";
  }
   
  a {
    color: #0000ff;
    text-decoration: none;
  }
   
  a:hover {
    text-decoration: underline;
  }
   
  #wrapper {
    margin: 0 auto;
    padding-bottom: 20px;
    background: #eee;
    width: 600px;
    max-width: 100%;
    border: 2px solid #212121;
    border-radius: 4px;
  }
   
  #chatbox {
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: #fff;
    height: 200px;
    width: 530px;
    border: 1px solid #a7a7a7;
    overflow: auto;
    border-radius: 4px;
    border-bottom: 4px solid #a7a7a7;
  }
   
  #usermsg {
    flex: 1;
    border-radius: 4px;
    border: 1px solid #ff9800;
  }
   
  #name {
    border-radius: 4px;
    border: 1px solid #ff9800;
    padding: 2px 8px;
  }
   
  #submit,
  #enter{
    background: #ff9800;
    border: 2px solid #e65100;
    color: white;
    padding: 4px 10px;
    font-weight: bold;
    border-radius: 4px;
  }
   
  .error {
    color: #ff0000;
  }
   
  #menu {
    padding: 15px 25px;
    display: flex;
  }
   
  #menu p.chat {
    flex: 1;
  }
   
  a#exit {
    color: white;
    background: #c62828;
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: bold;
  }
   
  .msgln {
    margin: 0 0 5px 0;
  }
   
  .msgln span.left-info {
    color: orangered;
  }
   
  .msgln span.chat-time {
    color: #666;
    font-size: 60%;
    vertical-align: super;
  }
   
  .msgln b.user-name, .msgln b.user-name-left {
    font-weight: bold;
    background: #546e7a;
    color: white;
    padding: 2px 4px;
    font-size: 90%;
    border-radius: 4px;
    margin: 0 5px 0 0;
  }
   
  .msgln b.user-name-left {
    background: orangered;
  }
	</style>
	<?php
		include_once 'userClass.php';
		?>
		<form action="" method="post">
			<input type="submit" name="logout" value="Logout" />
		</form>
		<?php
		$ticket = $_SESSION["ticket"];
		//type of ticket
		// $type = new Tickettype;
		// $type->getAllTicketType();
		$type = array("others","maintenance","payment","installation");
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
    <head>
        <meta charset="utf-8" />
 
        <title>Tuts+ Chat Application</title>
        <meta name="description" content="Tuts+ Chat Application" />
    </head>
    <body>
	
		<form action="" method="post">
				<?php
				// $ticettype = new Tickettype();
				
				if(in_array($ticket->type,array("maintenance","installation"))){
				?>
					<input type="submit" id="aprvTech" value="Approve to Technician" name="submit"/>
				<?php
				}
				else{
				?>
					<input type="submit" value="Close Ticket" name="close""/>
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
 
            <form action="" method="post">
                <input name="usermsg" type="text" id="usermsg" />
				<input type="submit" id="submit" value="Send" name="submit"/>
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