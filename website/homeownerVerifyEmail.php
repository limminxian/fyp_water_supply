<div id="nav-placeholder">
</div>

<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
$(function(){
  $("#nav-placeholder").load("navBarIndex.php");
});
</script>
	<h1>Verify email</h1>
<div class="center bg-img">
<?php
include_once 'userClass.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$a = new Homeowner();
	$result = $a->verifyEmail(($_POST["digit-1"].$_POST["digit-2"].$_POST["digit-3"].$_POST["digit-4"].$_POST["digit-5"].$_POST["digit-6"]));
	if($result){
		echo "<div class='success'> Validate successful redirecting in 3 second </div>" ;
		header( "refresh:3;url=homeowner.php" );
	}
	else{
		echo "<div class='error'> Wrong code, code resent </div>";
		$email = $a->getEmail($_SESSION["loginId"]);
		$a->resendCode($email);
	}
}
?>
<p>Please enter the code that has been sent to your email.
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<form method="post" id="form" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
  <input type="text" id="digit-1" name="digit-1" data-next="digit-2" placeholder="-"/>
  <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" placeholder="-"/>
  <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" placeholder="-"/>
  <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" placeholder="-"/>
  <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" placeholder="-"/>
  <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" placeholder="-"/>
</form>

<form action="" method="post">
<br>Did not receive code? <input type="submit" name="resend"class="edit" value="Resend code" />
</form>
<script>

$(".digit-group")
	.find("input")
	.each(function () {
		$(this).attr("maxlength", 1);
		$(this).on("keyup", function (e) {
			var parent = $($(this).parent());

			if (!e.shiftKey && (e.which === 8|| e.which === 46 || e.which === 37)) {
				
				var prev = parent.find("input#" + $(this).data("previous"));

				if (prev.length) {
					$(prev).select();
				}
			} else if (!e.shiftKey && (
				(e.which >= 48 && e.which <= 57)||
				(e.which >= 96 && e.which <= 105)|| 
				e.which === 39			
			) ){
				var next = parent.find("input#" + $(this).data("next"));

				if (next.length) {
					$(next).select();
				} else {
					parent.submit();
				}
			}
			else{
				$(this).val("");
			}
		});
	});

</script>
