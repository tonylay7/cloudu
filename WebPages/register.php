<?php
  $database_host = "dbhost.cs.man.ac.uk";
  $database_user = "n00575sm";
  $database_pass = "Mozzer_2310";
  $database_name = "2020_comp10120_x6";

  $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);
  
  if (!$conn){
    die("connection failed: " . mysqli_connect_error());
  }
?>

<?php
// define variables and set to empty values
$username = $email = $confirm = $password = $error="";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function checkdb($username, $email, $password){
	global $conn;
	global $error;

	$stmt = $conn->prepare("SELECT email, username FROM users WHERE username=? OR email=?");
	$stmt->bind_param('ss', $username, $email);
	$stmt->execute();
	$result = $stmt->get_result();

	// $sql = "SELECT `email`, `username` FROM `users` WHERE `username`='".$username."' OR `email`='".$email."'";
	// $result = $conn->query($sql);

	if($result->num_rows >= 1) {
	    while($row = $result->fetch_assoc())
	    {
	    	if($email==$row['email']){
	    		$error = "E-mail already in use";
	    	}
	    	if($username==$row['username']){
				$error = "Username already exists";
			}
	    }
	}
	else{
		$salt = str_pad((string) rand(1, 1000), 4, '0', STR_PAD_LEFT);
		$user_password = hash('sha512', $password . $salt) . $salt;
		$stmt = $conn->prepare("INSERT INTO users (username, email, password)VALUES (?, ?, ?)");
		$stmt->bind_param('sss', $username, $email, $user_password);

		if ($stmt->execute()) {
	  		$_SESSION["user_id"] = $row['id'];
		    $_SESSION["username"] = $row['username'];
			header('Location: Help.html');
		} else {
		  echo "Error: " . $conn->error;
		}
  	}

}

if (isset($_POST["confirm"])) {
  $username = test_input($_POST["username"]);
  $password = test_input($_POST["password"]);

  $confirm = test_input($_POST["confirm"]);
  $email = test_input($_POST["email"]);

  if (strlen($username)<5) {
  	$error = "Username should be at least 5 characters";
  }
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  	$error = "Invalid email format";
  }
  else if (strlen($password)<8) {
  	$error = "Password should be at least 8 characters";
  }
  else if ($password != $confirm){
	$error = "Password does not match";
  }
  else{
  	checkdb($username, $email, $password);
  }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href= "home.css" rel="stylesheet" type="text/css">
		<title>Register for CLOUDU</title>
	</head>

	<body>
	  <ul>
        <li><h1 class ="register">Welcome to</h1></li>
        <li><img class="register" src="images/cloudu_white.svg"></li>
      </ul>

 	  <div class="container">
 		<p class="text" style="padding-left: 20px; font-size: 18px;">Please fill in this form to sign up for CloudU.</p>
		<?php echo ($error);?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" value="<?php echo $username;?>" required maxlength="12">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" value="<?php echo $password;?>" required maxlength="16">
			<label for="confirm">Confirm password:</label>
			<input type="password" name="confirm" id="confirm" value="<?php echo $confirm;?>" required maxlength="18">
			<label for="email">E-mail:</label>
			<input type="email" name="email" id="email" value="<?php echo $email;?>" required maxlength="40">
			<br>
			<br>
			<input type="checkbox" id="terms" name="terms" value="terms" required><label for="checkbox" style="font-size: 15px;">By creating an account you agree to our <a href="#">Terms & Conditions</a>.</label>
		    <br>
		    <input type="submit" value="Create Account">
		</form>
		<p class="text" style="text-align: center">or</p>
		<p class="text" style="padding: 22px; padding-top: 7px; font-size: 18px;">Already have an account? <a href="home.php">Sign in</a>.</p>
	  </div>
	</body>
</html>