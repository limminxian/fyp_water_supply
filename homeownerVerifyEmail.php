<style>
@import url('https://fonts.googleapis.com/css?family=Raleway:200');

$BaseBG: #ffffff;

body,
html {
  height: 100%;
  margin: 0;
  font-family: 'Raleway', sans-serif;
  font-weight: 200;
}

body {
  background-color: $BaseBG;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.digit-group input {
    width: 60px;
    height: 60px;
    background-color: lighten($BaseBG, 5%);
    border: none;
    line-height: 50px;
    text-align: center;
    font-size: 24px;
    font-family: 'Raleway', sans-serif;
    font-weight: 800;
    color: black;
    margin: 0 2px;
    border-radius: 18px;
    border: 1px solid #d3d3d3;
  }

.prompt {
  margin-bottom: 20px;
  font-size: 20px;
  color: white;
}

::-webkit-input-placeholder {
  /* Edge */
  font-weight: 800;
  color: #9c9a9a;
}

:-ms-input-placeholder {
  /* Internet Explorer */
  font-weight: 800;
  color: #9c9a9a;
}

::placeholder {
  font-weight: 900;
  color: #9c9a9a;
}

.error{
  padding: 20px;
  background-color: #D91D1D; /* red */
  color: white;
  -moz-animation: cssAnimation 0s ease-in 2s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 2s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 2s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 2s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

.success {
  padding: 20px;
  background-color: #83FF9F; /* light green */
  color: black;
  -moz-animation: cssAnimation 0s ease-in 3s forwards;
    /* Firefox */
    -webkit-animation: cssAnimation 0s ease-in 3s forwards;
    /* Safari and Chrome */
    -o-animation: cssAnimation 0s ease-in 3s forwards;
    /* Opera */
    animation: cssAnimation 0s ease-in 3s forwards;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@keyframes cssAnimation {
    to {
        width:0;
        height:0;
        overflow:hidden;
		padding: 0;
    }
}
@-webkit-keyframes cssAnimation {
    to {
        width:0;
        height:0;
        visibility:hidden;
		padding: 0;
    }
}

</style>

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
		$a->resendCode();
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
<br>Did not receive code? <input type="submit" name="resend" value="Resend code" />
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