<?php
session_start();
?>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="home.css">
	<title>Welcome to CLOUDU</title>
</head>

<body>
<div class="slideshow-block" style ="width:70%;padding:0;margin:0;height:90%">
<!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides fade">
    <div class="numbertext">1 / 3</div>
    <!-- <img src="img1.jpg" style="width:100%"> -->
    <div class="text">Caption Text</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 3</div>
    <!-- <img src="img2.jpg" style="width:100%"> -->
    <div class="text">Caption Two</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">3 / 3</div>
    <!-- <img src="img3.jpg" style="width:100%"> -->
    <div class="text">Caption Three</div>
  </div>

  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
	</div>
	<br>

	<!-- The dots/circles -->
	<div style="text-align:center">
	  <span class="dot" onclick="currentSlide(1)"></span>
	  <span class="dot" onclick="currentSlide(2)"></span>
	  <span class="dot" onclick="currentSlide(3)"></span>
	</div>
	</div>
	<div style="position:absolute; top: 0; right:20px;width:30%; height:90%; padding:0">
		<form action="template.html" method="post">
  		<table>
			<tr>
				<td><label for="username">Username:</label></td>
				<td><input type="text" name="username" id="username"
					      value="" 
					      placeholder ="Enter username"></td>
			</tr>
			<tr>
				<td><label for="password">Password:</label></td>
				<td><input type="password" name="password" id="password"
					      value=""
					      placeholder ="Enter password"></td>
		    </tr>
		    <br>
		    <tr>
		    	<td><input type="submit" value="Login" ></td>
		    	<td><input type="submit" formaction="register.php" value="Register as New User" method="post"></td>
		    </tr>
		</table>
		</form>
	</div>
</body>

<script type="text/javascript">
	var slideIndex = 1;
	showSlides(slideIndex);

	// Next/previous controls
	function plusSlides(n) {
	  showSlides(slideIndex += n);
	}

	// Thumbnail image controls
	function currentSlide(n) {
	  showSlides(slideIndex = n);
	}

	function showSlides(n) {
	  var i;
	  var slides = document.getElementsByClassName("mySlides");
	  var dots = document.getElementsByClassName("dot");
	  if (n > slides.length) {slideIndex = 1}
	  if (n < 1) {slideIndex = slides.length}
	  for (i = 0; i < slides.length; i++) {
	      slides[i].style.display = "none";
	  }
	  for (i = 0; i < dots.length; i++) {
	      dots[i].className = dots[i].className.replace(" active", "");
	  }
	  slides[slideIndex-1].style.display = "block";
	  dots[slideIndex-1].className += " active";
	}

</script>
<footer>
	<?php

	$curl = curl_init();
	$URL = "https://zenquotes.io/api/random";
	curl_setopt($curl, CURLOPT_URL, $URL);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
	//	echo $response;
	}

	$response = json_decode($response, true);

	$_SESSION["quote"] = $response[0]['q'];
	$_SESSION["person"] = $response[0]['a'];

	echo ("<br>" . $_SESSION["quote"] . "<br> -" . $_SESSION["person"]);

	?>

</footer>