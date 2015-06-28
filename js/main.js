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
--------------
SOME VARIABLES 
-------------
*/
var area_id;
var more_area_id;
var buy_area_button = document.getElementById('buy_area_button');
var zone_id = document.getElementById("hidden_zone_id").value;
var page = document.getElementById("hidden_page_number").value;
var zone_hid_id = document.getElementById("hidden_zone_hide_id").value;
/* 
--------------
END OF SOME VARIABLES 
-------------
*/
window.onload = function() {
	//load_build_tomatos(26);
	//admin_dairy_farm(25);
	//load_build_cow(24);
	//university_admin(9, 1);
	//load_build_university(9);
	//enter_casino(7, 1);
	//load_build_casino(7);
	//enter_restaurant(5, 1);
	//load_build_restaurant(6, 7);
	//enter_bank(3, 3);
	//load_build_bank(3,2);
	//enter_mansions(1);
	//load_build_apartment(1,1);
	//load_choose_build(1);
	if(zone_hid_id == 1) {
		load_center_areas_view(zone_id, 0);
	} else if(zone_hid_id == 2) {
		zone_id = 2;
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
/* SHOWS buy_area_div */
function show_buyarea_div(ar_id) {
	var div = document.getElementById("buy_area_div_overlay");
	div.style.visibility = "visible";
	area_id = ar_id;
	buy_area_button.disabled = false;
}
/* HIDES buy_area_div */
function hide_buy_area_div() {
	var div = document.getElementById("buy_area_div_overlay");
	div.style.visibility = "hidden";
	buy_area_button.disabled = true;
}
/* SHOWS buy_area_div */
function show_more_buyarea_div(ar_id) {
	var div = document.getElementById("buy_morearea_div_overlay");
	div.style.visibility = "visible";
	more_area_id = ar_id;
}	
/* HIDES buy_area_div */
function hide_morebuy_area_div() {
	var div = document.getElementById("buy_morearea_div_overlay");
	div.style.visibility = "hidden";
	buy_area_button.disabled = true;
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
--------------------------------------------------------------------------------
LOADS AREAS VIEWS
--------------------------------------------------------------------------------
*/
function load_center_areas_view(zone_id, page) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/main/load_areas_view", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(page == 0) {
					div.innerHTML = hr.responseText;
				} else {
					if(zone_id == 2 && page>0) {
						window.location.href = "http://192.168.0.123/living_area/index/"+page;
					} else if(zone_id == 3 && page>0) {
						window.location.href = "http://192.168.0.123/industrial/index/"+page;
					}
				}
				
				}
			}
	}
	var t = "zone_id="+zone_id+"&val=1";
	hr.send(t);
}

