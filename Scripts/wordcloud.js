// function to return an array with no repeated elements
function Unique(value, index, self) {
    return self.indexOf(value) === index;
}

var words = db_texts.join().split(",");
var data = [];

// ensuring that only one instance of the word is displayed in the wordcloud
var labels = words.filter(Unique);

// create an array of objects for the data
for (i in labels){
    obj = {"x": labels[i], "value": 0};
    data.push(obj);
}
// increment the value of each object for every occurence of the word in words
for (i in words){
    for (j in data){
        if (words[i] == data[j].x){
            data[j].value += 1;
        }
    }
}
anychart.onDocumentReady(function () {
  // create tag cloud
  var chart = anychart.tagCloud(data);
  // set chart title
  chart
    .title(
      charttitle
    )
    // set array of angles, by which words will be placed
    .angles([0])
    // enabled color range
    .colorRange(true)
    // set color scale
    .colorScale(anychart.scales.ordinalColor())
    // set settings for normal state
    .normal({
      fontFamily: 'Times New Roman'
    })
    // set settings for hovered state
    .hovered({
      fill: '#df8892'
    })
    // set settings for selected state
    .selected({
      fill: '#df8892',
      fontWeight: 'bold'
    });

  // set container id for the chart
  chart.container('container');
  // initiate chart drawing
  chart.draw();
});  
