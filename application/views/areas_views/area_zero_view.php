<!-- AREA FOR SALE -->
<div class="area">
	<div class="area_for_sale_title">Площ за продан</div>
	<div class="area_for_sale">&nbsp;</div>
	<div class="area_space">
		<?php 
		if($zone_id == 1 || $zone_id == 2) {
			echo "Площ: $area_space кв.м"; 
		} else if($zone_id == 3) {
			$new_space = $area_space/1000;
			echo "Площ: $new_space дк."; 
		}
		?> 
	</div>
	<div class="area_space">
	<?php if($zone_id == 1) { ?>
		Цена за 1 кв.м: 400
	<?php } else if($zone_id == 2) { ?> 
		Цена за 1 кв.м: 200
	<?php } else if($zone_id == 3) { ?> 
		Цена за 1 дк: 300
	<?php }?>
	</div>
	<div class="area_button"><input type="button" onclick="show_buyarea_div(<?php echo $area_id; ?>)" value="Купи"/></div>
</div>
<!-- END OF AREA FOR SALE -->