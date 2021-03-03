<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<meta charset="UTF-8">
		<title>Mood Tracker</title>
		<script src="../MoodTrackerTest/chart.js/dist/Chart.min.js"></script>
		<style>
			div, canvas{
				width: 80%;
				max-height: 20cm;
				margin: 0 auto;
			}
		</style>
	</head>
	<body>
		<ul>
			<li><a href="WordCloud.html">Word Cloud</a></li>
			<li><a href="Diary.html">Diary</a></li>
			<li><a href="Calendar.html">Calendar</a></li>
			<li><a href="MoodTracker.html">Mood Tracker</a></li>
			<li><a href="Resources.html">Resources</a></li>
			<li><a href="Help.html">Help</a></li>
			<li><a href="AboutUs.html">About Us</a></li>
			<li style="float:right"><a class="active" href="Profile.html">Profile</a></li>
		</ul>
		<p></p>
		<div>
            <canvas id="myChart"></canvas>
        </div>
        <br><br>
        <button id="addData">Add Data</button>
	    <button id="removeData">Remove Data</button>
        <button id="reload">Reload</button>
        <button id="prevWeek">Last Week</button>
        <button id="nextWeek">Next Week</button>
        <button id="changeView">View Month</button>
        <?php
            $database_host = "dbhost.cs.man.ac.uk";
            $database_user = "n00575sm";
            $database_pass = "Mozzer_2310";
            $database_name = "2020_comp10120_x6";
            
            $conn = mysqli_connect($database_host,$database_user,$database_pass,$database_name);

            if (!$conn){
                die("connection failed: " . mysqli_connect_error());
            }
            $current_user = 1; //NEED TO GET THIS
            $sql = "SELECT `mood`, `date` FROM `mood` WHERE `user_id` = $current_user";
            $result = $conn->query($sql);
            $data = array();
            $date = array();
            while($row = $result->fetch_assoc()){
                $data[] = $row['mood'];
                $date[] = $row['date'];
            }
        ?>
		<script>
            var moodValues = <?php echo json_encode($data); ?>;
            var moodValueDates = <?php echo json_encode($date); ?>;
            const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            const MONTHS = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
            var currentWeek = new Date();
            currentWeek.setDate(currentWeek.getDate() - (currentWeek.getDay() + 6) % 7);
            
            console.log(moodValues);
            console.log(moodValueDates);

            var config = {
                type: 'line',
                data: {
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    datasets: [{
                        label: 'Week Starting: ' + currentWeek.toDateString(),
                        data: getWeekValues(currentWeek),
                        fill: false,
                        backgroundColor: 'rgba(133, 207, 240)',
                        borderColor: 'rgba(133, 207, 240)',
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
                    }
                }
            };

            function getWeekValues(week) {
                var output = [];
                var buffer,buffer2 = "";
                if (week.getMonth()<9){
                    buffer = "0";
                }
                if (week.getDate() < 10){
                    buffer2 = "0";
                }
                var dateStart = week.getFullYear() + "-" + buffer + (week.getMonth()+1)  + "-" + buffer2 + week.getDate();
                var index = moodValueDates.indexOf(dateStart);
                for(i=0;i<7;i++){
                    output.push(moodValues[index+i]);
                }
                console.log(output);
                return output;
            }

            function getDayValue(day) {
                var index = moodValueDates.indexOf(day);
                return moodValues[index];
            }

            window.onload = function() {
                var ctx = document.getElementById('myChart').getContext('2d');
                window.myLine = new Chart(ctx, config);
            };

            document.getElementById('addData').addEventListener('click', function() {
                config.data.datasets.forEach(function(dataset) {
                    if (dataset.data.length < 7){
                        dataset.data.push(Math.floor(Math.random() * 101));
                        console.log('Data added')
                    }
                })
                window.myLine.update();
            });

            document.getElementById('removeData').addEventListener('click', function() {
                config.data.datasets.forEach(function(dataset) {
                    if (dataset.data.length > 0){
                        dataset.data.pop();
                        console.log('Data removed')
                    }
                })
                window.myLine.update();
            });

            document.getElementById('reload').addEventListener('click', function() {
                config.data.datasets.forEach(function(dataset) {
                    var temp = dataset.data;
                    dataset.data = [];
                    window.myLine.update();
                    for (i = 0; i < temp.length; i++) {
                        dataset.data.push(temp[i])
                        window.myLine.update();
                    }
                })
            });

            document.getElementById('prevWeek').addEventListener('click', function() {
                config.data.datasets.splice(0, 1);
                window.myLine.update();
                
                currentWeek.setDate(currentWeek.getDate()-7);
                console.log(currentWeek)
                var newDataset = {
                    label: 'Week Starting: ' + currentWeek.toDateString(),
                    backgroundColor: 'rgba(133, 207, 240)',
                    borderColor: 'rgba(133, 207, 240)',
                    data: getWeekValues(currentWeek),
                    fill: false
                };
                
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
                        label: 'Week Starting: ' + currentWeek.toDateString(),
                        backgroundColor: 'rgba(133, 207, 240)',
                        borderColor: 'rgba(133, 207, 240)',
                        data: getWeekValues(currentWeek),
                        fill: false
                    };
                    
                    console.log('success')   
                    config.data.datasets.push(newDataset)
                    window.myLine.update();
                }
            });

            document.getElementById('changeView').addEventListener('click', function() {
                if(document.getElementById('changeView').innerHTML == "View Month"){
                    document.getElementById('changeView').innerHTML = "View Week";
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
                        if (i < 10){
                            buffer2 = "0";
                        }
                        var day = year + "-" + buffer + (month+1)  + "-" + buffer2 + (i+1);
                        console.log(day);
                        dataMonth = dataMonth.concat(getDayValue(day))
                    }

                    var newDataset = {
                            label: MONTHS[month],
                            labels: DaysMonth,
                            backgroundColor: 'rgba(133, 207, 240)',
                            borderColor: 'rgba(133, 207, 240)',
                            data: dataMonth,
                            fill: false
                        };
                }
                else{
                    document.getElementById('changeView').innerHTML = "View Month";
                    var d = new Date();
                    d.setDate(d.getDate() - (d.getDay() + 6) % 7);
                    currentWeek = d;
                    config.data.datasets.splice(0, 1);

                    config.data.labels = [];

                    for (i=0; i < DAYS.length; i++) {
                        config.data.labels.push(DAYS[i])
                    }

                    var newDataset = {
                        label: 'Week Starting: ' + currentWeek.toDateString(),
                        backgroundColor: 'rgba(133, 207, 240)',
                        borderColor: 'rgba(133, 207, 240)',
                        data: getWeekValues(currentWeek),
                        fill: false
                    }; 
                }
                config.data.datasets.push(newDataset)
                window.myLine.update();
            });
		</script>
	</body>
	</html>