/*
--------------------------------------------------------------------------------
LOADS TOP CENTRE CITY
--------------------------------------------------------------------------------
*/
function load_city_center() {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/main/load_areas_view", true); // load_center
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	hr.send();
}
/*
--------------------------------------------------------------------------------
CALCULATES HOW MUCH MONEY THE USER WILL NEED TO BUY THE AREA
--------------------------------------------------------------------------------
*/
function calculate_buy_area(per_met, space) {
	var div = document.getElementById("text_buyarea_calculated");
	var metres = document.getElementById("area_buy_space_wanted").value;
	var sum = per_met * metres // per_met is how much it costs per meter
	if(metres<100) {
		div.innerHTML = "Трябва да купите минимум 100 кв.м";
		div.style.color = "#730404";
	} else if(metres>space) {
		div.innerHTML = "Може да купите до "+space+" кв.м";
		div.style.color = "#730404";
	} else {
		div.innerHTML = "Цена за "+metres+" кв.м: "+sum;
		div.style.color = "#2f5f95";
	}
}
/*
--------------------------------------------------------------------------------
CALCULATES HOW MUCH MONEY THE USER WILL NEED TO BUY THE AREA
--------------------------------------------------------------------------------
*/
function calculate_industrial_buy_area(per_met, space) {
	var div = document.getElementById("text_buyarea_calculated");
	var metres = document.getElementById("area_buy_space_wanted").value;
	var sum = per_met * metres // per_met is how much it costs per meter
	if(metres<15) {
		div.innerHTML = "Трябва да купите минимум 15 декара";
		div.style.color = "#730404";
	} else if(metres>space) {
		div.innerHTML = "Може да купите до "+space+" декара";
		div.style.color = "#730404";
	} else {
		div.innerHTML = "Цена за "+metres+" декара: "+sum;
		div.style.color = "#2f5f95";
	}
}
/*
--------------------------------------------------------------------------------
BUYS AREA AND MAKES CONNECTION WITH THE CONTROLLER TO SEND THE INFO TO THE MODEL
--------------------------------------------------------------------------------
*/
function buy_area(cena, user_id, page) {
	var div = document.getElementById("sa");
	var textarea = document.getElementById("text_buyarea_calculated");
	var metres = document.getElementById("area_buy_space_wanted").value;
	var sum = cena * metres;
	
	var info = "area_id="+area_id+"&user_id="+user_id+"&space="+metres+"&sum="+sum+"&validator=1";
	if(metres<100) {
		textarea.innerHTML = "Трябва да купите минимум 100 кв.м";
	} else if(metres>5000) {
		textarea.innerHTML = "Може да купите до "+5000+" кв.м";
	} else {
		hr.open("POST", "/main/buy_area/", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_energy') {
						textarea.innerHTML = "Нямате достатъчно енергия";
					} else if(hr.responseText == 'no_enough_money') {
						textarea.innerHTML = "Нямате достатъчно пари, за да купите "+metres+" кв.м.";
					} else {
						if(page == 0) {
							load_center_areas_view(zone_id, page);
							document.getElementById("area_buy_space_wanted").value = '';
							hide_buy_area_div();
						} else {
							window.location.href = "http://192.168.0.123/living_area/index/"+page;
						}
					}
				}
			}
		}
		hr.send(info);
	}
}
/*
--------------------------------------------------------------------------------
BUYS AREA INDUSTRIAL
--------------------------------------------------------------------------------
*/
function buy_industrial_area(cena, user_id, page) {
	var div = document.getElementById("sa");
	var textarea = document.getElementById("text_buyarea_calculated");
	var metres = document.getElementById("area_buy_space_wanted").value;
	var sum = cena * metres;
	
	var info = "area_id="+area_id+"&user_id="+user_id+"&space="+metres+"&sum="+sum+"&validator=1";
	if(metres<15) {
		textarea.innerHTML = "Трябва да купите минимум 15 декара";
	} else if(metres>900) {
		textarea.innerHTML = "Може да купите до "+900+" декара";
	} else {
		hr.open("POST", "/industrial/buy_area/", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						textarea.innerHTML = "Нямате достатъчно пари, за да купите "+metres+" декара";
					} else if(hr.responseText == 'no_enough_energy') {
						textarea.innerHTML = "Нямате достатъчно енергия";
					} else {
						if(page == 0) {
							load_center_areas_view(zone_id, page);
							document.getElementById("area_buy_space_wanted").value = '';
							hide_buy_area_div();
						} else {
							window.location.href = "http://192.168.0.123/industrial/index/"+page;
						}
					}
				}
			}
		}
		hr.send(info);
	}
}
/*
--------------------------------------------------------------------------------
LOADS BUILDING VIEWS
--------------------------------------------------------------------------------
*/
function load_choose_build(ar_id) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/main/choose_what_to_build", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				//load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
LOADS LEFT BUILD APARTMENT
--------------------------------------------------------------------------------
*/
function load_build_apartment(ar_id, cat) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/main/load_view_build_apartments", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&cat="+cat+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
BUYS MORE AREA
--------------------------------------------------------------------------------
*/
function calculate_buymore_area(per_met, space, min) {
	var div = document.getElementById("text_buyarea_calculated");
	var metres = document.getElementById("area_buy_space_wanted").value;
	var sum = per_met * metres // per_met is how much it costs per meter
	if(metres<min) {
		div.innerHTML = "Трябва да купите минимум "+min+" кв.м";
	} else if(metres>space) {
		div.innerHTML = "Може да купите до "+space+" кв.м";
	} else {
		div.innerHTML = "Цена за "+metres+" кв.м: "+sum;
	}
}
function buy_more_area(cena, ar_id, func, param) {
	var div = document.getElementById("build_mansions_not_div");
	var textarea = document.getElementById("text_buyarea_calculated");
	var metres = document.getElementById("area_buy_space_wanted").value;
	var sum = cena * metres;
	
	var info = "area_id="+ar_id+"&space="+metres+"&sum="+sum+"&validator=1";
	if(metres<10) {
		textarea.innerHTML = "Трябва да купите минимум 10 кв.м";
	} else if(metres>5000) {
		textarea.innerHTML = "Може да купите до "+5000+" кв.м";
	} else {
		hr.open("POST", "/main/buy_more_area/", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да купите "+metres+"кв.м</span></div>";
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
					} else {
						div.innerHTML = hr.responseText;
						func(ar_id, 0);
						document.getElementById("area_buy_space_wanted").value = '';
					}
					//load_build_apartment(ar_id, 1);
					hide_morebuy_area_div();
					}
				}
		}
		hr.send(info);
	}
}
/*
BUYS ALLOWANCE TO BUILD 
*/
function buy_allow_build(ar_id, func) {
	var div = document.getElementById("build_mansions_not_div");
	hr.open("POST", "/main/buy_allow_build/", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_enough_money') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да купите "+metres+"кв.м</span></div>";
				} else if(hr.responseText == 'no_enough_energy') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
				} else {
					div.innerHTML = "<div class='sell_not'><span class='sell_green'>Купихте разрешително за строеж</span></div>";
					func(ar_id, 0);
				}
			}
		}
	}
	var info = "area_id="+ar_id+"&validator=1";
	hr.send(info);
}
/*
--------------------------------------------------------------------------------
BUILDS APARTMENTS
--------------------------------------------------------------------------------
*/
function build_apartments(ar_id, level, howmuch) {
	var div = document.getElementById("build_mansions_not_div");
	hr.open("POST", "/main/build_apartments", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_enough_money') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да започенете строеж</span></div>";
				} else if(hr.responseText == 'no_enough_energy') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
				} else {
					alert("Вие построихте блок ниво "+level);
					load_left_menu();
					load_build_apartment(ar_id, 1);
				}
			}
		}
	}
	var t = "area_id="+ar_id+"&howmuch="+howmuch+"&level="+level+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
