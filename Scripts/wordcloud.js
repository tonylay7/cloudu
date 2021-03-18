// function to return an array with no repeated elements
function Unique(value, index, self) {
    return self.indexOf(value) === index;
}

var pos = require('pos');
var text = new pos.Lexer().lex(db_text);
var tagger = new pos.Tagger();
var taggedWords = tagger.tag(text);
var finalWords = [];
var commonDeletedWords = ["are"] // common words that are detected by the tagger as nouns but aren't useful
var data = [];

// convert the raw data into lists
var addWords = db_addwords.split(", ");
var removeWords = db_removewords.split(", ");

// retrieve words that are singular nouns or plural nouns
for (i in taggedWords) {
  var taggedWord = taggedWords[i];
  if (taggedWord[1] == "NN" || taggedWord[1] == "NNS"){
    if (taggedWord[0].length > 2){
      finalWords.push(taggedWord[0])
    } 
  }
}
// remove common words that aren't useful
finalWords = finalWords.filter( function(x) {
  return commonDeletedWords.indexOf(x) < 0;
} );

// remove words as specified by the user
finalWords = finalWords.filter( function(x) {
  return removeWords.indexOf(x) < 0;
} );

// add words as specified by the user
for (i in addWords){
  if (i in text){
    finalWords.push(addWords[i])
  }
}
// ensuring that only one instance of the word is displayed in the wordcloud
var labels = finalWords.filter(Unique);

// create an array of objects for the data
for (i in labels){
    obj = {"x": labels[i], "value": 0};
    data.push(obj);
}
// increment the value of each object for every occurence of the word in finalWords
for (i in finalWords){
    for (j in data){
        if (finalWords[i] == data[j].x){
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
