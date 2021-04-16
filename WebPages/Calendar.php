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
  $usersql = "SELECT `username` FROM `users` WHERE `id` = $current_user";
  $userresult = $conn->query($usersql);
  $row = $userresult->fetch_assoc();
  $current_username = $row["username"];

  $sqld = "SELECT * FROM `diaryentries` WHERE `user_id` = $current_user";
  $diaryresult = $conn->query($sqld);

  if($diaryresult->fetch_assoc()){
    $sqld = "SELECT * FROM `diaryentries` WHERE `user_id` = $current_user";
    $diaryresult = $conn->query($sqld);
    while($row = $diaryresult->fetch_assoc()){
        $date[] = $row['date'];
    };

    $sql = "SELECT `mood` FROM `mood` WHERE `user_id` = $current_user";
    $moodresult = $conn->query($sql);
    while($row = $moodresult->fetch_assoc()){
        $moodData[] = $row['mood'];
    };
  }
  else{
    $date[] = "";
    $moodData[] = "";
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="stylecalendar.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <meta charset="UTF-8">
    <title>Calendar</title>
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

    <div class="container">
      <div class="calendar">
        <div class="month">
          <i class="fas fa-angle-left prev"></i>
          <div class="date">
            <h1></h1>
            <p></p>
          </div>
          <i class="fas fa-angle-right next"></i>
        </div>
        <div class="weekdays">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>
        <div class="days"></div>
      </div>
    </div>

<script>
const date = new Date();

const renderCalendar = () => {
  date.setDate(1);

  const monthDays = document.querySelector(".days");

  const lastDay = new Date(
    date.getFullYear(),
    date.getMonth() + 1,
    0
  ).getDate();

  const prevLastDay = new Date(
    date.getFullYear(),
    date.getMonth(),
    0
  ).getDate();

  const firstDayIndex = date.getDay();

  const lastDayIndex = new Date(
    date.getFullYear(),
    date.getMonth() + 1,
    0
  ).getDay();

  const nextDays = 7 - lastDayIndex - 1;

  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  document.querySelector(".date h1").innerHTML = months[date.getMonth()];

  document.querySelector(".date p").innerHTML = new Date().toDateString();

  let days = "";

  for (let x = firstDayIndex; x > 0; x--) {
    days += `<div style="background-color:`+ coloring(date.getFullYear(),date.getMonth()-1,prevLastDay - x + 1) +`" class="prev-date" onclick="passtodiary(date.getFullYear(),date.getMonth()-1,${prevLastDay - x + 1})">${prevLastDay - x + 1}</div>`;
  }

  for (let i = 1; i <= lastDay; i++) {
    days += `<div style="background-color:`+ coloring(date.getFullYear(),date.getMonth(),i) +`" class="today" onclick="passtodiary(date.getFullYear(),date.getMonth(),${i})">${i}</div>`;
  }

  for (let j = 1; j <= nextDays; j++) {
    days += `<div style="background-color:`+ coloring(date.getFullYear(),date.getMonth()+1,j) +`" class="next-date" onclick="passtodiary(date.getFullYear(),date.getMonth() + 1,${j})">${j}</div>`;
  }
  monthDays.innerHTML = days;
};

document.querySelector(".prev").addEventListener("click", () => {
  date.setMonth(date.getMonth() - 1);
  renderCalendar();
});

document.querySelector(".next").addEventListener("click", () => {
  date.setMonth(date.getMonth() + 1);
  renderCalendar();
});

renderCalendar();

function addLeadingZeros(n) {
  if (n <= 9) {
    return "0" + n;
  }else{
    return n;
  }
}

function passtodiary(year, month, date){
  var fulldate = year+"-"+addLeadingZeros(month+1)+"-"+addLeadingZeros(date); 
  document.cookie = "current_date =" + fulldate;
  location.href = "Diary.php";
}

function coloring(year, month, date){
  var fulldate = year+"-"+addLeadingZeros(month+1)+"-"+addLeadingZeros(date); 
  var dates = <?php echo json_encode($date); ?>;
  var moodData = <?php echo json_encode($moodData); ?>;

  var entry = dates.indexOf(fulldate) 
  if (entry === -1){
    return "white";
  }else{
    var mood = moodData[entry];
    var r = 55 + mood*2;
    var b = 180 - mood;
    return ("rgb("+r+",127,"+b+")");
  }
}
</script>
  </body>
</html>
