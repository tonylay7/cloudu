// function to return an array with no repeated elements
function Unique(value, index, self) {
    return self.indexOf(value) === index;
}

var pos = require('pos');
var text = new pos.Lexer().lex("I made new friends at school which I am very happy about. Also since today was my birthday I received some nice gifts such as money from my uncle, clothes from my grandma and some jewellery from my mum! I appreciate all of their gifts.")
var tagger = new pos.Tagger();
var taggedWords = tagger.tag(text);
var filteredWords = [];
var data = [];
// retrieve words that are singular nouns or plural nouns
for (i in taggedWords) {
    var taggedWord = taggedWords[i];
    if (taggedWord[1] == "NN" || taggedWord[1] == "NNS"){
        filteredWords.push(taggedWord[0])
    }
}
var labels = filteredWords.filter(Unique);
// create an array of objects for the data
for (i in labels){
    obj = {"x": labels[i], "value": 0};
    data.push(obj);
}
// increment the value of each object for every occurence of the word in filteredWords
for (i in filteredWords){
    for (j in data){
        if (filteredWords[i] == data[j].x){
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
      "Top Things that you're grateful for!"
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
