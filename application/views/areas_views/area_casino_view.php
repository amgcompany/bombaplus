<div class="area">
	<div class="area_for_sale_title">
	<?php if($area_sold_to_id == $this->session->userdata('user_id'))  {	
		echo "Мое казино"; 
	?>
		<a href="javascript:void(0);" onclick="enter_casino(<?php echo $area_id.', '.$casino_id; ?>);">Вход</a>
	<?php
		} 
		else { echo "Казино";} 
		?>
	</div>
	<div class="casino_pixel_art">&nbsp;</div>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_bought_button"><input type="button" onclick="load_build_casino(<?php echo $area_id; ?>)" value="Администрация"/></div>
	<?php } else { ?>
	<div class="area_button"><input type="button" onclick="enter_casino(<?php echo $area_id.', '.$casino_id; ?>)" value="Вход в казиното"/></div>
	<?php } ?>
	<!-- -->
</div>