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
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style type="text/css">
      #box{
        margin: 0 auto;
        background-color: rgb(137, 207, 240);
        box-shadow: 0px 5px 5px #549abb;
        border: 5px solid rgb(200, 220, 240, 0.7);
        border-radius: 10px;
        height: 35em;
        width: 80em;
        padding-top: 1em;
        padding-left: 1em;
        text-shadow: -1px 1px 4px #64aacb;
        }
    </style>
    <meta charset="UTF-8">
    <title>Mood Tracker</title>
  </head>
  <body>
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
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="aboutus">
      <div id="box">
      <img class="aboutus" src="images/cloudu_white.svg">
      <h1>About Us</h1>
      <p>We are a group of students from the University of Manchester. Knowing that many people struggle with mental health on a daily basis, we made this web application with the aim of empowering people with tools for emotional management. With this website, hopefully you can use gratitude journaling to remind yourself every day of what brings you joy.</p>
      <br>
      <br>
      <h1>Contact Us</h1>
      <p>If you have any questions, suggestions, or complaints, please drop us an email at <b>cloudu.x6@gmail.com</b> or visit the Help Section to submit a form.</p>
      </div>
    </div>

  </body>
</html>
