/* parse json array */
var requestURL = 'https://newschapmj1.github.io/testweb1/test2.json'
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
  console.log(walks[0].Detail);
}