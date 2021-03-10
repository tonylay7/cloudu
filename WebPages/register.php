<?php
  $database_host = "dbhost.cs.man.ac.uk";
  $database_user = "n00575sm";
  $database_pass = "Mozzer_2310";
  $database_name = "2020_comp10120_x6";

  $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);
  
  if (!$conn){
    die("connection failed: " . mysqli_connect_error());
  }

  echo "Connected successfully";
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

	$sql = "SELECT `email`, `username` FROM `users` WHERE `username`='".$username."' OR `email`='".$email."'";
	$result = $conn->query($sql);

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
  		$sql = "INSERT INTO users (username, email, password)
		VALUES ('$username', '$email', '$password')";

		if (mysqli_query($conn, $sql)) {
	  		echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
  	}

}

if (isset($_POST["username"])) {
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
	<header>
 		<h1 style="line-height: 80px;">Welcome to CLOUDU!</h1>
 	</header>
 	<p>Please fill in this form to sign up for CloudU.</p>
	<br>
	<?php echo ($error);?>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<table>
		<tr>
			<td><label for="username">Username:</label></td>
			<td><input type="text" name="username" id="username" value="<?php echo $username;?>" required></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label></td>
			<td><input type="password" name="password" id="password" value="<?php echo $password;?>" required></td>
		</tr>
		<tr>
			<td><label for="confirm">Confirm password:</label></td>
			<td><input type="password" name="confirm" id="confirm" value="<?php echo $confirm;?>" required></td>
		</tr>
		<tr>
			<td><label for="email">E-mail:</label></td>
			<td><input type="email" name="email" id="email"
				     value="<?php echo $email;?>" required></td>
	    </tr>
	    <tr>
	    	<td colspan="2"><input type="checkbox" id="terms" name="terms" value="terms">
	    		By creating an account you agree to our <a href="#">Terms & Conditions</a>.</td>
	    </tr>
	    <tr>
	    	<td>&nbsp;</td>
	    	<td><input type="submit" value="Create Account"></td>
	    </tr>
	</table>
	</form>
	<br>
	<p>Already have an account? <a href="home.php">Sign in</a>.</p>
</body>
</html>