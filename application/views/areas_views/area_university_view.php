<div class="area">
	<div class="area_for_sale_title">
	<?php if($area_sold_to_id == $this->session->userdata('user_id'))  {	
		echo "Университет"; 
	?>
		<a href="<?php echo base_url(); ?>university">Вход</a>
	<?php
		} 
		else { echo "Университет";} 
		?>
	</div>
	<div class="university_pixel_art">&nbsp;</div>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_bought_button"><input type="button" onclick="university_admin(<?php echo $area_id.', '.$uni_id; ?>)" value="Администрация"/></div>
	<?php } else { ?>
	<div class="area_button">
		<a href="<?php echo base_url(); ?>university">Вход в университета</a>
	</div>
	<?php } ?>
	<!-- -->
</div>