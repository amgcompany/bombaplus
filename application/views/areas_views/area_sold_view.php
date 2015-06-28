<div class="area">
	<div class="area_for_sale_title">
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) {echo "Мой имот";} else { echo "Продадено";} ?>
	</div>
	<div class="area_sold">&nbsp;</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<!--  -->
	<?php if($area_sold_to_id == $this->session->userdata('user_id')) { ?>
	<div class="area_bought_button"><input type="button" onclick="load_choose_build(<?php echo $area_id; ?>)" value="Строеж"/></div>
	<?php } ?>
	<!-- -->
</div>