ENTER MANSIONS FOR USERS WHO ARE NOT OWNERS OF THE BLOCK
--------------------------------------------------------------------------------
*/
function enter_mansions(ar_id) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/main/enter_mansions", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
DESIFNES APARTMENT'S PRIZE
--------------------------------------------------------------------------------
*/
function define_apartment_prize(ar_id) {
	var div = document.getElementById("show_prize_result");
	var price = document.getElementById("apartmen_define_price").value;
	
	hr.open("POST", "/apartments/define_prize", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_build_apartment(ar_id, 1);
				}
			}
	}
	var t = "area_id="+ar_id+"&price="+price+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
BUYS APARTMENT
--------------------------------------------------------------------------------
*/
function buy_apartment(apart_id, ar_id, mansions_owner, price) {
	var div = document.getElementById("build_mansions_not_div");
	
	hr.open("POST", "/apartments/buy_apartment", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_enough_money') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да купите апартамент</span></div>";
				} else if(hr.responseText == 'no_enough_energy') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия, за да купите апартамент</span></div>";
				} else if(hr.responseText == 'apartment_bought') {
					div.innerHTML = "<div class='sell_not'><span class='sell_green'>Вие купихте апартамент</span></div>";
					enter_mansions(ar_id);
				}
				}
			}
	}
	var t = "apart_id="+apart_id+"&area_id="+ar_id+"&mansions_owner="+mansions_owner+"&price="+price+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
GIVES THE OPPORTUNITY OF THE MANSIONS OWNER TO LIVE IN HIS OWN BUIDLING
--------------------------------------------------------------------------------
*/
function live_here(apart_id, ar_id) {
	hr.open("POST", "/apartments/live_here", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				load_build_apartment(ar_id, 1);
				}
			}
	}
	var t = "apart_id="+apart_id+"&area_id="+ar_id+"&val=1";
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
SETS APARTMENT FROM BUSY TO FREE
--------------------------------------------------------------------------------
*/
function set_free_apart(apart_id, ar_id) {
	hr.open("POST", "/apartments/set_free_apartment", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				load_build_apartment(ar_id, 1);
				}
			}
	}
	var t = "apart_id="+apart_id+"&area_id="+ar_id+"&val=1";
	hr.send(t);
}

/*
#-------------------------------------------------------------------------
#							| BUILDING BANK |
#-------------------------------------------------------------------------
*/
/* LOADS DIV TO BUILD BANK */
function load_build_bank(ar_id, cat) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/bank_build/load_build", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t);
}
/* CREATES/BUILDS BANK */
function build_bank(ar_id) {
	var sum = document.getElementById("bank_sum_start").value;
	hr.open("POST", "/bank_build/build_bank", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				load_build_bank(ar_id, 2);
				}
			}
	}
	var t = "area_id="+ar_id+"&sum="+sum+"&zone_id="+zone_id+"&val=1";
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
ENTER BLOCK FOR USERS WHO ARE NOT OWNERS OF THE BLOCK
--------------------------------------------------------------------------------
*/
function enter_bank(ar_id, bank_id) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/bank_build/enter_bank", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&bank_id="+bank_id+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
GETS FAST CREDIT
--------------------------------------------------------------------------------
*/
function get_credit(bank_id, ar_id) {
	var div = document.getElementById("credit_notification");
	var sum = document.getElementById("credit_sum").value;
	if(sum<=5000 && sum>=500) { 
		hr.open("POST", "/bank_build/get_fast_credit", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = 'Нямате достатъчно енергия, за да изтеглтие кредит';
					} else if(hr.responseText == 'fast_credit_ready') {
						div.innerHTML = 'Успешно изтеглихте кредит';
						enter_bank(ar_id, bank_id);
					} else if(hr.responseText == 'no_such_bank') {
						div.innerHTML = "Няма такава банка";
					}
					}
				}
		}
		var t = "area_id="+ar_id+"&bank_id="+bank_id+"&sum="+sum+"&val=1"
		hr.send(t);
	} else if(sum>5000) {
		div.innerHTML = "Може да теглите само до 5000";
	} else if(sum<500) {
		div.innerHTML = "Минимумът за теглене е 500";
	}
}
/*
--------------------------------------------------------------------------------
INSERTS CREDIT PAYMENT
--------------------------------------------------------------------------------
*/
function credit_payment(credit_id, payment, ar_id, bank_id) {
	var div = document.getElementById("not");
	var how = document.getElementById("how_many_payments").value;

	if(how>0 && how<=10) {
		hr.open("POST", "/bank_build/credit_payment", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_such_credit') {
						div.innerHTML = 'Няма такъв кредит';
					} else if(hr.responseText == 'no_enough_money') {
						div.innerHTML = 'Нямате достатъчно пари';
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = 'Нямате достатъчно енергия';
					} else {
						div.innerHTML = "Успешна вноска/и";
						enter_bank(ar_id, bank_id);
					}
					}
				}
		}
		var t = "credit_id="+credit_id+"&payment="+payment+"&how="+how+"&val=1"
		hr.send(t);
	} else if(how<=0) {
		div.innerHTML = "Изберете брой вноски";
	} else if(how>10) {
		div.innerHTML = "Макс. 10 вноски";
	}
}
/*
--------------------------------------------------------------------------------
LOADS BUILD RESTAURANT
--------------------------------------------------------------------------------
*/
function load_build_restaurant(ar_id, cat) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/restaurants/load_view_build_restaurant", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&cat="+cat+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
BUILDS RESTAURANT
--------------------------------------------------------------------------------
*/
function build_restaurant(ar_id, level, howmuch) {
	//var div = document.getElementById("city_zone");
	hr.open("POST", "/restaurants/build_restaurant", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				alert(hr.responseText);
				load_left_menu();
				load_build_restaurant(ar_id, 7);
				}
			}
	}
	var t = "area_id="+ar_id+"&howmuch="+howmuch+"&level="+level+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
