<div class="area">
	<div class="area_for_sale_title">
	<?php if($area_sold_to_id == $this->session->userdata('user_id'))  {	
		echo "Мой ресторант"; 
	?>
		<a href="javascript:void(0);" onclick="enter_restaurant(<?php echo $area_id.', '.$restaurant_id; ?>);">Вход</a>
	<?php
		} 
		else { echo "Ресторант";} 
		?>
	</div>
	<?php if($b_restaurant_level == 1) { ?>
		<div class="restaurant_level_one">&nbsp;</div>
	<?php } else if($b_restaurant_level == 2) { ?>
		<div class="restaurant_level_two">&nbsp;</div>
	<?php } ?>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_bought_button"><input type="button" onclick="load_build_restaurant(<?php echo $area_id; ?>, 1)" value="Администрация"/></div>
	<?php } else { ?>
	<div class="area_button"><input type="button" onclick="enter_restaurant(<?php echo $area_id.', '.$restaurant_id; ?>)" value="Вход в ресторанта"/></div>
	<?php } ?>
	<!-- -->
</div>