
var delay = 1000;

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
  alert("Patient assigned successful");
}
function acceptedFunction(id) {
  element = document.getElementById(id).className = "buttonAccepted";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ " <br> Transfer accepted";
  alert("Request for transfer is accepted");
}
function defaultFunction(id) {
  element = document.getElementById(id).className = "button";
  element = document.getElementById(id).innerHTML = "Bay " +id.slice(-1)+ "<br> Ready";
}
function callMe() {
  alert("ihdioeragheoigashiogsergseriogsi");
}
function assignTimeOut(id,status) {
  setTimeout(callMe,delay);
}
