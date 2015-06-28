<div class="area">
	<div class="area_for_sale_title">
		Кравеферма
	</div>
	<div class="cow_building_symbol_left">&nbsp;</div>
	<div class="small_building_art">&nbsp;</div>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_button">
		<a href="javascript:void(0);" onclick="admin_dairy_farm(<?php echo $area_id; ?>);">Администрация</a>
	</div>
	<?php } else { ?> 
		<br/>
		<div class="area_for_sale_title">
		Крави: <?php echo $cows; ?>
		</div>
		<div class="area_for_sale_title">
		Производител: <a href="<?php echo base_url(); ?>profile/<?php echo $owner_id; ?>"><?php echo $owner; ?></a>
		</div>
	<?php } ?>
	<!-- -->
</div>