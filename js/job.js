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
/*
----------------------------------------------------
			# LOADS JOB VIEW #
---------------------------------------------------
*/
function load_job_view() {
	var div = document.getElementById("job");
	hr.open("POST", "/job/load_view", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "val=1";
	hr.send();
}
/*
----------------------------------------------------
					# WORK #
---------------------------------------------------
*/
function work() {
	var div = document.getElementById("build_mansions_not_div");
	hr.open("POST", "/job/work", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_energy') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
				} else {
					load_job_view();
				}
			}
		}
	}
	var t = "val=1";
	hr.send(t);
}
/*
----------------------------------------------------
				# QUIT JOB #
---------------------------------------------------
*/
function quit_job(url) {
	var div = document.getElementById("build_mansions_not_div");
	hr.open("POST", "/job/quit_job", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'six_hours_later') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Може да напуснете най-рано 6 часа, след като сте започнали</span></div>";
				} else {
					div.innerHTML = "<div class='sell_not'><span class='sell_green'>Написнахте успешно</span></div>";
					window.location.href = url;
				}
			}
		}
	}
	var t = "val=1";
	hr.send(t);
}