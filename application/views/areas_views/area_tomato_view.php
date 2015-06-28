<div class="area">
	<div class="area_for_sale_title">
		Производство на домати
	</div>
	<div class="tomatos_pixel_art">&nbsp;</div>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_button">
		<a href="javascript:void(0);" onclick="load_build_tomatos(<?php echo $area_id; ?>);">Администрация</a>
	</div>
	<?php } else { ?> 
		<br/>
		<div class="area_for_sale_title">
		Засадена площ: <?php echo $seeds; ?> декара
		</div>
		<div class="area_for_sale_title">
		Производител: <a href="<?php echo base_url(); ?>profile/<?php echo $owner_id; ?>"><?php echo $owner; ?></a>
		</div>
	<?php } ?>
	<!-- -->
</div>