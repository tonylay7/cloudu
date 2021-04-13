<?php
session_start();
?>

<?php
  $database_host = "dbhost.cs.man.ac.uk";
  $database_user = "n00575sm";
  $database_pass = "Mozzer_2310";
  $database_name = "2020_comp10120_x6";

  $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);
  
  if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
  }
?>

<?php

  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }

  $username = $password = $error = "";

	if (isset($_POST["username"])) 
	{	
		$stmt = $conn->prepare("SELECT `id`,`email`, `password` FROM `users` WHERE `username`= ?");
		$stmt->bind_param('s', $username);

		$username = test_input($_POST["username"]);
  		$password = test_input($_POST["password"]);
  		$stmt->execute();

		$result = $stmt->get_result();

		if($result->num_rows == 0) {
			$error = "Username does not exist.";
		}
		else{
		    while($row = $result->fetch_assoc())
		    {	
		    	$user_password = $row['password'];
		    	$salt = substr($user_password, -4);
				$hash = substr($user_password, 0, -4);

		    	if (hash('sha512', $password . $salt) == $hash){
		    		$_SESSION["user_id"] = $row['id'];
		    		$_SESSION["username"] = $row['username'];
					header('Location: WordCloud.php');
				}
				else{
					$error = "Password is incorrect";
				}
		    }
		}
	}

?>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="home.css">
	<title>Welcome to CLOUDU</title>
</head>

<body>
<div class="slideshow-block">
<!-- Slideshow container -->
  <div class="slideshow-container">
	  <div class="mySlides fade">
	  	<img class="welcome" src="images/cloudu_white.svg">
	  	<br>
	    <h1 class="welcome text">Welcome to CLOUDU!</h1>
	  </div>

	  <div class="mySlides fade">
	    <img src="images/wordcloud_sample.jpg">
	    <h1 class="slide text">Word Cloud</h1>
	    <p class="slide text">Studies show that gratitude journaling is one of the best ways to improve your mental health and happiness levels!</p>
	    <br>
		<p class="slide text">We use a word cloud to show you what makes you grateful and happy. The more you like something, the bigger it will appear. Just type in something that makes you happy every day and we'll do the rest!</p>
	  </div>

	  <div class="mySlides fade">
	    <!-- insert image of diary and mood tracker -->
	    <img src="images/wordcloud_sample.jpg">
	    <h1 class="slide text">Diary and Mood Tracker</h1>
	    <p class="slide text">Our website also has a diary for your daily thoughts and happiness level.</p>
		<p class="slide text">This enables your very own mood tracker! You can use it to look for patterns in your mood over time.</p>
	  </div>

	  <div class="mySlides fade">
	  	<div class="lastslide">
	      <h1 class="slide text">About Us</h1>
	      <p class="slide text">We are a group of students who made this web application with the aim of empowering people with tools for emotional management and remind you every day of what brings you joy.</p>
          <br>
	      <br>
	      <h1 class="slide text">Contact Us</h1>
	      <p class="slide text">If you have any questions, suggestions, or complaints, please drop us an email at [insert smth here or google form?].</p>
	    </div>
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
	  <span class="dot" onclick="currentSlide(4)"></span>
	</div>
</div>
	<div class="form" style="">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  			<h1 class="text" style="padding-bottom: 30px; font-size: 40px; padding-top: 20px;">Login</h2>
  			<?php echo $error;?>
			<label for="username"><p class = "text">Username</p></label>
			<input type="text" name="username" id="username" value="<?php echo $username;?>">
			<br>
			<br>
			<label for="password"><p class = "text">Password</p></label>
			<input type="password" name="password" id="password" value="<?php echo $password;?>">
			<br>
			<br>
			<br>
		    <input type="submit" value="Login">
		    <p class="text" style="text-align: center">or</p>
		    <button type="submit" formaction="register.php">Register as New User</button></tr>
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

	echo ("<br><p class=\"text\">" . $_SESSION["quote"] . "</p><br><p class=\"text\"> -" . $_SESSION["person"] . "</p>");

	?>

</footer>