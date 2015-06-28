/*
-------------
XMLHttpRequest
------------
*/
var hr = createXML();
function createXML() {
	var hr;
	if(window.XMLHttpRequest) {
		hr = new XMLHttpRequest();
	} else {
		hr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(!hr) {
		alert("error with ajax");
	} else {
		return hr;
	}
}
window.onload = function() {
	//var objDiv = document.getElementById("convesation");
	//objDiv.scrollTop = objDiv.scrollHeight;
}
/*
--------------
SENDS MESSAGES
--------------
*/
function send_message(from, to) {
	var div = document.getElementById("suc_send");
	var message = document.getElementById("mess_content").value;
	var t = "message="+message+"&from="+from+"&to="+to;
	
	if(message.length>1) {
		hr.open("POST", "/messages/send_message", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					div.innerHTML = hr.responseText;
					document.getElementById("mess_content").value = '';
					}
				}
		}
		hr.send(t);
	} else {
		alert("Съобщението не може да е празно");
	}
}
function on_enter_press(e, from, to) {
	if (e.keyCode == 13) {
        send_message(from, to);
    }
}