DEFINE DISH PRICE
--------------------------------------------------------------------------------
*/
function define_dish_price(ar_id, dish_id) {
	var div = document.getElementById('show_prize_result');
	var price = document.getElementById('dish_price_'+dish_id).value;
	hr.open("POST", "/restaurants/define_dish_price", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'suc_def') {
					div.innerHTML = "Успешно променихте цената";
					load_build_restaurant(ar_id, 0);
					}
				}
			}
	}
	var t = "area_id="+ar_id+"&price="+price+"&dish_id="+dish_id+"&val=1";
	hr.send(t);
}
/*
--------------------------------------------------------------------------------
ENTERS RESTAURANT
--------------------------------------------------------------------------------
*/
function enter_restaurant(ar_id, res_id) {
	var div = document.getElementById('city_zone');
	hr.open("POST", "/restaurants/enter_restaurant", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&res_id="+res_id+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t)
}
/*
--------------------------------------------------------------------------------
BUYS DISH
--------------------------------------------------------------------------------
*/
function buy_dish(ar_id, dish_id) {
	var div = document.getElementById('show_bought_dish');
	var how = document.getElementById('get_dish_quantity_'+dish_id).value;
	if(how>=1 && how<=5) {
		hr.open("POST", "/restaurants/buy_dish", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = 'Нямате достатъчно пари за това количество';
						div.style.color = "#730404";
					} else if(hr.responseText == 'no_enough_quantity') {
						div.innerHTML = 'Няма достатъчно количество от това ястие в ресторанта';
						div.style.color = "#730404";
					}	else if(hr.responseText == 'bought_energy') {
						div.innerHTML = 'Вие изядохте '+how+' ястия';
						div.style.color = "#0B7304";
						load_left_menu();
					}  	
					}
				}
		}
		var t = "area_id="+ar_id+"&dish_id="+dish_id+"&how="+how+"&val=1";
		hr.send(t)
	} else if(how<1) {
		div.innerHTML = "Може да купите минимум 1 ястие";
		div.style.color = "#730404";
	} else if(how>5) {
		div.innerHTML = "Може да купите максимум 5 ястия";
		div.style.color = "#730404";
	}
}
/*--- LOADS RESTAURNAT STOCKS ---*/
function load_restaurant_stocks(ar_id) {
	var div = document.getElementById('show_prize_result');
	var dish_id = document.getElementById('load_stocks').value;
	if(dish_id>=1) {
		hr.open("POST", "/restaurants/load_stocks", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = 'Нямате достатъчно пари, за да заредтие';
						div.style.color = "#730404";
					} else {
						load_build_restaurant(ar_id, 0);
					}
				}
			}
		}
		var t = "area_id="+ar_id+"&dish_id="+dish_id+"&zone_id="+zone_id+"&val=1";
		hr.send(t)
	} else {
		div.innerHTML = "Трябва да изберете ястие";
		div.style.color = "#730404";
	}
}
/*
******************************************************************************
							# END OF RESTAURANT #
******************************************************************************
*/
/*----------------------------------------------------------------------------
								| CASINO |
----------------------------------------------------------------------------*/
function load_build_casino(ar_id) {
	var div = document.getElementById('city_zone');
	hr.open("POST", "/casino/build_casino", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t);
}
/*--- BUYS LICENSE ---*/
function buy_license(type, url) {
	if(type>=1 && type<=3) {
		var div = document.getElementById('apartment_notification');
		hr.open("POST", "/license/buy_license", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = 'Нямате достатъчно пари';
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = 'Нямате достатъчно енергия';
					} else {
						div.innerHTML = "Купихте лиценз";
						div.style.color = "#0B7304";
						location.href = url+"license";
					}
					
					}
				}
		}
		var t = "type="+type+"&val=1";
		hr.send(t);
	}
}
/* INSERTS MONEY INTO CASINO */
function insert_casino_money(ar_id) {
	var div		= document.getElementById('apartment_notification');
	var money 	= document.getElementById('casino_sum').value;
	if(money>=5000000) {
		hr.open("POST", "/casino/insert_money", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = 'Нямате достатъчно енергия';
					} else if(hr.responseText == 'no_enough_money') {
						div.innerHTML = 'Нямате достатъчно пари';
					} else {
						div.innerHTML = "Вкарахте успешно пари";
						div.style.color = "#0B7304";
						load_build_casino(ar_id);
					}
					
					}
				}
		}
		var t = "area_id="+ar_id+"&money="+money+"&val=1";
		hr.send(t);
	} else {
		div.innerHTML = 'Минимумът е 5 000 000';
		div.style.color = "#730404";
	}
}
/*--- GETS MONEY FORM THE CASINO ---*/
function get_casino_money(ar_id, atleast) {
	var div = document.getElementById('apartment_notification');
	var money = document.getElementById('casino_sum').value;
	if(atleast<5000000) {
		atleast = 5000000;
	}
	hr.open("POST", "/casino/get_casino_money", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_enough_energy') {
					div.innerHTML = 'Нямате достатъчно енергия';
				} else if(hr.responseText == 'at_least_five') {
					div.innerHTML = 'В казиното трябва да останат поне '+atleast;
				} else if(hr.responseText == 'no_enough_casino_money') {
					div.innerHTML = 'Нямате толкова пари в казиното';
				} else {
					load_build_casino(ar_id);
					div.innerHTML = 'Изтеглихте '+money;
					div.style.color = "#0B7304";
				}
				
				}
			}
	}
	var t = "area_id="+ar_id+"&money="+money+"&atleast="+atleast+"&val=1";
	hr.send(t);
} 
/**** END OF GETTING MONEY ****/
/*--- ADDING MORE MONEY TO THE CASINO ---*/
function insert_more_casino_money(ar_id) {
	var div = document.getElementById('apartment_notification');
	var money = document.getElementById('casino_insert_sum').value;

	hr.open("POST", "/casino/insert_more_casino_money", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_enough_energy') {
					div.innerHTML = 'Нямате достатъчно енергия';
				} else if(hr.responseText == 'no_enough_money') {
					div.innerHTML = 'Нямате достатъчно пари';
				} else {
					load_build_casino(ar_id);
					div.innerHTML = 'Вкарахте в казиното '+money;
					div.style.color = "#0B7304";
				}
				
				}
			}
	}
	var t = "area_id="+ar_id+"&money="+money+"&val=1";
	hr.send(t);
}
/*---- BUILDING CASINO ----*/
function build_casino(ar_id, money) {
	var div = document.getElementById('apartment_notification');

	hr.open("POST", "/casino/create_casino", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'no_enough_energy') {
					div.innerHTML = 'Нямате достатъчно енергия';
				} else if(hr.responseText == 'no_enougho_money') {
					div.innerHTML = 'Нямате достатъчно пари';
				} else {
					load_build_casino(ar_id);
					div.innerHTML = 'Построихте казино';
					div.style.color = "#0B7304";
				}
				}
			}
	}
	var t = "area_id="+ar_id+"&money="+money+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t);
}
/***** END of build_casino ****/
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
	var t = "area_id="+ar_id+"&casino_id="+casino_id+"&zone_id="+zone_id+"&page="+page+"&val=1";
	hr.send(t);
}
/**** END OF ENTER CASINO ****/
/*--- CHANGES CASINO PRIZE ---*/
function change_casino_prize(ar_id, prize_id) {
	var tobe = document.getElementById('casino_sum_to_'+prize_id).value;
	var div = document.getElementById('casino_prize_notification');
	hr.open("POST", "/casino/change_casino_prize", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {	
				if(hr.responseText == 'five_time_less') {
					div.innerHTML = "Наградата трябва да е поне 5 пъти по-малка от наличните пари в казиното";
					div.style.color = "#ff0000";
				} else if(hr.responseText == 'prize_updated') {
					div.innerHTML = "Наградата беше променена";
					div.style.color = "#0B7304";
				}
				}
			}
	}
	var t = "area_id="+ar_id+"&prize_id="+prize_id+"&tobe="+tobe+"&val=1";
	hr.send(t);
}

