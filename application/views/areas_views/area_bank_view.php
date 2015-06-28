<div class="area">
	<div class="area_for_sale_title">
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) {echo "Моя банка";} else { echo "Системна банка";} ?>
	</div>
	<div class="bank_pixel_art">&nbsp;</div>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_bought_button"><input type="button" onclick="load_build_bank(<?php echo $area_id; ?>, 2)" value="Администрация"/></div>
	<?php } else { ?>
	<div class="area_button"><input type="button" onclick="enter_bank(<?php echo $area_id.', '.$bank_id; ?>)" value="Вход в банката"/></div>
	<?php } ?>
	<!-- -->
</div>