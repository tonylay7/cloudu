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
        <link
          href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
        <meta charset="UTF-8">
        <title>Profile</title>
        <style type="text/css">
            #background{
                margin: 0 auto;
                background-color: rgb(137, 207, 240);
                box-shadow: 0px 5px 5px #549abb;
                border: 5px solid rgb(200, 220, 240, 0.7);
                height: 30em;
                width: 60em;
                padding-top: 1.75em;
                padding-left: 0.3em;
            }

            #insideBox{
                margin: 0 auto;
                height: 26em;
                width: 56em;
                border: 2px solid darkgrey;
                background-color: white;
                padding: 25px;
                text-align: center;
            }
            #insideBox2{
                margin: 0 auto;
                height: 13em;
                width: 28em;
            }
            h1, h3, label{
                color: rgb(137, 207, 240);
            }
            .leftLabel{
                float: left;
            }
            .rightLabel{
                float: right;
            }
            input{
                -ms-transform: translateY(-20%);
                transform: translateY(-20%);
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
            <li><a href="Resources.php">Resources</a></li>
            <li><a href="Help.php">Help</a></li>
            <li><a href="AboutUs.php">About Us</a></li>
            <li style="float:right"><a class="active" href="Profile.php"><?php echo $current_username ?></a></li>
        </ul>
        </div>
        <br><br><br><br><br><br>
        <div id="background">
            <div id="insideBox">
                <h1 id="title">Profile</h1>
                <h3>Fill out any boxes for the data you want to change</h3>
                <br><br><br>
                <div id="insideBox2">
                    <form name="editProfile" method="post" action="submitProfile.php">
                        <label class="leftLabel">New Username:</label><input type="text" name="username" id="username" class="rightLabel" title="Enter New Username, if you want to change">
                        <br><br><br>
                        <label class="leftLabel">E-Mail:</label><input type="text" name="email" id="email" class="rightLabel" title="Enter New E-Mail, if you want to change">
                        <br><br><br>
                        <label class="leftLabel">New Password:</label><input type="password" name="newPassword" id="newPassword" class="rightLabel" title="Enter New Password, if you want to change">
                        <br><br><br>
                        <label title="Required" class="leftLabel"><span style="color: red">*</span>Old Password:</label><input type="password" name="oldPassword" id="oldPassword" class="rightLabel" title="Enter Old Password">
                        <br><br><br>
                </div>
                <button type="submit" title="Click to Save">Save</button>
            </div>
        </div>  

        <script>
            var username = <?php echo json_encode($current_username);?>;
            var email = <?php echo json_encode($current_email);?>;

            document.getElementById("username").innerText = username;
            document.getElementById("email").innerText = email;

        </script>
    </body>
</html>
