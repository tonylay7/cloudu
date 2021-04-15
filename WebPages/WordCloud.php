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

      $sqldiary = "SELECT * FROM diaryentries WHERE user_id = $current_user";
      $diaryresult = $conn->query($sqldiary);
      $diaryrow = $diaryresult->fetch_assoc();

      $samplediary = "SELECT * FROM diaryentries WHERE user_id = 32";
      $sampleresult = $conn->query($samplediary);
      $samplerow = $sampleresult->fetch_assoc();
      if (is_null($diaryrow)){
        $texts[] = $samplerow['grateful_text'];
        $title = "This is just a sample wordcloud, enter things that you're grateful for every day to create your own!";
      }
      else{
        $sqldiary = "SELECT * FROM diaryentries WHERE user_id = $current_user";
        $diaryresult = $conn->query($sqldiary);
        while($diaryrow = $diaryresult->fetch_assoc()){
          $texts[] = $diaryrow['grateful_text'];
        }
        $title = "Here is a collection of things that you are grateful for!";
      }
      $usersql = "SELECT `username` FROM `users` WHERE `id` = $current_user";
      $userresult = $conn->query($usersql);
      $userrow = $userresult->fetch_assoc();
      $current_username = $userrow["username"];
  
    ?>
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
      body{
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #container {
        width: 90%;
        height: 100%;
        margin: 0 auto;
        padding: 0;
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
        <li><a href="Calendar.php">Calendar</a></li>
        <li><a href="MoodTracker.php">Mood Tracker</a></li>
        <li><a href="Resources.php">Resources</a></li>
        <li><a href="Help.php">Help</a></li>
        <li><a href="AboutUs.php">About Us</a></li>
        <li style="float:right"><a class="active" href="Profile.php"><?php echo $current_username ?></a></li>
      </ul>
    </div>
    <br><br><br><br> <!--TEMP FIX FOR STYLING ISSUE-->
  <div id="container" style="height: 700px"></div>
    <script type="text/javascript">
    var db_texts = <?php echo json_encode($texts); ?>;
    var charttitle = "<?php echo $title; ?>";
    </script>
    <script src="../Scripts/bundle.js"></script>

  </body>
</html>
