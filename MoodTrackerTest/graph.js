const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
const MONTHS = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
var test = [Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101)]
var currentWeekData = [15, 48, 92, 60, 52, 78, 60]
var currentWeek = new Date();
currentWeek.setDate(currentWeek.getDate() - (currentWeek.getDay() + 6) % 7);

var config = {
    type: 'line',
    data: {
        labels: DAYS,
        datasets: [{
            label: 'Week Starting: ' + currentWeek.toDateString(),
            data: currentWeekData,
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
                    display: true,
                    labelString: 'Day'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'
                },
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

function getWeekValues(/*week requested*/) {
    return [Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101), Math.floor(Math.random() * 101)]
}

function getDayValue(/*requested day*/) {
    return Math.floor(Math.random() * 101)
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
        backgroundColor: 'rgba(133, 0, 240)',
        borderColor: 'rgba(133, 0, 240)',
        data: getWeekValues(/*pass current week*/),
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
            backgroundColor: 'rgba(133, 0, 240)',
            borderColor: 'rgba(133, 0, 240)',
            data: getWeekValues(/*pass current week*/),
            fill: false
        };
        
        console.log('success')   
        config.data.datasets.push(newDataset)
        window.myLine.update();
    }
});

document.getElementById('viewMonth').addEventListener('click', function() {
    config.data.datasets.splice(0, 1);
    window.myLine.update();

    var dataMonth = []

    var month = currentWeek.getMonth();
    console.log(month);

    var year = currentWeek.getFullYear();
    console.log(year);
    
    var numDays = new Date(year, month+1, 0).getDate();
    console.log(numDays);

    var Days = [];
    for (i = 1; i <= numDays; i++) {
        Days = Days.concat(i);
    }
    console.log(Days);

    for (i=0; i < 7; i++) {
        config.data.labels.pop()
    }

    for (i=0; i < Days.length; i++) {
        config.data.labels.push(Days[i])
    }

    for (i=0; i < Days.length; i++) {
        dataMonth = dataMonth.concat(getDayValue())
    }

    var newDataset = {
            label: MONTHS[month],
            labels: Days,
            backgroundColor: 'rgba(133, 0, 240)',
            borderColor: 'rgba(133, 0, 240)',
            data: dataMonth,
            fill: false
        };

    config.data.datasets.push(newDataset)
    window.myLine.update();
});