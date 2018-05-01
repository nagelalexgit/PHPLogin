
var delay = 15000;

function alarmFunction(id) {
  element = document.getElementById(id).className = "buttonAlarm";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ " <br> Abnormal delay <br> Request has been sent";

}

function pendingFunction(id) {
  element = document.getElementById(id).className = "buttonPending";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ " <br> Pending transfer";
}
function assignFunction(id) {
  element = document.getElementById(id).className = "buttonAssigned";
  element = document.getElementById(id).innerHTML = "Bay " + id.slice(-1) + "<br> Patient assigned";
}
function acceptedFunction(id) {
  element = document.getElementById(id).className = "buttonAccepted";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ " <br> Transfer accepted <br> <p id='countDown'></p>";
}
function defaultFunction(id) {
  element = document.getElementById(id).className = "button";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ "<br> Ready";
}
function assignTimeOut(id,status) {
  setTimeout(callMe,delay);
}
var myTimer = setInterval(myClock, 1000);
function myClock() {
  document.getElementById("demo").innerHTML =
  new Date().toLocaleTimeString();
}
function clearField() {
  var i;
  for (i = 0; (i < document.forms.length); i++) {
    document.forms[i].reset();
  }
}
function clearTimeOut() {
  setTimeout(clearField,delay);
}
// Set the date we're counting down to
var countDownDate = new Date("May 1, 2018 15:40:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

  // Time calculations for minutes and seconds
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("countDown").innerHTML = minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countDown").innerHTML = "EXPIRED";
    alarmFunction("bay4");
  }
}, 1000);
