/* parse json array */
var requestURL = 'https://newschapmj1.github.io/testweb1/test3.json'
var request = new XMLHttpRequest();
request.open('GET', requestURL);

request.responseType = 'json';
request.send();

request.onload = function() {
  var walks = request.response;
  console.log(walks);
  //populateHeader(walks);
  //showWalk(walks);
  //var obj = JSON.parse(walks);
  console.log(walks[0]);
  console.log(walks[0].Detail);
  console.log(walks[0].Summary);
  console.log(walks[0].Date);
  console.log(walks[0].Distance);
  console.log(walks[0].GridRef);
  //console.log(walks[1].Detail);
}