/*----------------------------------------------------------------------
							| UNIVERSITY |
------------------------------------------------------------------------*/
function load_build_university(ar_id) {
	var div = document.getElementById('city_zone');
	hr.open("POST", "/university/load_build_university", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				}
			}
	}
	var t = "area_id="+ar_id+"&val=1";
	hr.send(t);
}
/* BUILDS UNIVERSITY */
function build_university(ar_id) {
	hr.open("POST", "/university/building_university", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				load_center_areas_view(zone_id);
				}
			}
	}
	var t = "area_id="+ar_id+"&val=1";
	hr.send(t);
}
/*--- LOADS UNIVERSITY'S ADMINISTRATIONS ---*/
function university_admin(ar_id, uni_id) {
	var div = document.getElementById('city_zone');
	hr.open("POST", "/university/load_university_administration", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
			}
		}
	}
	var t = "area_id="+ar_id+"&uni_id="+uni_id+"&val=1";
	hr.send(t);
}
/*--- ADDING UNIVERSITY SPECIALTY ---*/
function add_uni_speacialty(ar_id, uni_id) {
	var spec = document.getElementById('add_uni_spec').value;
	var prize = document.getElementById('add_uni_enter_prize').value;
	if(spec.length > 1 && prize>=1) {
		hr.open("POST", "/university/add_uni_specialty", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					//console.log(hr.responseText);
					university_admin(ar_id, uni_id);
				}
			}
		}
		var t = "area_id="+ar_id+"&uni_id="+uni_id+"&spec="+spec+"&prize="+prize+"&val=1";
		hr.send(t);
	} else {
		alert("Валидация! Имате проблем с полетата");
	}
}
/*--- GETS THE CHECKED CORRECT ANSWER FROM RADIO BUTTONS ---*/
function get_checked_correct() {
	var iscorrect;
	if(document.getElementById('r1').checked) {
		iscorrect = document.getElementById('r1').value;
		document.getElementById('r1').checked = false;
	}
	if(document.getElementById('r2').checked) {
		iscorrect = document.getElementById('r2').value;
		document.getElementById('r2').checked = false;
	}
	if(document.getElementById('r3').checked) {
		iscorrect = document.getElementById('r3').value;
		document.getElementById('r3').checked = false;
	}
	if(document.getElementById('r4').checked) {
		iscorrect = document.getElementById('r4').value;
		document.getElementById('r4').checked = false;
	}
	return iscorrect;
}

