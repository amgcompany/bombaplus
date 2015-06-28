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
/*--- DELETE SHOP ARTICLE ---*/
function delete_shop_article(article) {
	var div = document.getElementById("sell_div_notification_"+article);
	hr.open("POST", "/shop/delete_article", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				window.location.href = "http://bombaplus.com/shop"; /* TO CHANGE URL */
				}
			}
	}
	var t = "article="+article+"&val=1";
	hr.send(t);
}
/**** END OF DELETEING ARTICLE ****/
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
/*--- BUYS PRODUCT FROM SHOP ---*/
function buy_thing_shop(article_id) {
	var div 	 = document.getElementById("sell_div_notification_"+article_id);
	var quantity = document.getElementById("product_quantity_"+article_id).value;
	
	hr.open("POST", "/shop/buy_product", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "article_id="+article_id+"&quantity="+quantity+"&val=1";
	hr.send(t);
}
/*--- END OF  BUYS PRODUCT FROM SHOP ---*/