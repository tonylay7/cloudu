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
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="UTF-8">
    <title>Mood Tracker</title>
  </head>
  <body>
    <div class="navbar"> 
      <ul>
        <li><a href="WordCloud.php">Word Cloud</a></li>
        <li><a href="Diary.php">Diary</a></li>
        <li><a href="Calendar.php">Calendar</a></li>
        <li><a href="MoodTracker.php">Mood Tracker</a></li>
        <li><a href="Resources.php">Resources</a></li>
        <li><a href="Help.php">Help</a></li>
        <li><a href="AboutUs.php">About Us</a></li>
        <li style="float:right"><a class="active" href="Profile.html"><?php echo $current_username ?></a></li>
      </ul>
    </div>

    <div class="aboutus">
      <img class="aboutus" src="images/cloudu_white.svg">
      <h1>About Us</h1>
      <p>We are a group of students from the University of Manchester. Knowing that many people struggle with mental health on a daily basis, we made this web application with the aim of empowering people with tools for emotional management. With this website, hopefully you can use gratitude journaling to remind yourself every day of what brings you joy.</p>
      <br>
      <br>
      <h1>Contact Us</h1>
      <p>If you have any questions, suggestions, or complaints, please drop us an email at [insert smth here or google form?].</p>
    </div>

  </body>
</html>
