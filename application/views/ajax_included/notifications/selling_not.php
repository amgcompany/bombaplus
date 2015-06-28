<div class="sell_not">	
<?php if($notification == 'exist_such_article') { ?>
	<span class="sell_red">Вече сте обявили количество от този продукт за продан</span>
<?php } else if($notification == 'no_enough_quantity') { ?>
	<span class="sell_red">Нямате достатъчно количество</span>
<?php } else if($notification == 'doesnt_select_quantity') { ?>
	<span class="sell_red">Не сте определили какво количество искате да продадете</span>
<?php } else if($notification == 'doesnt_select_prize') { ?>
	<span class="sell_red">Не сте определили цена за продан</span>
<?php } else { ?> 
	<span class="sell_green">Добавихте продукта за продан в пазар</span>
<?php } ?>
</div>