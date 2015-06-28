<div class="area">
	<div class="area_for_sale_title">
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) {echo "Мой ж.Блок";} else { echo "Жилищен Блок";} ?>
	</div>
	<?php if($apartment_level == 1) { ?>
		<div class="apartments_level_one">&nbsp;</div>
	<?php } else if($apartment_level == 2) { ?>
		<div class="apartments_level_two">&nbsp;</div>
	<?php } ?>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_bought_button"><input type="button" onclick="load_build_apartment(<?php echo $area_id; ?>, 1)" value="Администрация"/></div>
	<?php } else { ?>
	<div class="area_button"><input type="button" onclick="enter_mansions(<?php echo $area_id; ?>)" value="Вход в блока"/></div>
	<?php } ?>
	<!-- -->
</div>