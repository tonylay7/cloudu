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
      .myButton {
        box-shadow:inset 0px 1px 0px 0px #ffffff;
        background:linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
        background-color:#ffffff;
        border-radius:6px;
        border:1px solid #dcdcdc;
        display:inline-block;
        cursor:pointer;
        color:#666666;
        font-family:Arial;
        font-size:15px;
        font-weight:bold;
        padding:6px 24px;
        text-decoration:none;
        text-shadow:0px 1px 0px #ffffff;
      }
      .myButton:hover {
        background:linear-gradient(to bottom, #f6f6f6 5%, #ffffff 100%);
        background-color:#f6f6f6;
      }
      .myButton:active {
        position:relative;
        top:1px;
      }  
      .container {
        height: 100px;
        position: relative;
      }
      .center {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
      }
    </style>
  </head>
  <body>
    <div class="navbar"> 
      <ul>
        <li><a href="WordCloud.php">Word Cloud</a></li>
        <li><a href="Diary.php">Diary</a></li>
        <li><a href="Calendar.html">Calendar</a></li>
        <li><a href="MoodTracker.php">Mood Tracker</a></li>
        <li><a href="Resources.html">Resources</a></li>
        <li><a href="Help.html">Help</a></li>
        <li><a href="AboutUs.html">About Us</a></li>
        <li style="float:right"><a class="active" href="Profile.html">Profile</a></li>
      </ul>
    </div>
    <br><br> <!--TEMP FIX FOR STYLING ISSUE-->
    <div class="container">
      <div class="center">
        <a href="WordCloudCustomWords.php" class="myButton">Add/Remove Words</a>  
      </div>
    </div>
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

      $sqldiary = "SELECT * FROM diaryentries";
      $diaryresult = $conn->query($sqldiary);
      $diaryrow = $diaryresult->fetch_assoc();

      $sqlwords = "SELECT * FROM customwords";
      $wordsresult = $conn->query($sqlwords);
      $wordsrow = $wordsresult->fetch_assoc();
    ?>
    <script type="text/javascript">
      var db_text = "<?php echo $diaryrow['grateful_text']; ?>";
      var db_addwords = "<?php echo $wordsrow['addwords']; ?>";
      var db_removewords = "<?php echo $wordsrow['removewords']; ?>";
    </script>
    <script src="../Scripts/bundle.js"></script>

  </body>
</html>
