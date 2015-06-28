<!-- CITY CENTER ZONE -->
<?php foreach($areas as $area): ?>
	<?php if($area['area_sold'] == 0) { ?>
	<!-- AREA FOR SALE -->
		<div class="area">
			<div class="area_for_sale_title">Площ за продан</div>
			<div class="area_for_sale">&nbsp;</div>
			<div class="area_space">Площ: <?php echo $area['area_space']; ?> кв.м</div>
			<div class="area_space">Цена за 1 кв.м: 400</div>
			<div class="area_button"><input type="button" onclick="show_buyarea_div(<?php echo $area['area_id']; ?>)" value="Купи"/></div>
		</div>
		<!-- END OF AREA FOR SALE -->
		<?php } else if($area['area_sold'] == 1) {?>
		<div class="area">
			<div class="area_for_sale_title">Продадено</div>
				<div class="area_for_sale">&nbsp;</div>
		</div>
		<?php } ?>
<?php endforeach; ?>
<!-- END OF CITY CENTER ZONE -->