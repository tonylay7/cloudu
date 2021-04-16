<?php
  session_start();
  $current_user = $_SESSION["user_id"];
  $database_host = "dbhost.cs.man.ac.uk";
  $database_user = "n00575sm";
  $database_pass = "Mozzer_2310";
  $database_name = "2020_comp10120_x6";
  $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name); 
  if (!$conn){
    die("connection failed: " . mysqli_connect_error());
  }
  $usersql = "SELECT `username` FROM `users` WHERE `id` = $current_user";
  $userresult = $conn->query($usersql);
  $userrow = $userresult->fetch_assoc();
  $current_username = $userrow["username"];
?>
<!DOCTYPE html>
<html>
	<head>

		<html lang="en">
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="styles.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap">
		<link
          href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
		<title>External Resources</title>

	</head>
	<body>

		<!-- Header -->
		<!-- <header>
			style="font-family: 'Noto Sans JP', sans-serif;"
			<h1>CloudU</h1>
		</header> -->
		<div class="navbar"> 
	      <ul>
		  	<img src="images/cloudu_white.svg" width="100" height="50" style="float:left; padding: 3px 0px 0px 0px" > 
	        <li><a href="WordCloud.php">Word Cloud</a></li>
	        <li><a href="Diary.php">Diary</a></li>
	        <li><a href="Calendar.php">Calendar</a></li>
	        <li><a href="MoodTracker.php">Mood Tracker</a></li>
	        <li><a href="Resources.php">Resources</a></li>
	        <li><a href="Help.php">Help</a></li>
	        <li><a href="AboutUs.php">About Us</a></li>
	        <li style="float:right"><a class="active" href="Profile.php"><?php echo $current_username ?></a></li>
	      </ul>
	    </div>
		<!-- Main Part -->
		<div class="resources" style="position:absolute; width:100%; top:15%">
      <div id="box" style="position:absolute;">
        <h1>External Resources</h1>
        <p>Below contains information about more professional mental health facilities.</p>

        <h2>NHS</h2>
        <p>The National Health Service of United Kingdom.<br>The NHS provides valuable information and support regarding mental health.<br>Has quizzes that may help the person with their conditions.</p>
        <p>Free listening services from trained volunteers, call: 116 123.</p>
        <a href="https://www.nhs.uk/mental-health/">Click here for the main page.</a>
        <br>
        <a href="https://www.nhs.uk/mental-health/get-urgent-help-for-mental-health/">Click here for helplines.</a>

        <h2>WHO</h2>
        <p>The World Health Organization.<br>The WHO contains a variety of different materials about mental health.<br>Provides each country's mental health profile.</p>
        <a href="https://www.who.int/health-topics/mental-health#tab=tab_1">Click here for the main page.</a>
        <br>
        <a href="https://www.who.int/mental_health/evidence/atlas/profiles-2017/en/">Click here for country profiles.</a>
        
        <h2>MHA</h2>
        <p>Mental Health America.<br>MHA provides professional and specific mental health quizzes.<br>The webpage contains details about all mental health conditions.</p>
        <a href="https://screening.mhanational.org/screening-tools/">Click here for main page.</a>

        <h2>NIMH</h2>
        <p>The National Institute of Mental Health of USA.<br>NIMH contains lots of information about different subjects and categories.<br>Has a variety of research papers to read regarding health.</p>
        <a href="https://www.nimh.nih.gov/health/index.shtml">Click here for main page.</a>

        <h2>Patient</h2>
        <p>Patient is an online community related to human health.<br>Has information about every aspect of human health.<br>There is a whole section dedicated to mental health.<br>The team and the
        community is made from professional doctors around the world.</p>
        <a href="https://patient.info/mental-health">Click here for main page.</a>

        <h2>Positivity Blog</h2>
        <p>The Positivity Blog is an online webpage dedicated to positivity.<br>Helps the user to practice being and thinking more positive through various courses.<br>The site provides you with the option to start a blog about yourself<br>where you can write about any positivity you want.</p>
        <a href="https://www.positivityblog.com/about">Click here for main page.</a>
      
      </div>
    </div>

	</body>
</html>
