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
    days += `<div class="prev-date" onclick="passtodiary(date.getFullYear(),date.getMonth()-1,${prevLastDay - x + 1})">${prevLastDay - x + 1}</div>`;
  }

  for (let i = 1; i <= lastDay; i++) {
    if (
      i === new Date().getDate() &&
      date.getMonth() === new Date().getMonth()
    ) {
      days += `<div class="today" onclick="passtodiary(date.getFullYear(),date.getMonth(),${i})">${i}</div>`;
    } else {
      days += `<div onclick="passtodiary(date.getFullYear(),date.getMonth(),${i})">${i}</div>`;
    }
  }

  for (let j = 1; j <= nextDays; j++) {
    days += `<div class="next-date" onclick="passtodiary(date.getFullYear(),date.getMonth() + 1,${j})">${j}</div>`;
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
    return "#74badbff";
  }else{
    var mood = moodData[entry]''
    var r = 55 + mood*2;
    var b = 180 - mood
    return ("rgb("+r+",127,"+b+")");
  }
}

var orange = coloring(2021,3,14);
console.log(orange)