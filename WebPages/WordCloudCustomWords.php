<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta charset="UTF-8">
    <title>Word Cloud - Add/Remove Words</title>
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
      textarea {
        resize: none;
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
    <div class="container">
      <div class="center">
        <a href="WordCloud.php" class="myButton">Back</a>  
        <input class='myButton' type='button' value='Save' onclick='showAnswer()'>
      </div>
    </div>
    <div id="container">
      <div class="center">
        <textarea class="textarea" id="addwords" name="addwords" rows="20" cols="50"></textarea>
        <textarea class="textarea" id="removewords" name="removewords" rows="20" cols="50"></textarea>
      </div>
    </div>
  </body>
</html>
