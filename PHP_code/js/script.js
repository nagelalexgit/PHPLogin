
var delay = 1000;

function alarmFunction(id) {
  element = document.getElementById(id).className = "buttonAlarmRW";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ " <br> Abnormal delay <br> request has been resent";

}

function pendingFunction(id) {
  element = document.getElementById(id).className = "buttonRequested";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ " <br> Transfer requested";
}
function assignFunction(id) {
  element = document.getElementById(id).className = "buttonParked";
  element = document.getElementById(id).innerHTML = "Bay " + id.slice(-1) + "<br> Patient parked";
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
  element = document.getElementById('fname').value= "";
  element = document.getElementById('sname').value = "";
  }
function clearTimeOut() {
  setTimeout(clearField,delay);
}
// Set the date we're counting down to
var countDownDate = new Date("May 18, 2018 13:22:25").getTime();

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
    alarmFunction("bay4");
  }
}, 1000);
// getStatus
function getBayStatus(){
  jQuery.ajax({
  type: "POST",
  url: 'getStatus.php',
  dataType: 'json',
  data: {functionname: 'add'},

  success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    yourVariable = obj.result;
                }
                else {
                    console.log(obj.error);
                }
          }
});
}
