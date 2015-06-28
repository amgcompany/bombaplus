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
function show_upload_avatar() {
	var div = document.getElementById("buy_area_div_overlay");
	div.style.visibility = "visible";
}
function hide_upa() {
	var div = document.getElementById("buy_area_div_overlay");
	div.style.visibility = "hidden";
}
function show_send_mess() { 
	var div = document.getElementById("send_message_overlay");
	div.style.visibility = "visible";
}
function hide_sm() {
	var div = document.getElementById("send_message_overlay");
	div.style.visibility = "hidden";
}
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
/* LOADS CONVERSATION WITH HASH */
function load_conversation(hash) {
	var div = document.getElementById("chat_box");
		
	hr.open("POST", "/main/load_conversation/"+hash, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_chat_container(hash);
				}
			}
	}
	hr.send();
}