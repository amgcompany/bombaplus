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
function buy_more_area(cena, ar_id) {
	var div = document.getElementById("sa");
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
					textarea.innerHTML = hr.responseText;
					load_build_apartment(ar_id, 1);
					document.getElementById("area_buy_space_wanted").value = '';
					hide_morebuy_area_div();
					}
				}
		}
		hr.send(info);
	}
}