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
            $gratefulDate[] = $row['date'];
            $gratefulData[] = $row['grateful_text'];
        };
    }
    else{
        $gratefulDate[] = "";
        $gratefulData[] = "";
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" type="text/css" href="MoodTracker.css">
        <link
          href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
          rel="stylesheet"
        />
		<meta charset="UTF-8">
		<title>Mood Tracker</title>
		<script src="../MoodTrackerTest/chart.js/dist/Chart.min.js"></script>
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
        <br><br><br><br>
        <div id="boundingBox">
            <div id="chartBackground">
                <br>
                <div id="graphTitle">Week Starting: Example</div>
                <canvas id="myChart"></canvas>
                <div id="buttons">
                    <button id="prevWeeks" class="moveBtns" title="Go back 4 Weeks"><<</button>
                    <button id="prevWeek" class="moveBtns" title="Go back a Week"><</button>
                    <button id="changeView" class="mainBtn" title="Switch between viewing the Month or the Current Week">View Month</button>
                    <button id="nextWeek" class="moveBtns" title="Go forwards a Week">></button>
                    <button id="nextWeeks" class="moveBtns" title="Go forwards 4 Weeks">>></button>
                </div>
                <br>
            </div>  
        </div>
        <br><br>
        <?php
            $sql = "SELECT `mood`, `date` FROM `mood` WHERE `user_id` = $current_user ORDER BY `date` DESC";
            $result = $conn->query($sql);
            $data = array();
            $date = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row['mood'];
                $date[] = $row['date'];
            }
        ?>
		<script>
            var currentColor = "white";
            var moodValues = <?php echo json_encode($data); ?>;
            var moodValueDates = <?php echo json_encode($date); ?>;
            const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const MONTHS = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
            var currentWeek = new Date();
            currentWeek.setDate(currentWeek.getDate() - (currentWeek.getDay() + 6) % 7);
            
            console.log(moodValues);
            console.log(moodValueDates);

            document.getElementById('graphTitle').innerHTML = "Week Starting: " + currentWeek.toDateString();

            var config = {
                type: 'line',
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    datasets: [{
                        data: getWeekValues(currentWeek),
                        fill: false,
                        backgroundColor: 'rgba(137, 207, 240)',
                        borderColor: 'rgba(137, 207, 240)',
                    }]
                },
                options: {
                    responsive: true,

                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        caretSize: 4,
                        custom: function(tooltip) {
                            if (!tooltip) return;
                            // disable displaying the color box;
                            tooltip.displayColors = false;
                        },
                        callbacks: {
                            title: function(tooltipItems, config) {
                                if(config.labels.length == 7){
                                    var dates = getWeekDates(currentWeek);
                                    var title = (tooltipItems[0].xLabel + " " + dates[tooltipItems[0].index]) + superscript(dates[tooltipItems[0].index]);
                                }
                                else{
                                    var title = tooltipItems[0].xLabel;
                                }
                                return title;
                            },
                            label : function(tooltipItem, config) {
                                // test(config.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                                if(config.labels.length == 7){
                                    var grateful = getGrateful(currentWeek, tooltipItem.xLabel);
                                    console.log(grateful);
                                    return [
                                        'Mood Value: ' + config.datasets[tooltipItem.datasetIndex].data[tooltipItem.index],
                                        "Things you were Grateful for:",
                                        grateful[tooltipItem.index]
                                        ];
                                }
                                else{
                                    return [
                                        'Mood Value: ' + config.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]
                                        ]
                                }
                            }
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Day'
                            }
                        }],
                        yAxes: [{
                            display: false,
                            ticks: {
                                max: 100,
                                min: 0,
                            }
                        }]
                    },
                    animation: {
                        duration: 2000,
                    },
                    legend: {
                        display: false,
                    }
                }
            };

            function getGrateful(week, day){
                var output = ["", "", "", "", "", "", ""];
                day = day.slice(0, -2);
                gratefulDate = <?php echo json_encode($gratefulDate); ?>;
                gratefulData = <?php echo json_encode($gratefulData); ?>;
                thisWeek = getWeek(week);
                for(i=0; i<gratefulDate.length; i++){
                    for(j=0; j<thisWeek.length; j++){
                        if(gratefulDate[i] == thisWeek[j]){
                            console.log(gratefulDate[i]);
                            console.log(gratefulData[i]);
                            output[j] = gratefulData[i];
                            break;
                        }
                    }
                }
                return output;
                
            }

            function superscript(day){
                day = day.toString();
                var first = day.charAt(0);
                var last = day.slice(-1);
                if(first == 1 && day.length >1){
                    return "ᵗʰ";
                }
                else if(last == 1){
                    return "ˢᵗ";
                }
                else if(last == 2){
                    return "ⁿᵈ";
                }
                else if(last == 3){
                    return "ʳᵈ";
                }
                return "ᵗʰ";
            }

            function getWeekDates(week){
                var output = [];
                var temp;
                for(i=0;i<7;i++){
                    var month = week.getMonth()+1;
                    var day = week.getDate()+i;
                    var year = week.getFullYear();
                    if(((new Date(year, month, 0)).getDate() - day) < 0){
                        var temp = (new Date(year, month, 0).getDate() - day);
                        day = Math.abs(temp);
                        if(month == 12){
                            month = 1;
                            year = year + 1;
                        }
                        else{
                            month = month + 1;
                        }
                    }
                    var dateStart = day;
                    output.push(dateStart);
                }
                return output;
            }

            function getWeek(week){
                var output = [];
                for(i=0;i<7;i++){
                    var buffer = "";
                    var buffer2 = "";
                    var month = week.getMonth()+1;
                    var day = week.getDate()+i;
                    var year = week.getFullYear();
                    if(((new Date(year, month, 0)).getDate() - day) < 0){
                        var temp = (new Date(year, month, 0).getDate() - day);
                        day = Math.abs(temp);
                        if(month == 12){
                            month = 1;
                            year = year + 1;
                        }
                        else{
                            month = month + 1;
                        }
                    }
                    if (month < 9){
                        buffer = "0";
                    }
                    if (day < 10){
                        buffer2 = "0";
                    }
                    var dateStart = year + "-" + buffer + (month)  + "-" + buffer2 + (day);
                    console.log(dateStart);
                    output.push(dateStart);
                }
                return output;
            }

            function getWeekValues(week) {
                var output = [];
                for(i=0;i<7;i++){
                    var buffer = "";
                    var buffer2 = "";
                    var month = week.getMonth()+1;
                    var day = week.getDate()+i;
                    var year = week.getFullYear();
                    if(((new Date(year, month, 0)).getDate() - day) < 0){
                        var temp = (new Date(year, month, 0).getDate() - day);
                        day = Math.abs(temp);
                        if(month == 12){
                            month = 1;
                            year = year + 1;
                        }
                        else{
                            month = month + 1;
                        }
                    }
                    if (month < 9){
                        buffer = "0";
                    }
                    if (day < 10){
                        buffer2 = "0";
                    }
                    var dateStart = year + "-" + buffer + (month)  + "-" + buffer2 + (day);
                    console.log(dateStart);
                    var index = moodValueDates.indexOf(dateStart);
                    output.push(moodValues[index]);
                }
                console.log(output);
                return output;
            };

            function getDayValue(day) {
                var index = moodValueDates.indexOf(day);
                return moodValues[index];
            };

            window.onload = function() {
                var ctx = document.getElementById('myChart').getContext('2d');
                window.myLine = new Chart(ctx, config);
            };

            document.getElementById('prevWeek').addEventListener('click', function() {
                config.data.datasets.splice(0, 1);
                window.myLine.update();
                
                currentWeek.setDate(currentWeek.getDate()-7);
                console.log(currentWeek)
                var newDataset = {
                    backgroundColor: 'rgba(133, 207, 240)',
                    borderColor: 'rgba(133, 207, 240)',
                    data: getWeekValues(currentWeek),
                    fill: false
                };
                document.getElementById('graphTitle').innerHTML = "Week Starting: " + currentWeek.toDateString();
                
                console.log('success')   
                config.data.datasets.push(newDataset)
                window.myLine.update();
            });

            document.getElementById('prevWeeks').addEventListener('click', function() {
                config.data.datasets.splice(0, 1);
                window.myLine.update();
                
                currentWeek.setDate(currentWeek.getDate()-28);
                console.log(currentWeek)
                var newDataset = {
                    backgroundColor: 'rgba(133, 207, 240)',
                    borderColor: 'rgba(133, 207, 240)',
                    data: getWeekValues(currentWeek),
                    fill: false
                };
                document.getElementById('graphTitle').innerHTML = "Week Starting: " + currentWeek.toDateString();
                
                console.log('success')   
                config.data.datasets.push(newDataset)
                window.myLine.update();
            });

            document.getElementById('nextWeek').addEventListener('click', function() {
                currentWeek.setDate(currentWeek.getDate()+7);
                console.log(currentWeek)

                var d = new Date();
                d.setDate(d.getDate() - (d.getDay() + 6) % 7);
                console.log(d);
                if (currentWeek > d) {
                    console.log("Can't display data that hasn't happened yet")
                    currentWeek.setDate(currentWeek.getDate()-7);
                    console.log(currentWeek)
                }
                else {
                    config.data.datasets.splice(0, 1);
                    window.myLine.update();

                    var newDataset = {
                        backgroundColor: 'rgba(133, 207, 240)',
                        borderColor: 'rgba(133, 207, 240)',
                        data: getWeekValues(currentWeek),
                        fill: false
                    };
                    document.getElementById('graphTitle').innerHTML = "Week Starting: " + currentWeek.toDateString();
                    
                    console.log('success')   
                    config.data.datasets.push(newDataset)
                    window.myLine.update();
                }
            });

            document.getElementById('nextWeeks').addEventListener('click', function() {
                currentWeek.setDate(currentWeek.getDate()+28);
                console.log(currentWeek)

                var d = new Date();
                d.setDate(d.getDate() - (d.getDay() + 6) % 7);
                console.log(d);
                if (currentWeek > d) {
                    console.log("Can't display data that hasn't happened yet")
                    currentWeek.setDate(currentWeek.getDate()-28);
                    console.log(currentWeek)
                }
                else {
                    config.data.datasets.splice(0, 1);
                    window.myLine.update();

                    var newDataset = {
                        backgroundColor: 'rgba(133, 207, 240)',
                        borderColor: 'rgba(133, 207, 240)',
                        data: getWeekValues(currentWeek),
                        fill: false
                    };
                    document.getElementById('graphTitle').innerHTML = "Week Starting: " + currentWeek.toDateString();
                    
                    console.log('success')   
                    config.data.datasets.push(newDataset)
                    window.myLine.update();
                }
            });

            document.getElementById('changeView').addEventListener('click', function() {
                if(document.getElementById('changeView').innerHTML == "View Month"){
                    document.getElementById('changeView').innerHTML = "View Week";
                    document.getElementById('prevWeeks').disabled = true;
                    document.getElementById('prevWeek').disabled = true;
                    document.getElementById('nextWeek').disabled = true;
                    document.getElementById('nextWeeks').disabled = true;
                    config.data.datasets.splice(0, 1);

                    var day = "";
                    var buffer = "";
                    var buffer2 = "";
                    var dataMonth = []
                    var month = currentWeek.getMonth();
                    var year = currentWeek.getFullYear();
                    var numDays = new Date(year, month+1, 0).getDate();
                    var DaysMonth = [];
                    for (i = 1; i <= numDays; i++) {
                        DaysMonth = DaysMonth.concat(i);
                    }

                    config.data.labels = [];

                    for (i=0; i < DaysMonth.length; i++) {
                        switch(DaysMonth[i]){
                            case 1: 
                                config.data.labels.push("1st")
                                break;
                            case 2: 
                                config.data.labels.push("2nd")
                                break;
                            case 3: 
                                config.data.labels.push("3rd")
                                break;
                            case 4: 
                                config.data.labels.push("4th")
                                break;
                            case 5: 
                                config.data.labels.push("5th")
                                break;
                            case 6: 
                                config.data.labels.push("6th")
                                break;
                            case 7: 
                                config.data.labels.push("7th")
                                break;
                            case 8: 
                                config.data.labels.push("8th")
                                break;
                            case 9: 
                                config.data.labels.push("9th")
                                break;
                            case 10: 
                                config.data.labels.push("10th")
                                break;
                            case 11: 
                                config.data.labels.push("11th")
                                break;
                            case 12: 
                                config.data.labels.push("12th")
                                break;
                            case 13: 
                                config.data.labels.push("13th")
                                break;
                            case 14: 
                                config.data.labels.push("14th")
                                break;
                            case 15: 
                                config.data.labels.push("15th")
                                break;
                            case 16: 
                                config.data.labels.push("16th")
                                break;
                            case 17: 
                                config.data.labels.push("17th")
                                break;
                            case 18: 
                                config.data.labels.push("18th")
                                break;
                            case 19: 
                                config.data.labels.push("19th")
                                break;
                            case 20: 
                                config.data.labels.push("20th")
                                break;
                            case 21: 
                                config.data.labels.push("21st")
                                break;
                            case 22: 
                                config.data.labels.push("22nd")
                                break;
                            case 23: 
                                config.data.labels.push("23rd")
                                break;
                            case 24: 
                                config.data.labels.push("24th")
                                break;
                            case 25: 
                                config.data.labels.push("25th")
                                break;
                            case 26: 
                                config.data.labels.push("26th")
                                break;
                            case 27: 
                                config.data.labels.push("27th")
                                break;
                            case 28: 
                                config.data.labels.push("28th")
                                break;
                            case 29: 
                                config.data.labels.push("29th")
                                break;
                            case 30: 
                                config.data.labels.push("30th")
                                break;
                            case 31: 
                                config.data.labels.push("31st")
                                break;
                        }
                    }

                    for (i=0; i < DaysMonth.length; i++) {
                        buffer = "";
                        buffer2 = "";
                        if (month<9){
                            buffer = "0";
                        }
                        if (i < 9){
                            buffer2 = "0";
                        }
                        var day = year + "-" + buffer + (month+1)  + "-" + buffer2 + (i+1);
                        console.log(day);
                        dataMonth = dataMonth.concat(getDayValue(day))
                    }

                    var newDataset = {
                            labels: DaysMonth,
                            backgroundColor: 'rgba(133, 207, 240)',
                            borderColor: 'rgba(133, 207, 240)',
                            data: dataMonth,
                            fill: false
                        };
                        document.getElementById('graphTitle').innerHTML = MONTHS[month];
                }
                else{
                    document.getElementById('changeView').innerHTML = "View Month";
                    document.getElementById('prevWeeks').disabled = false;
                    document.getElementById('prevWeek').disabled = false;
                    document.getElementById('nextWeek').disabled = false;
                    document.getElementById('nextWeeks').disabled = false;
                    var d = new Date();
                    d.setDate(d.getDate() - (d.getDay() + 6) % 7);
                    currentWeek = d;
                    config.data.datasets.splice(0, 1);

                    config.data.labels = [];

                    for (i=0; i < DAYS.length; i++) {
                        config.data.labels.push(DAYS[i])
                    }

                    var newDataset = {
                        backgroundColor: 'rgba(133, 207, 240)',
                        borderColor: 'rgba(133, 207, 240)',
                        data: getWeekValues(currentWeek),
                        fill: false
                    }; 
                    document.getElementById('graphTitle').innerHTML = "Week Starting: " + currentWeek.toDateString();
                }
                config.data.datasets.push(newDataset)
                window.myLine.update();
            });
		</script>
	</body>
    <footer>
    </footer>
	</html>
