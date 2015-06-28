<!-- BUYS BUILDING PERMISSION -->
<div class="sell_not">	
<?php if($res == 'no_enough_money') { ?>
	<span class="sell_red">Нямате достатъчно пари</span>
<?php } else if($res == 'no_enough_energy') { ?>
	<span class="sell_red">Нямате достатъчно енергия</span>
<?php } else if($res == 'area_bought') { ?>
	<span class="sell_green">Купихте разрешително за строеж</span>
<?php } ?>
</div>