<!-- SHOP BUYING PRODUCT NOTIFICATION -->
<div class="sell_not">
<?php if($res == 'choose_quantity') { ?>
	<div class="sell_red">
		Не сте избрали, какво количество искате да купите
	</div>
<?php } else if($res == 'no_such_article') { ?>
	<div class="sell_red">
		Този продукт вече не се предлага, възможно е да бил изкупен
	</div>
<?php } else if($res == 'no_quantity') { ?> 
	<div class="sell_red">
		Няма толкова количество, колкото искате
	</div>
<?php } else if($res == 'no_enough_money') { ?> 
	<div class="sell_red">
		Нямате достатъчно пари
	</div>
<?php } else { ?>
	<div class="sell_green">
		Успешна покупка
	</div>
<?php } ?>
</div>