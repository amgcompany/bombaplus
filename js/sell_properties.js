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
/* ONLY NUMBERS IN TEXT FIELDS */
function validate(evt) {
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
		}
}
/*-- LOADING USER'S PROPERTIES ABOUT AREA shop_cat_id --*/
function get_sell_category(category) {
	var div = document.getElementById("sell_users_properties");
	hr.open("POST", "/sell/get_sell_category", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
	}
	var t = "category="+category+"&val=1";
	hr.send(t);
}
/*-- INSERTS INTO SHOP ARTICLES --*/
function sell_shop(sub_category, category) {
	var div = document.getElementById("sell_div_notification_"+sub_category);
	var quantity = document.getElementById("quantity_"+sub_category).value;
	var prize = document.getElementById("prize_"+sub_category).value;
	hr.open("POST", "/sell/sell_it", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
	}
	var t = "category="+category+"&subcategory="+sub_category+"&prize="+prize+"&quantity="+quantity+"&val=1";
	hr.send(t);
}