function add_question(ar_id, uni_id) {
	var error = document.getElementById('add_quest_error');
	var iscorrect = 0;
	iscorrect = get_checked_correct();
	var cat_id = document.getElementById('cat_id').value;
	var quest = document.getElementById('quest').value;
	var level = document.getElementById('level').value;
	var ans1 = document.getElementById('ans1').value;
	var ans2 = document.getElementById('ans2').value;
	var ans3 = document.getElementById('ans3').value;
	var ans4 = document.getElementById('ans4').value;
	if(cat_id>0 && quest.length>5 && level.length==1 && iscorrect!=0 && iscorrect!='undefined') {
		hr.open("POST", "/university/add_university_question", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					alert("Добавихте въпроса успешно");
					university_admin(ar_id, uni_id);
				}
			}
		}
		var t = "uni_id="+uni_id+"&cat_id="+cat_id+"&question="+quest+"&iscorrect="+iscorrect+"&level="+level+"&ans1="+ans1+"&ans2="+ans2+"&ans3="+ans3+"&ans4="+ans4;
		hr.send(t);
	} else if(quest.length<5) {
		error.innerHTML = 'Не задали валиден въпрос';
	} else if(level!=1) { 
		error.innerHTML = 'Не сте избрали ниво';
	} else if(iscorrect == 0 || iscorrect=='undefined') {
		error.innerHTML = 'Не сте избрали правлен отговор';
	} else {
		error.innerHTML = 'Не сте избрали специалност';
	}
	
}
function start_education(spec_id, url) {
	var div = document.getElementById('apartment_notification');
		hr.open("POST", "/university/start_education", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = 'Нямате достатъчно пари';
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = 'Нямате достатъчно енергия';
					} else {
						div.innerHTML = "Започнахте образование по специалността";
						div.style.color = "#0B7304";
						location.href = url+"university";
					}
					
					}
				}
		}
		var t = "spec_id="+spec_id+"&val=1";
		hr.send(t);
}
/*########################################################################
						--- INDUSTRIAL ---
#########################################################################*/
/*------------------------------------------------------------------------ 
							BUILDING COW 
--------------------------------------------------------------------------*/
/*--- LOAD VIEW OF BUILDING COW ---*/
function load_build_cow(ar_id) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/industrial/load_build_cow", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*---- END OF BUILDING COW ----*/
/*------------------------------------------------------------------------ 
					CALCULATING SPACE TO BUILD
--------------------------------------------------------------------------*/
function calc_cow_space() {
	var div = document.getElementById("show_cow_calc_space");
	var space = document.getElementById("df_space_build").value;
	var sum = space*100;
	if(space>=250) {
		var cap = Math.round(space/15);
		div.innerHTML = "Цената за "+space+" кв.м. е "+sum+"<br/>Капацитет за крави "+cap;
		div.style.color = "#345e67";
	} else {
		div.innerHTML = "Трябва да застроите поне 250 кв.м.";
		div.style.color = "#ff0000";
	}
}
/**** END OF calc_cow_space ****/
/*------------------------------------------------------------------------ 
					BUIDLING DAIRY FARM
--------------------------------------------------------------------------*/
function build_dairy_farm(ar_id) {
	var div = document.getElementById("build_mansions_not_div");
	var space = document.getElementById("df_space_build").value;
	var sum = space*100;
	if(space>=250) {
		hr.open("POST", "/industrial/build_dairy_farm", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да застроите "+space+" кв.м</span></div>";
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
					} else {
						div.innerHTML = "<div class='sell_not'><span class='sell_green'>Построено</span></div>";
						admin_dairy_farm(ar_id);
						//func(ar_id, 0);
						document.getElementById("df_space_build").value = '';
					}
				}
			}
		}
		var t = "area_id="+ar_id+"&space="+space+"&zone_id=3&val=1"
		hr.send(t);
	} else {
		div.innerHTML = "<div class='sell_not'><span class='sell_red'>Трябва да застроите поне 250 кв.м.</span></div>";
	}
	
}
/*------------------------------------------------------------------------ 
					LOAD ADMIN DAIRY FARM
--------------------------------------------------------------------------*/
function admin_dairy_farm(ar_id) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/dairy_farm/admin_dairy_farm", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
				}
			}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*------------------------------------------------------------------------ 
					CALCULATING SPACE TO BUILD
