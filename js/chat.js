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

/* SHOWS CHAT BOX */
function chat_box() {
	load_convs();
}
var refreshIntervalId;
/* LOADS CONVERSATIONS */
function load_convs() {
	var div = document.getElementById("chat_box");
	
	hr.open("POST", "/main/load_conversations", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
	}
	hr.send();
	clearInterval(refreshIntervalId)
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
function scroll_bottom() {
	var objDiv = document.getElementById("chat_container");
	objDiv.scrollTop = objDiv.scrollHeight;
}
/* LOADS THE CHAT_CONTAINER DIV WITH THE CONTENT OF THE CONVERSATION */
function load_chat_container(hash) {
	var div = document.getElementById("chat_container");
	//scroll_bottom();
	
	hr.open("POST", "/main/load_chat_container/"+hash, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				refreshIntervalId = setInterval(load_chat_container(hash), 1000);
				}
			}
	}
	hr.send();
}
/* SENDS MESSAGE */
function send_chat_message(from, to, hash) {
	var message = document.getElementById("chat_mess").value;
	var but = document.getElementById("send_mess_but");
	var t = "message="+message+"&from="+from+"&to="+to;
	
	if(message.length>1) {
		hr.open("POST", "/messages/send_message", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					document.getElementById("chat_mess").value = "";
					load_chat_container(hash);
					}
				}
		}
		hr.send(t);
	} else {
		alert("Съобщението не може да е празно");
	}
}
function on_enter_press_chat(e, from, to, hash) {
	if (e.keyCode == 13) {
        send_chat_message(from, to, hash);
    }
}