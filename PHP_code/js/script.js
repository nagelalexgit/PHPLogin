function alarmFunction() {
  element = document.getElementById("bay1Button").className = "buttonAlarm";
  element = document.getElementById("bay1Button").innerHTML = 'Bay 1 <br> Abnormal delay <br> Request has been sent';
}
function pendingFunction() {
  element = document.getElementById("bay2Button").className = "buttonPending";
  element = document.getElementById("bay2Button").innerHTML = 'Bay 2 <br> Pending transfer';
}
function assignFunction() {
  element = document.getElementById("bay3Button").className = "buttonAssigned";
  element = document.getElementById("bay3Button").innerHTML = 'Bay 3 <br> Patient assigned';
}
function acceptedFunction() {
  element = document.getElementById("bay4Button").className = "buttonAccepted";
  element = document.getElementById("bay4Button").innerHTML = 'Bay 3 <br> Transfer accepted';
}
function defaultFunction() {
  element = document.getElementById("bay4Button").className = "button";
  element = document.getElementById("bay4Button").innerHTML = 'Bay 3 <br> Ready';
}
