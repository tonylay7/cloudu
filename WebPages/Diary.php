<?php

    session_start();
    $current_user = $_SESSION["user_id"];

    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "n00575sm";
    $database_pass = "Mozzer_2310";
    $database_name = "2020_comp10120_x6";
    $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);

if(!$conn){
    die("connection failed: " . mysqli_connect_error());
}
    // echo "Connected successfully";

    $sql = "SELECT `username` FROM `users` WHERE `id` = $current_user";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $current_username = $row["username"];

    $sqld = "SELECT * FROM `diaryentries` WHERE `user_id` = $current_user";
    $diaryresult = $conn->query($sqld);

    while($row = $diaryresult->fetch_assoc()){
        $date[] = $row['date'];
        $gratefulData[] = $row['grateful_text'];
        $diaryData[] = $row['diary_text'];
    };

    $sql = "SELECT `mood` FROM `mood` WHERE `user_id` = $current_user";
    $moodresult = $conn->query($sql);
    while($row = $moodresult->fetch_assoc()){
        $moodData[] = $row['mood'];
    };
?>

<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
        <title>slider</title>
        <style type="text/css">
            body{
              font-family: Arial
              font-size: 30px;
              color: orange;
            }
            .title{
                margin: 0 auto;
                width: 90%;
                height: 30px;
                padding-left: 5px;
                font-size:14pt;font-family:Microsoft YaHei;
                color:#0099FF;

            }
            .lineDiv {
                position: relative;
                height: 20px;      
                background:linear-gradient(80deg,blue,orange);
                width: 380px;
                margin: 60px auto;
            }
             
            .lineDiv .minBlock {
                position: absolute;
                top: -5px;
                left: 0;
                width: 17px;
                height: 20px;
                background: pink;
                cursor: pointer
            }
             
            .lineDiv .minBlock .vals {
                position: absolute;
                font-size: 20px;
                top: -45px;
                left: -10px;
                width: 35px;
                height: 35px;
                line-height: 35px;
                text-align: center;
                background: white;
            }
             
            .lineDiv .minBlock .vals:after {
                content: "";
                width: 0px;
                height: 0px;
                border-top: 6px solid blue;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid transparent;
                display: block;
                margin-left: 11px;
            }

            form{
                text-align: center;
            }

            ul {
            list-style-type: none;
            margin: 0;
            padding-left: 30px;
            overflow: hidden;
            background-color: rgb(137, 207, 240);
            }

            li {
            float: left;
            }

            li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 25px;
            text-decoration: none;
            }

            li a:hover:not(.active) {
            background-color: rgb(255, 255, 255);
            color: rgb(0, 0, 0);
            }

            .active {
            background-color: #000000;
            }

            html,body {
            margin: 0;
            padding: 0;
            }
        </style>
    </head>
 
    <body>
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
        
        <br>
        <form name="diaryEntry" method="post" action="submitDiary.php">

                <td>
                    <label class="start">Date:</label>
                    <input type="date" id="start" name="date" min="2021-01-01" max="2399-12-31" value="">
                    <button type="button" id="load" title="Load data for selected day">Load</button>
                </td>
                <br><br>
                <td><label class ="title">What are you grateful for today?</label></td>
                <p><td><input style="width:70em ;height:3em;"type="text" name="title" id="title"?></td></p>
                        
                <td><textarea class ="content" name ="content" cols="130" rows="20" id="diaryText" value=""></textarea></td>


                <h3>Happy index <span id="msg">0</span>%</h3>     

            <div id="lineDiv" class="lineDiv">
                <div id="minBlock" class="minBlock">
                    <div id="vals" class="vals">0</div>    
                </div>
            </div>

            <input type="hidden" id="mood" name="mood" value="">

            <button onclick="save()">Save</button>
        </form>

        <script>
            function save() {
                document.getElementById('mood').value = document.getElementById('vals').innerText;
                alert("Saved successfully!");
            };

            document.getElementById('load').addEventListener('click', function() {
                var loadDate = document.getElementById('start').value;

                if(loadDate){
                    var dates = <?php echo json_encode($date); ?>;
                    var gratefulData = <?php echo json_encode($gratefulData); ?>;
                    var diaryData = <?php echo json_encode($diaryData); ?>;
                    var moodData = <?php echo json_encode($moodData); ?>;
                    
                    console.log(dates);
                    console.log(gratefulData);
                    console.log(diaryData);
                    console.log(moodData);

                    for(i=0;i<dates.length;i++){
                        if(loadDate == dates[i]){
                            console.log("yay");
                            document.getElementById('title').value = gratefulData[i];
                            document.getElementById('diaryText').value = diaryData[i];
                            document.getElementById('msg').innerText = moodData[i];
                            document.getElementById('vals').innerText = moodData[i];
                        }
                    }
                }
            });


            window.onload = function() {
 
                var lineDiv = document.getElementById('lineDiv'); 
                var minDiv = document.getElementById('minBlock'); 
                var msg = document.getElementById("msg");
                var vals = document.getElementById("vals");
                var ifBool = false; 
                
                var start = function(e) {
                    e.stopPropagation();
                    ifBool = true;
                    console.log("mousedown")
                }
                var move = function(e) {
                    console.log("mousemove")
                    if(ifBool) {
                        if(!e.touches) {    
                            var x = e.clientX;
                        } else {    
                            var x = e.touches[0].pageX;
                        }
                        
                        var lineDiv_left = getPosition(lineDiv).left;
                        var minBlock_left = x - lineDiv_left; 
                        if(minBlock_left >= lineDiv.offsetWidth - 15) {
                            minBlock_left = lineDiv.offsetWidth - 15;
                        }
                        if(minBlock_left < -3) {
                            minBlock_left = -3;
                        }
                        
                        minBlock.style.left = minBlock_left + "px";
                        msg.innerText = parseInt((minBlock_left / (lineDiv.offsetWidth - 15)) * 100);
                        vals.innerText = parseInt((minBlock_left / (lineDiv.offsetWidth - 15)) * 100);
                    }
                }
                var end = function(e) {
                        console.log("mouseup")
                        ifBool = false;
                    }
                    
                minDiv.addEventListener("touchstart", start);
                minDiv.addEventListener("mousedown", start);
                
                window.addEventListener("touchmove", move);
                window.addEventListener("mousemove", move);
                
                window.addEventListener("touchend", end);
                window.addEventListener("mouseup", end);
                
                function getPosition(node) {
                    var left = node.offsetLeft; 
                    var top = node.offsetTop;
                    current = node.offsetParent; 
                    　 
                    　　
                    while(current != null) {　　
                        left += current.offsetLeft;　　
                        top += current.offsetTop;　　
                        current = current.offsetParent;　　
                    }
                    return {
                        "left": left,
                        "top": top
                    };
                }
            }
        </script>
    </body>
</html>