--------------------------------------------------------------------------*/
function calc_cow_morespace(nowspace) {
	var div = document.getElementById("show_cow_calc_space");
	var space = document.getElementById("df_space_build").value;
	var sum = space*100;
	if(space>=2 && space<10000) {
		var cap = Math.round(space/15);
		var totalcap = nowspace+cap;
		div.innerHTML = "Цената за "+space+" кв.м. е "+sum+"<br/>Капацитет за крави: "+cap+"<br/>Общ капацитет след строеж: "+totalcap+" крави";
		div.style.color = "#345e67"; 
	} else {
		div.innerHTML = "Трябва да застроите поне 2 кв.м.";
		div.style.color = "#ff0000";
	}
}
/*------------------------------------------------------------------------ 
					BUIDLGING MORE SPACE IN DAIRY FARM
--------------------------------------------------------------------------*/
function build_more_space_df(ar_id) {
	var div = document.getElementById("build_mansions_not_div");
	var space = document.getElementById("df_space_build").value;
	var sum = space*100;
	if(space>=2) {
		hr.open("POST", "/dairy_farm/build_more_df_space", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да застроите "+space+" кв.м</span></div>";
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
					} else {
						div.innerHTML = "<div class='sell_not'><span class='sell_green'>Построено</span></div>";
						admin_dairy_farm(ar_id);
						//func(ar_id, 0);
						document.getElementById("df_space_build").value = '';
					}
				}
			}
		}
		var t = "area_id="+ar_id+"&space="+space+"&zone_id=3&val=1"
		hr.send(t);
	} else {
		div.innerHTML = "<div class='sell_not'><span class='sell_red'>Трябва да застроите поне 250 кв.м.</span></div>";
	}
}
/*------------------------------------------------------------------------ 
							BUYS COW
--------------------------------------------------------------------------*/
function buy_cow(ar_id) {
	var div = document.getElementById("build_mansions_not_div");
	var cows = document.getElementById("number_of_cows").value;
	if(cows>=1) {
		hr.open("POST", "/dairy_farm/buy_cows", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_capacity') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Кравефермата няма достатъчно капацитет за още "+cows+" крави</span></div>";
					} else if(hr.responseText == 'no_enough_money') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да купите "+cows+" крави</span></div>";
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
					} else {
						div.innerHTML = "<div class='sell_not'><span class='sell_green'>Купени крави</span></div>";
						admin_dairy_farm(ar_id);
						document.getElementById("number_of_cows").value = '';
					}
				}
			}
		}
		var t = "area_id="+ar_id+"&cows="+cows+"&zone_id=3&val=1"
		hr.send(t);
	} else {
		div.innerHTML = "<div class='sell_not'><span class='sell_red'>Трябва да купите поне една крава</span></div>";
	}
}
/*------------------------------------------------------------------------ 
							MILK PRODUCTION
--------------------------------------------------------------------------*/
function milk_production(ar_id) {
	hr.open("POST", "/dairy_farm/start_milk_production", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				//alert(hr.responseText);
				admin_dairy_farm(ar_id);
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&val=1"
	hr.send(t);
}
/*------------------------------------------------------------------------ 
					COLLECTING MILK PRODUCTION
--------------------------------------------------------------------------*/
function get_milk_production(ar_id) {
	hr.open("POST", "/dairy_farm/get_milk_production", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				admin_dairy_farm(ar_id);
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&val=1"
	hr.send(t);
}
/*------------------------------------------------------------------------ 
					SELLS MILK PRODUCTION
--------------------------------------------------------------------------*/
function sell_milk(ar_id) {
	var div = document.getElementById("build_mansions_not_div");
	hr.open("POST", "/dairy_farm/sell_milk", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'zero_milk') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Силоза за мляко е празен</span></div>";
				} else {
					admin_dairy_farm(ar_id);
				}
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&val=1"
	hr.send(t);
}
/*============================================================================
							# TOMATOS #
=============================================================================*/
function load_build_tomatos(ar_id) {
	var div = document.getElementById("city_zone");
	hr.open("POST", "/tomatos/load_build_tomatos", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				div.innerHTML = hr.responseText;
				load_left_menu();
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&page="+page+"&val=1"
	hr.send(t);
}
/*** END OF loading_build_tomato ***/
/*------------------------------------------------------------------------ 
					TOMATO SEED CALCULATIONS
--------------------------------------------------------------------------*/
function calc_tomato_seed() {
	var div = document.getElementById("show_cow_calc_space");
	var seed = document.getElementById("tf_space_seed").value;
	if(seed>=5 && seed<=5000) {
		var seeds = seed*120;
		var water = seed*60;
		var wat = water*3;
		var tons = seed*5;
		var work = seed*2000;
		var total = seeds+wat+work;
		
		div.innerHTML = "Посеви: "+seeds+"<br/>Вода: "+water+" по 3 дни = "+wat+"<br/>Работна ръка: "+work+"<br/>Общо: "+total+"<br/><br/> Добив: "+tons+" тона домати";
		div.style.color = "#345e67";
	} else if(seed>5000) {
		div.innerHTML = "Може да засеете до 5000 декара";
		div.style.color = "#ff0000";
	} else {
		div.innerHTML = "Трябва да засеете поне 5 декара";
		div.style.color = "#ff0000";
	}
}
/*------------------------------------------------------------------------ 
						SEEDING TOMATOS
--------------------------------------------------------------------------*/
function tomato_seed(ar_id) {
	var div = document.getElementById("build_mansions_not_div");
	var space = document.getElementById("tf_space_seed").value;
	if(space>=5) {
		hr.open("POST", "/tomatos/seed_tomatos", true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4) {
				if(hr.status == 200) {
					if(hr.responseText == 'no_enough_money') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно пари, за да засеете "+space+" декара</span></div>";
					} else if(hr.responseText == 'no_enough_energy') {
						div.innerHTML = "<div class='sell_not'><span class='sell_red'>Нямате достатъчно енергия</span></div>";
					} else {
						div.innerHTML = "<div class='sell_not'><span class='sell_green'>Засян</span></div>";
						load_build_tomatos(ar_id);
						document.getElementById("tf_space_seed").value = '';
					}
				}
			}
		}
		var t = "area_id="+ar_id+"&space="+space+"&zone_id=3&val=1"
		hr.send(t);
	} else {
		div.innerHTML = "<div class='sell_not'><span class='sell_red'>Трябва да засеете поне 5 декара</span></div>";
	}
}
/*------------------------------------------------------------------------ 
					STARTING TOMATO PRODUCING
--------------------------------------------------------------------------*/
function tomato_production(ar_id) {
	hr.open("POST", "/tomatos/start_tomato_production", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				load_build_tomatos(ar_id);
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&val=1"
	hr.send(t);
}
/*------------------------------------------------------------------------ 
						GETS TOMATO PRODUCING
--------------------------------------------------------------------------*/
function get_tomato_production(ar_id) {
	hr.open("POST", "/tomatos/get_tomato_production", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				load_build_tomatos(ar_id);
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&val=1"
	hr.send(t);
}
function sell_tomato(ar_id) {
	var div = document.getElementById("build_mansions_not_div");
	hr.open("POST", "/tomatos/sell_tomatos", true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4) {
			if(hr.status == 200) {
				if(hr.responseText == 'zero_tomatos') {
					div.innerHTML = "<div class='sell_not'><span class='sell_red'>Вие нямате домати за продан</span></div>";
				} else {
					load_build_tomatos(ar_id);
				}
			}
		}
	}
	var t = "area_id="+ar_id+"&zone_id="+zone_id+"&val=1"
	hr.send(t);
}
/*

function split_number(num) {
	var new_number;
	if(num.length == 4) {
		new_number = num[0]+" "+num[1]+num[2]+num[3];
		return new_number;
	} else if(num.length == 5) {
		new_number = num[0]+num[1]+" "+num[2]+num[3]+num[4];
		return new_number;
	} else if(num.length == 6) {
		new_number = num[0]+num[1]+num[2]+" "+num[3]+num[4]+num[5];
		return new_number;
	} else {
		return num;
	}
}*/