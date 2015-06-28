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
/*
--------------------------------------------------------------------------------
LOADS LEFT MENU TO SHOW THE UPDATED INFORMATION
--------------------------------------------------------------------------------
*/
function load_left_menu() {
	var div = document.getElementById("left_menu");
	hr.open("POST", "/main/load_left_menu", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
	}
	hr.send();
}
/*--- ENTERS CASINO ----*/
function enter_casino(ar_id, casino_id) {
	var div = document.getElementById('city_zone');
	hr.open("POST", "/casino/enter_casino", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&casino_id="+casino_id+"&val=1";
	hr.send(t);
}
/**** END OF ENTER CASINO ****/

var pausee = 0;
var cas_id;
var area_to_pass;
/* MAKES THE BET */
function zaloji(casino_id, ar_id) {
	var div = document.getElementById('show');
	var zalog = document.getElementById('zalog').value;
	var toSend = "zalog="+zalog+"&casino_id="+casino_id+"&area_id="+ar_id+"&val=1";
	if(zalog>1) {
	hr.open("POST", "casino/make_bet", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200)
				if(hr.responseText == 'no_enough_energy') {
					alert("Нямате достатъчно енергия");
				} else if(hr.responseText == 'no_enough_money') {
					alert("Нямате достатъчно пари");
				} else if(hr.responseText == 'max_bet') {
					alert("Надвишавате максималният залог");
				} else {
					cas_id = casino_id;
					area_to_pass = ar_id;
					load_left_menu();
					var start = document.getElementById('sbut');
					var stop = document.getElementById('but');
					var zalogBut = document.getElementById('zalojogBut');
					start.disabled = false;
					stop.disabled = true;
					zalogBut.disabled = true;
				}
			}
	}
	hr.send(toSend);
	} else {
		alert("Минимален залог 1");
	}
}
function replace_fruits(div, one) {
	if(one == 1) {
		div.innerHTML = '<img src="/imgs/casino/one.png" width="200" height="200"/>';
	}
	if(one == 2) {
		div.innerHTML = '<img src="/imgs/casino/two.png" width="200" height="200"/>';
	}
	if(one == 3) {
		div.innerHTML = '<img src="/imgs/casino/three.png" width="200" height="200"/>';
	}
	if(one == 4) {
		div.innerHTML = '<img src="/imgs/casino/four.png" width="200" height="200"/>';
	}
	if(one == 5) {
		div.innerHTML = '<img src="/imgs/casino/five.png" width="200" height="200"/>';
	}
	if(one == 6) {
		div.innerHTML = '<img src="/imgs/casino/six.png" width="200" height="200"/>';
	}
}
/* MIXING NUMBER FROM 1 TO 6 */
function randomJS() {
	var zalog = document.getElementById('zalog').value;
	
	var start = document.getElementById('sbut');
	var stop = document.getElementById('but');
	start.disabled = true;
	stop.disabled = false;
	
	var div = document.getElementById('randNum');
	var div2 = document.getElementById('randNum2');
	var div3 = document.getElementById('randNum3');
	
	var toSend = "zalog="+zalog;
	if(zalog >= 1) {
		var one = Math.floor((Math.random() * 6) + 1);
		var two = Math.floor((Math.random() * 6) + 1);
		var three = Math.floor((Math.random() * 6) + 1);
		
		replace_fruits(div, one);
		replace_fruits(div2, two);
		replace_fruits(div3, three);
		
		if(pausee == 0) {
			setTimeout("randomJS()", 10);
		} else {
			sendToPhp(one, two, three, zalog, cas_id, area_to_pass);
			pausee = 0;
		}
	} else {
		alert("Минимален залог 1");
	}
}
/* PAUESES THE GAMEE */
function gase() {
	var zalog = document.getElementById('zalog').value;
	if(zalog >= 1) {
		pausee = 1;
		var stop = document.getElementById('but');
		stop.disabled = true;
		var zalogBut = document.getElementById('zalojogBut');
		zalogBut.disabled = false;
	} else {
		alert("Минимален залог 1");
	}
}
/* CHECKS FOR PRIZE */
function sendToPhp(one, two, three, zalog, casino_id, ar_id) {
	var div = document.getElementById('showInfo');
	
	var zalog = document.getElementById('zalog').value;
	var toSend = "one="+one+"&two="+two+"&three="+three+"&zalog="+zalog+"&casino_id="+casino_id+"&area_id="+ar_id+"&val=1";
	
	hr.open("POST", "casino/check_prize", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200)
				div.innerHTML = "Наградата е: "+hr.responseText;
				load_left_menu();
			}
	}
	hr.send(toSend);
	
}