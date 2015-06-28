<!-- BUY AREA NOTIFICATION -->
<?php
	if($res == 'already_bought_area'){
		echo "Този имот вече е купен";
	} else if($res == 'no_enough_money') {
		echo "Нямате достатъчно пари, за да купите $space кв.м";
	} else if($res == 'no_enough_energy') {
		echo "Нямате достатъчно енергия, за да купите този имот";
	} else if($res == 'area_bought') {
		echo "Вие купихте успешно този имот";
	}
?>