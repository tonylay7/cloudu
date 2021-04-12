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
<div class="slideshow-block" style ="width:70%;padding:0;margin:0;height:90%">
<!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides fade">
  	<img src="cloudu.png" style = "width: 70%; height: 60%;">
  	<br>
    <h1>Welcome to CLOUDU!</h1>
    <h2>"To remind you of what brings you joy"</h2>
  </div>

  <div class="mySlides fade">
    <!-- <img src="img2.jpg" style="width:100%"> -->
    <div class="text">Caption Two</div>
  </div>

  <div class="mySlides fade">
    <!-- <img src="img3.jpg" style="width:100%"> -->
    <div class="text">Caption Three</div>
  </div>

  <div class="mySlides fade">
    <!-- <img src="img3.jpg" style="width:100%"> -->
    <div class="text">Caption Four</div>
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
	<div style="position:absolute; top: 0; right:20px; width:30%; height:90%; padding:0">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  		<table>
  			<tr><td colspan="2"><?php echo $error;?></td></tr>
			<tr>
				<td><label for="username">Username:</label></td>
				<td><input type="text" name="username" id="username"
					      value="<?php echo $username;?>" 
					      placeholder ="Enter username"></td>
			</tr>
			<tr>
				<td><label for="password">Password:</label></td>
				<td><input type="password" name="password" id="password"
					      value="<?php echo $password;?>"
					      placeholder ="Enter password"></td>
		    </tr>
		    <br>
		    <tr>
		    	<td><input type="submit" value="Login" ></td>
		    	<td><button type="submit" formaction="register.php">Register as New User</button></td>
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