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

    $sql = "SELECT * FROM `users` WHERE `id` = $current_user";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_username = $row["username"];
    $current_email = $row["email"];
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style type="text/css">
    #form, iframe {
        margin: 0 auto;
    }
    #form{
        overflow: hidden;
        position: absolute;
    }
      iframe{
        display: block;
      }
    </style>
    <meta charset="UTF-8">
    <title>Help Page</title>
  </head>
  <body>
    <div class="navbar"> 
        <ul>
            <li><a href="WordCloud.php">Word Cloud</a></li>
            <li><a href="Diary.php">Diary</a></li>
            <li><a href="Calendar.html">Calendar</a></li>
            <li><a href="MoodTracker.php">Mood Tracker</a></li>
            <li><a href="Resources.php">Resources</a></li>
            <li><a href="Help.php">Help</a></li>
            <li><a href="AboutUs.php">About Us</a></li>
            <li style="float:right"><a class="active" href="Profile.php"><?php echo $current_username ?></a></li>
        </ul>
    </div>
    <br><br><br><br>
    <div class="form">
        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSciBX14POalkzBpwpJ1owUGWogqpAj7WYAmtB2Cy8EBV9LU7Q/viewform?embedded=true" width="800" height="1200em" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
    </div>
  </body>
</html>
