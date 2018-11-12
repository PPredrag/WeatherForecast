var timer = document.getElementById('timer');
var loop;

function displayTime(){
	var now = new Date();
	var hours = now.getHours();
	var minutes = now.getMinutes();
	var seconds = now.getSeconds();

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    
	timer.innerHTML = hours+':'+minutes+':'+seconds;
	var att = document.createAttribute("style");     
	att.value = "font-weight:bold;color: #009ad8";                      
	timer.setAttributeNode(att);
}
loop = setInterval(displayTime, 1000);