<!DOCTYPE html>
<html>
  <head>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-tag-cloud.min.js"></script>
    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="UTF-8">
    <title>Word Cloud</title>

    <style type="text/css">
      html,
      body,
      #container {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <ul>
      <li><a href="WordCloud.php">Word Cloud</a></li>
      <li><a href="Diary.html">Diary</a></li>
      <li><a href="Calendar.html">Calendar</a></li>
      <li><a href="MoodTracker.html">Mood Tracker</a></li>
      <li><a href="Resources.html">Resources</a></li>
      <li><a href="Help.html">Help</a></li>
      <li><a href="AboutUs.html">About Us</a></li>
      <li style="float:right"><a class="active" href="Profile.html">Profile</a></li>
    </ul>
  <div id="container"></div>
    <?php
      $database_host = "dbhost.cs.man.ac.uk";
      $database_user = "n00575sm";
      $database_pass = "Mozzer_2310";
      $database_name = "2020_comp10120_x6";

      $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);
      
      if (!$conn){
        die("connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT * FROM diaryentries";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
    ?>
    <script type="text/javascript">
      var db_text = "<?php echo $row['grateful_text']; ?>";
    </script>
    <script src="../Scripts/bundle.js"></script>

  </body>
</html>
