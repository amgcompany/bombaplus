<!-- BUILD APARTMENTS VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Жилищен блок на <?php echo $row['username']; ?></div>
	</div>
	<div class="build_mansions">
		<div class="apartments_owner">
			<div id="build_mansions_not_div"></div>
			<?php $i=0;foreach($row['ba_owners'] AS $row_bao) { $i++; ?> 
			<?php if($row_bao['ba_owner_sold'] == 0) { ?>
			<div class="area">
				<div class="area_for_sale_title">Продава се</div>
				<div class="apartment_for_sale">&nbsp;</div>
				<div class="area_space"><b>Цена: <?php echo number_format($row_bao['bao_price'], 0, '.', ' ');?></b></div>
				<div class="area_button"><input type="button" onclick="buy_apartment(<?php echo $row_bao['ba_owners_id'].', '.$row_bao['bao_area_id'].', '.$row['user_id'].', '.$row_bao['bao_price']; ?>)" value="Купи апартамент" /></div>
			</div>
			<?php } else { ?> 
			<div class="area">
				<div class="area_for_sale_title">Апартамент на <a href="<?php echo base_url()."profile/$row_bao[owner_user_id]"; ?>"><?php echo $row_bao['owner_user']; ?></a></div>
				<div class="apartment_sold_pa">&nbsp;</div>
			</div>
			<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<!-- END OF BUILD APARTMENTS VIEW -->