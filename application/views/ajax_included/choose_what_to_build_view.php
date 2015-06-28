<!-- CHOOSE WHAT KIND OF BUILDING TO BULD DIV -->
<div class="choose_what_to_build">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Възможности за строеж в центъра</div>
	</div>
	<?php if($zone_id == 1 || $zone_id == 2) { ?>
	<div class="choose_build_cats">
	<?php
	foreach($cats as $row):
	if($this->session->userdata('rank') == 1) { 
	?>
		<?php if($row['category_building'] != 'Диско клуб' && $row['category_building'] != 'Пазар' && $row['category_building'] != 'Къща' && $row['category_building'] != 'Кравеферма' && $row['category_building'] != 'Домати') { ?>
		<div class="area">
			<div class="area_for_sale_title"><?php echo $row['category_building']; ?></div>
			<?php if($row['category_building'] == 'Блок') { ?>
			<div class="apartments_level_two">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_apartment(<?php echo $this->input->post('area_id');?>, 1)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Банка') { ?>
			<div class="bank_pixel_art">&nbsp;</div>
			
			<div class="area_button"><input type="button" onclick="load_build_bank(<?php echo $this->input->post('area_id');?>, 2)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Казино') { ?>
			<div class="casino_pixel_art">&nbsp;</div>
			
			<div class="area_button"><input type="button" onclick="load_build_casino(<?php echo $this->input->post('area_id');?>)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Университет') { ?>
			<div class="university_pixel_art">&nbsp;</div>
			
			<div class="area_button"><input type="button" onclick="load_build_university(<?php echo $this->input->post('area_id');?>)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Къща') { ?>
			<div class="house_pixel_art">&nbsp;</div>
			
			<div class="area_button"><input type="button" onclick="load_build_house(<?php echo $this->input->post('area_id');?>, 6)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Ресторант') { ?>
			<div class="restaurant_level_two">&nbsp;</div>
			
			<div class="area_button"><input type="button" onclick="load_build_restaurant(<?php echo $this->input->post('area_id');?>, 7)" value="Инфо"/></div>
			<?php } ?>
		</div>
		<?php } ?>
	<?php 
	
	} else { 
		if($row['category_building'] != 'Банка' && $row['category_building'] != 'Университет' && $row['category_building'] != 'Диско клуб' && $row['category_building'] != 'Пазар' && $row['category_building'] != 'Къща' && $row['category_building'] != 'Кравеферма' && $row['category_building'] != 'Домати') {
	?>
		<div class="area">
			<div class="area_for_sale_title"><?php echo $row['category_building']; ?></div>
			<?php if($row['category_building'] == 'Блок') { ?>
			<div class="apartments_level_one">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_apartment(<?php echo $this->input->post('area_id');?>, 1, 1)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Казино') { ?>
			<div class="casino_pixel_art">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_casino(<?php echo $this->input->post('area_id');?>, 1)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Диско клуб') { ?>
			<div class="disco_pixel_art">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_disco(<?php echo $this->input->post('area_id');?>, 1)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Къща') { ?>
			<div class="house_pixel_art">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_house(<?php echo $this->input->post('area_id');?>, 1, 1)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Ресторант') { ?>
			<div class="restaurant_level_one">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_restaurant(<?php echo $this->input->post('area_id');?>, 1, 1)" value="Инфо"/></div>
			<?php } ?>
		</div>
	<?php	
		}
	} 
	endforeach;
	?>
	</div>
	<?php } else if($zone_id == 3) { ?>
	<?php foreach($cats as $row): ?>
		<?php if($row['category_building'] == 'Кравеферма' || $row['category_building'] == 'Домати') {?>
		<div class="area">
			<div class="area_for_sale_title"><?php echo $row['category_building']; ?></div>
			<?php if($row['category_building'] == 'Кравеферма') { ?>
			<div class="cow_building_symbol_left">&nbsp;</div>
			<div class="small_building_art">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_cow(<?php echo $this->input->post('area_id');?>)" value="Инфо"/></div>
			<?php } ?>
			<?php if($row['category_building'] == 'Домати') { ?>
			<div class="tomatos_pixel_art">&nbsp;</div>
			<div class="area_button"><input type="button" onclick="load_build_tomatos(<?php echo $this->input->post('area_id');?>)" value="Инфо"/></div>
			<?php } ?>
		</div>
		<?php } ?>
	<?php endforeach; ?>
	<?php } ?>
</div>
<!-- END OF choose what to build view divs -->