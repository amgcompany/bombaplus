<!-- BUYS MORE AREA -->
<div class="sell_not">	
<?php if($res == 'no_enough_money') { ?>
	<span class="sell_red">Нямате достатъчно пари, за да купите <?php echo  $space ?> кв.м</span>
<?php } else if($res == 'no_enough_energy') { ?>
	<span class="sell_red">Нямате достатъчно енергия</span>
<?php } else if($res == 'area_bought') { ?>
	<span class="sell_green">Вие купихте успешно още от този имот</span>
<?php } ?>
</div>