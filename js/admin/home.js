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
/*
--------------
AJAX LOADS ADD CATEGORY
--------------
*/
function load_table(table) {
	var div = document.getElementById("admin_cont");

	hr.open("POST", "/admin/table/index/"+table, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
--------------
AJAX LOADS USERS in ADMIN PANEL
--------------
*/
function load_users() {
	var div = document.getElementById("admin_cont");

	hr.open("POST", "/admin/home/users", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
	SHOWS DB TABLES
*/
function show_tables() {
	document.getElementById("ul_dbs").style.display = "block";
}
/*
	SHOWS ADMINS
*/
function show_admins() {
	load_admins();
	document.getElementById("ul_admins").style.display = "block";
}
/*
--------------
LOOKING FOR USER
--------------
*/
function search_user() {
	var div = document.getElementById("show_user");
	var user = document.getElementById("ussearch").value;
	var t = "username="+user;
	hr.open("POST", "/admin/home/search_user", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	hr.send(t);
}
/*
--------------
LOADS BUGS
--------------
*/
function load_bugs() {
	var div = document.getElementById("admin_cont");
	hr.open("POST", "/admin/bugs", true);
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
--------------
ADDS BUGS
--------------
*/
function add_bug() {
	var div = document.getElementById("admin_cont");
	var desc = document.getElementById("description").value;
	var where = document.getElementById("page").value;
	var type = document.getElementById("bug_type").value;
	
	if(desc.length>=10 && type>=1 && type<=2) {
		var bug = "bug="+desc+"&where="+where+"&type="+type;
		hr.open("POST", "/admin/bugs/add_bugs", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					div.innerHTML = hr.responseText;
					load_bugs();
					}
				}
			}
		hr.send(bug);
	} else {
		alert("Грешка с валидацията \nВъзможни причини:\nНеизбран тип\nПоне 10 символа за обяснение");
	}
}
/*
--------------
REPAIRS BUGS
--------------
*/
function repair_bug(id) {
	var r = confirm("Сигурни ли сте, че искате да маркирате този бъг като оправен");
	if(r == true) {
		var div = document.getElementById("admin_cont");
		hr.open("POST", "/admin/bugs/repair_bug/"+id, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					div.innerHTML = hr.responseText;
					load_bugs();
					}
				}
			}
		hr.send();
	}
}
/*
--------------
DELETES BUGS
--------------
*/
function delete_bug(id) {
	var r = confirm("Сигурни ли сте, че искате да изтриете този бъг");
	if(r == true) {
		var div = document.getElementById("admin_cont");
		hr.open("POST", "/admin/bugs/delete_bug/"+id, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					div.innerHTML = hr.responseText;
					load_bugs();
					}
				}
			}
		hr.send();
	}
}
/*
--------------
LOADS ADMINISTRATORS
--------------
*/
function load_admins() {
	var div = document.getElementById("admin_cont");

	hr.open("POST", "/admin/administrators", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
--------------
LOADS ADMIN LOGIN ATTEMPTS
--------------
*/
function load_admin_attempts() {
	var div = document.getElementById("admin_cont");

	hr.open("POST", "/admin/administrators/login_attempts", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
--------------
LOADS CREATE ADMIN
--------------
*/
function create_admin() {
	var div = document.getElementById("admin_cont");

	hr.open("POST", "/admin/administrators/create_admin", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
--------------
LOOKING FOR USER TO BE CREATED ADMIN
--------------
*/
function search_admin_user() {
	var div = document.getElementById("show_create_admin_user");
	var user = document.getElementById("ussearch").value;
	var t = "username="+user;
	hr.open("POST", "/admin/administrators/create_admin_search_user", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	hr.send(t);
}
/*
--------------
LOADS GENEREATING AREAS
--------------
*/
function load_areas() {
	var div = document.getElementById("admin_cont");
	hr.open("POST", "/admin/areas", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
*********************
GENEREATING AREAS
*********************
*/
function generete_area() {
	var city, zone, numb;
	city = document.getElementById("admin_select_city").value;
	zone = document.getElementById("admin_select_zone").value;
	numb = document.getElementById("areas_to_generate").value;
	space = document.getElementById("areas_space").value;
	
	
	var div = document.getElementById("admin_cont");
	
	if(numb.length>=1) {
		hr.open("POST", "/admin/areas/generate_areas", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					div.innerHTML = "Генерирани успешно "+numb+" площи";
					}
				}
			}
		var t = "city="+city+"&zone="+zone+"&numb="+numb+"&space="+space;
		hr.send(t);
	} else {
		alert("error");
	}
}
/*
*********************
VISITS VIEW
*********************
*/
function load_visits() {
	var div = document.getElementById("admin_cont");
	hr.open("POST", "/admin/visits", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/*
************************************************************************************
							LOADS DESTROY BUILDING VIEW
************************************************************************************
*/
function load_destroy() {
	var div = document.getElementById("admin_cont");
	hr.open("POST", "/admin/destroy", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "check="+1;
	hr.send(t);
}
/****  END OF load_destroy ****/
/*
************************************************************************************
						DESTROY BUILDING
************************************************************************************
*/
function destroy_building() {
	var div = document.getElementById("admin_cont");
	var destroy_type = document.getElementById("destroy_type").value;
	var destroy_property_id = document.getElementById("destroy_property_id").value;
	hr.open("POST", "/admin/destroy/destroy_it", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
		}
	var t = "destroy_type="+destroy_type+"&destroy_property_id="+destroy_property_id;
	hr.send(t);
}
/****  END OF load_destroy ****/