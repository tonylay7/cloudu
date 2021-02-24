<?php
session_start();
?>

<!DOCTYPE html>
<html>
  	
  	<head>
  		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="home.css">
     	<title>Welcome to CLOUDU</title>
  	</head>
  	<body>
  	<header>
 		<h1 style="line-height: 80px;">Welcome to CLOUDU!</h1>
 	</header>
  	<main>
    <form action="template.html">
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
		    	<td><input type="submit" formaction="register.html" value="Register as New User"></td>
		    </tr>
		</table>
	</form>
    </main>
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
  </body>
</html>

