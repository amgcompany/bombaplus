<!-- BUILD APARTMENTS VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view()" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view()">Назад</a></div>
		<div class="choose_build_title">Жилищен блок на <?php echo $row['username']; ?></div>
	</div>
	<div class="build_mansions">
		
		<div class="bm_left_side">
			<div class="area">
				<?php if($row['b_apartment_level'] == 1) { ?>
				<div class="apartments_level_one">&nbsp;</div>
				<?php } else if($row['b_apartment_level'] == 2) { ?>
				<div class="apartments_level_two">&nbsp;</div>
				<?php }  ?>
			</div>
		</div>
		<div class="bm_right_side">
			<div class="apartments_owner">
				<span>Апартаменти</span>
				<br/>
				<div id="apartment_notification"></div>
				
				<?php $i=0;foreach($row['ba_owners'] AS $row_bao) {$i++; ?> 
					<div class="apartment">
						<div>
							<div class="building_area_apartments_icon">&nbsp;</div> 
							<span class="apartment_text_title">Апартамент &numero; <?php echo $i;//$row_bao['ba_owners_id']; ?></span>
						</div>
						<?php if($row_bao['ba_owner_sold'] == 0) { ?>
						<div class="apartment_sold">
							<div class="apartment_text_padding">Продава се</div>
							<div class="apartment_text_padding">Цена: <?php echo number_format($row_bao['bao_price'], 0, '.', ' ');?></div>
							
							<div class="buy_apartment_button">
							<input type="button" onclick="buy_apartment(<?php echo $row_bao['ba_owners_id'].', '.$row_bao['bao_area_id'].', '.$row['user_id'].', '.$row_bao['bao_price']; ?>)" value="Купи апартамент" />
							<?php /* 1) ID of the apartment 2) ID of the area 3) ID of the mansion's owner */ ?>
							</div>
						</div>
						<?php } else { ?> 
						<div class="apartment_sold">
							<div class="apartment_text_padding">
								<div class="lm_user_icon">&nbsp;</div> 
								<a href="<?php echo base_url()."profile/$row_bao[owner_user_id]"; ?>"><?php echo $row_bao['owner_user']; ?></a>
								живее в този апартамент
							</div>
						</div>
						<?php }?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<!-- END OF BUILD APARTMENTS VIEW -->