
 
<!DOCTYPE html>
<html lang="en">
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
   
  #wrapper,
  #loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    background: #eee;
    width: 600px;
    max-width: 100%;
    border: 2px solid #212121;
    border-radius: 4px;
  }
   
  #loginform {
    padding-top: 18px;
    text-align: center;
  }
   
  #loginform p {
    padding: 15px 25px;
    font-size: 1.4rem;
    font-weight: bold;
  }
   
  #chatbox {
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: #fff;
    height: 300px;
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
   
  #menu p.welcome {
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
    <head>
        <meta charset="utf-8" />
 
        <title>Tuts+ Chat Application</title>
        <meta name="description" content="Tuts+ Chat Application" />
        <link rel="stylesheet" href="style.css" />
    </head>
	<?php
		include_once 'userClass.php';

		$ticket = $_SESSION["ticket"];
		foreach($ticket as $key=>$a){
			if(strcmp($key,"chatArray")!=0){
			 echo "<p>".$key. ": " .$a."</p>";
			}
		}
		
		if(isset($_POST['submit'])){
			$text = $_POST['usermsg'];

			$ticket->addChat($text);
			echo '
			<script type="text/javascript">
			$(document).ready(function () {
				var newscrollHeight = $("#chatbox")[0].scrollHeight; //Scroll height after the request
				$("#chatbox").animate({ scrollTop: newscrollHeight }, "normal"); //Autoscroll to bottom of div
			});
			</script>
			';
			unset($_POST['submit']);
		}
		
		$ticket->getAllChat();
		?>
    <body>
		<div id="wrapper">
            <div id="menu">
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
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
                <input name="submit" id="submit" type="submit" value="Send" />
            </form>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
    </body>
</html>