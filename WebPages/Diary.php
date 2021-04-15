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

    if($diaryresult->fetch_assoc()){
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
    }
    else{
        $date[] = "";
        $gratefulData[] = "";
        $diaryData[] = "";
        $moodData[] = "";
    }
?>

<!DOCTYPE html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
        <title>Diary</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style type="text/css">
            body{
              font-family: Arial
              font-size: 30px;
              color: white;
            }
            .lineDiv {
                position: relative;
                height: 20px;      
                background:linear-gradient(80deg,rgb(117, 187, 220),coral);
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
                background: rgb(117, 187, 220);
            }
             
            .lineDiv .minBlock .vals:after {
                content: "";
                width: 0px;
                height: 0px;
                border-top: 6px solid rgb(117, 187, 220);
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid transparent;
                display: block;
                margin-left: 11px;
            }

            form{
                text-align: center;
            }

            #sliderBackground{
                margin: 0 auto;
                padding-top: 2px;
                background-color: white;
                width: 420px;
                height: 100px;
                border: 1px solid lightgrey;
            }

            .phrases{
                display: none;
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
        
        <br><br><br><br>
        <form name="diaryEntry" method="post" action="submitDiary.php">
        <button type="submit" disabled style="display: none" aria-hidden="true"></button>
            <td>
                <h3><label class="start">Date:</label>
                <input type="date" id="start" name="date" min="2021-01-01" max="2399-12-31" value="">
                <button type="button" id="load" title="Load data for selected day">Load</button>
                </h3>
            </td>
            <br>
            <td><h3>What are you grateful for today?<h3></td>
            <br>
            <div class="phrasescontainer" style="margin: 0 auto; width: 600px">
                <button type="button" class="phrases" id="btn1" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn2" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn3" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn4" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn5" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn6" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn7" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn8" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn9" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn10" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn11" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn12" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn13" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn14" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn15" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn16" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn17" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn18" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn19" onclick="invis(this)"></button>
                <button type="button" class="phrases" id="btn20" onclick="invis(this)"></button>
                <input type="hidden" id="phrases" name="phrases" value="">
            </div>
            <br>
            <p><td><input style="width:30em ;height:3em;"type="text" name="title" id="title"?></td></p>
            <br>
            <button type="button" id="submitPhrase">Submit</button>
            <br><br>


            <h3>Diary Entry:<h3>
            <td><textarea class ="content" name ="content" cols="130" rows="20" id="diaryText" value=""></textarea></td>

            <br><br>
            <h3>What would you rate your average mood for the day?<h3>   

            <br>
            <div id="sliderBackground">
                <div id="lineDiv" class="lineDiv">
                    <div id="minBlock" class="minBlock">
                        <div id="vals" class="vals">0</div>    
                    </div>
                </div>
            </div>
            <br>
            <h3>Happiness Rating: <span id="msg">0</span></h3>
            <br> 

            <input type="hidden" id="mood" name="mood" value="">

            <button onclick="save()">Save</button>
        </form>

        <script>  

            function save() {
                document.getElementById('mood').value = document.getElementById('vals').innerText;
                for(i=1;i<21;i++){
                    if(document.getElementById('btn' + i.toString()).style.display === "inline-block"){
                        if(document.getElementById('phrases').value === ""){
                            document.getElementById('phrases').value = document.getElementById('btn' + i.toString()).innerText;
                        }
                        else{
                            document.getElementById('phrases').value += "," + document.getElementById('btn' + i.toString()).innerText;
                        }
                    }
                }
            };

            function invis(obj) {
                document.getElementById(obj.id).style.display = "none";
                document.getElementById(obj.id).innerText = "";
            }

            document.getElementById('load').addEventListener('click', function() {
                    var loadDate = document.getElementById('start').value;
                    load(loadDate);
            });

            function load(loadDate){
                if(loadDate){
                        var dates = <?php echo json_encode($date); ?>;
                        var gratefulData = <?php echo json_encode($gratefulData); ?>;
                        var diaryData = <?php echo json_encode($diaryData); ?>;
                        var moodData = <?php echo json_encode($moodData); ?>;

                        for(i=0;i<dates.length;i++){
                            if(loadDate == dates[i]){
                                document.getElementById('diaryText').value = diaryData[i];
                                document.getElementById('msg').innerText = moodData[i];
                                document.getElementById('vals').innerText = moodData[i];
                                var gratefuls = gratefulData[i].split(",");
                                console.log(gratefuls.length);
                                for(j=0;j<(gratefuls.length);j++){
                                    document.getElementById('btn' + (j+1).toString()).style.display = "inline-block";
                                    document.getElementById('btn' + (j+1).toString()).innerText = gratefuls[j];
                                }
                            }
                        }
                    }
                    else{
                        document.getElementById('title').value = "";
                        document.getElementById('diaryText').value = "";
                        document.getElementById('msg').innerText = "0";
                        document.getElementById('vals').innerText = "0";
                    }
            }

            document.getElementById('submitPhrase').addEventListener('click', function() {
                var input = document.getElementById('title').value;
                input = input.trim().toLowerCase();
                for(i=1;i<21;i++){
                    if(document.getElementById('btn' + i.toString()).innerText === input){
                        alert("You have already inputted: " + input);
                        document.getElementById('title').value = "";
                        break;
                    };
                    if(document.getElementById('btn' + i.toString()).style.display === "" ||
                    document.getElementById('btn' + i.toString()).style.display === "none"){
                        document.getElementById('btn' + i.toString()).style.display = "inline-block";
                        document.getElementById('btn' + i.toString()).innerText = input;
                        document.getElementById('title').value = "";
                        break;
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
