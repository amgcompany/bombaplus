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
var count1;
var result = 0;
window.onload = function() {
	get_question_level(1);
	count1 = setInterval('timer()', 1000);
}
/*
------------------
TIMER CODE
------------------
*/
var seconds = 10; // How many seconds first question
var level = 1; // Timer get the level to redirect
var mbCounter = 0; // Counts maths redirections

function timer() {
	var count2, count3, count4;
    var rSeconds = seconds % 60;
    if (rSeconds < 10) {
        rSeconds = "0" + rSeconds;	
    }
    document.getElementById('countdown').innerHTML = rSeconds;
	if (seconds == 0) {
		alert("Времето ви изтече");
		window.location.href="http://bombaplus.com/";
		clearInterval(count1);
	} else {
		seconds--;
	}
}
/*
--------------
AJAX GETS FIRST LEVEL QUESTION
--------------
*/
function get_question_level(level) {
	var div = document.getElementById("load_uni_test");
	var spec_id = document.getElementById('get_spec_id').value;
	hr.open("POST", "/university/get_question_first_level", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "spec_id="+spec_id+"&level="+level+"&check=1";
	hr.send(t);
}
function check_question(correct, level) {
	var cor = document.getElementById("is_correct");
	if(correct == 1) {
		result += 1;
		$('#is_correct').show();
		cor.innerHTML = "<div class='true_ans'>Верен отговор</div>";
		setTimeout(function() {
			cor.innerHTML = "<div class='logged_true'></div>";
		}, 500);
		
	} else {
		$('#is_correct').show();
		cor.innerHTML = "<div class='red_tick'>Грешен отговор</div>";
		setTimeout(function() {
			cor.innerHTML = "<div class='logged_true'></div>";
		}, 500);
	}
	if(level == 1) {
		seconds = 15;
		get_question_level(2);
	}
	if(level == 2) {
		seconds = 15;
		get_question_level(3);
	}
	if(level == 3) {
		seconds = 15;
		test_result();
		clearInterval(count1);
		//window.location.href="http://192.168.0.123/result/show/"+result;	
	}
}
/* FUNCTION LOADS EXAM RESULT */
function test_result() {
	var div = document.getElementById("uni_test");
	var spec_id = document.getElementById('get_spec_id').value;
	var res = result;
	hr.open("POST", "/university/test_results", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
			}
		}
	}
	var t = "spec_id="+spec_id+"&result="+res+"&check=1";
	hr.send(t);
}