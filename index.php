<!DOCTYPE html>
<html>
<head>
<?php
include_once 'userClass.php';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

<link rel="stylesheet" href="style.css">
<div id="nav-placeholder">
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
$(function(){
  $("#nav-placeholder").load("navBarIndex.php");
});
</script>


<div class="slideshow-container">

<div class="bannerSlides fade">
  <img src="img/homeslider1.png" class="slides" style="width:100%">
</div>

<div class="bannerSlides fade">
  <img src="img/homeslider2.png" class="slides" style="width:100%">
</div>

<div class="bannerSlides fade">
  <img src="img/homeslider3.png" class="slides" style="width:100%">
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

<h2>Top rating company</h2>

<div class="row">
<?php
	$company = new DataManager();
	$company->getTopCompany(3);
	foreach($company->topCompanyArray as $c){
?>
		<div class="column">
			<div class="card">
				<img src="img/business<?=$c->id?>.jpg" class="companyphoto" >
				<div class="container">
					<h2><?=$c->compName?></h2>
					<?php
					for($i=1;$i<=5;$i++){
						if($c->noofstar < $i){
							if(is_float($c->noofstar)&& (round($c->noofstar)==$i)){
							?>
								<img src="img/halfstar.png" class="star">
							<?php
							}else{
							?>
								<img src="img/emptystar.png" class="star">
							<?php
							}
						}else{
							?>
								<img src="img/star.png" class="star">
							<?php
						}
					}
					?>
					<p class="rating"><?=$c->noofrate?> subsribers</p>
					<p><?=$c->description?></p>
					<p><button class="button" name="learn">Learn more</button></p>
				</div>
			</div>
		</div>
<?php
	}
?>
</div>
<br>
<div class="aboutContainer">
  <img src="img/homeAboutBack.jpg" style="width:100%;" class="about">
  <div class="text-block">
    <h2>Who we are</h2>
    <p>Get to know more about our company</p>
	<p><button class="button" name="read">Read more</button></p>
  </div>
</div>

<br>

<div class="slideshow-container">
<h2>What they say about us</h2>

<div class="reviewSlides fade">
	<div class="review">
		<div class="card">
			<img src="img/business<?=$c->id?>.jpg" class="companyphoto" >
			<div class="container">
				<h2><?=$c->compName?></h2>
				<?php
				foreach(range(1,$c->noofstar) as $a){
				?>
					<img src="img/star.png" class="star">
				<?php
				}
				?>
				<p class="rating"><?=$c->noofrate?> subsribers</p>
				<p><?=$c->description?></p>
				<p><button class="button" name="learn">Learn more</button></p>
			</div>
		</div>
	</div>
</div>

<div class="reviewSlides fade">
	<div class="review">
		<div class="card">
			<img src="img/business<?=$c->id?>.jpg" class="companyphoto" >
			<div class="container">
				<h2><?=$c->compName?></h2>
				<?php
				foreach(range(1,$c->noofstar) as $a){
				?>
					<img src="img/star.png" class="star">
				<?php
				}
				?>
				<p class="rating"><?=$c->noofrate?> subsribers</p>
				<p><?=$c->description?></p>
				<p><button class="button" name="learn">Learn more</button></p>
			</div>
		</div>
	</div>
</div>

<div class="reviewSlides fade">
	<div class="review">
		<div class="card">
			<img src="img/business<?=$c->id?>.jpg" class="companyphoto" >
			<div class="container">
				<h2><?=$c->compName?></h2>
				<?php
				foreach(range(1,$c->noofstar) as $a){
				?>
					<img src="img/star.png" class="star">
				<?php
				}
				?>
				<p class="rating"><?=$c->noofrate?> subsribers</p>
				<p><?=$c->description?></p>
				<p><button class="button" name="learn">Learn more</button></p>
			</div>
		</div>
	</div>
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>

<script>
let slideIndex = 0;
showBannerSlides();
showReviewSlides();

function showBannerSlides() {
  let i;
  let slides = document.getElementsByClassName("bannerSlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showBannerSlides, 5000); // Change image every 2 seconds
}

function showReviewSlides() {
  let i;
  let slides = document.getElementsByClassName("reviewSlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}   
  slides[slideIndex-1].style.display = "block";  
  setTimeout(showReviewSlides, 5000); // Change image every 2 seconds
}
</script>
</body>
</html>


