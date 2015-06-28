<!-- BUILD TOMATO FARM -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Администрация за производство на домати</div>
	</div>
	<div id="build_mansions_not_div"></div>
	<?php if($row['is_build'] == 1) { ?>
	<div id="dairy_farm_main_info">
		<div class="area">
			<div class="area_for_sale_title">Засяна площ: <b><?php echo $row['tf_space_seed']; ?></b> декара</div>
			<div class="tomatos_pixel_art">&nbsp;</div>
		</div>
		<div class="area">
			<?php if($row['tomato_production'] == 0 && $row['ftf_tomato_producing'] == 0 && $row['is_finished'] == 0) { ?>
				<?php if($row['tf_space_seed']>0) { ?>
				<div class="area_for_sale_title">Производство през 3 дни</div>
				<div class="big_cow_clock">&nbsp;</div>
				<div class="area_bought_button"><input type="button" onclick="tomato_production(<?php echo $area_id; ?>)" value="Старт"/></div>
				<?php } else { ?>
					<div class="area_for_sale_title"><b>Трябва да засеете площта</b></div>
					<div class="tomato_seeds_pixel">&nbsp;</div>
				<?php } ?>
			<?php } else if($row['tomato_production'] == 1 && $row['is_finished'] == 0) { ?>
			<div class="arew_cow_container">
				<div class="cow_clock">&nbsp;</div>
				<div class="cow_text_left">
				Завършва:<br/> <?php echo $row['tomato_prod_finish']; ?>
				</div>
				<div class="tomatos_finish_pixel">&nbsp;</div>
			</div>
			<?php } else if($row['tomato_production'] == 0 && $row['ftf_tomato_producing'] == 1 && $row['is_finished'] == 1) { ?> 
				<div class="area_for_sale_title">Готова продукция</div>
				<div class="mature_tomatos_pixel">&nbsp;</div>
				<div class="area_bought_button"><input type="button" onclick="get_tomato_production(<?php echo $area_id; ?>)" value="Събери продукцията"/></div>
			<?php } ?>
		</div>
		<div class="area">
			<div class="area_for_sale_title">Домати: <b><?php echo $row['tf_tomato_tons']; ?></b> тона</div>
			<div class="tomatos_storage_pixel">&nbsp;</div>
			<div class="area_bought_button"><input type="button" onclick="sell_tomato(<?php echo $area_id; ?>)" value="Продай"/></div>
		</div>
	</div>
	<?php } ?>
	<div class="build_mansions">
		<div class="bm_left_side">
			<div class="area">
				<?php if($row['is_build'] == 0 || ($row['is_build'] == 1)) { ?>
				<div class="tomatos_pixel_art">&nbsp;</div>
				<?php } ?>
			</div>
			<div class="expenses_profits_left">
				<div class="expenses_left">
					<div class="expenses_icon">&nbsp</div>
					<div class="expenses_text">Разходи</div>
					<div class="expenses_bash"><?php echo $row['money_spent']; ?></div>
				</div>
			</div>
			<div class="expenses_profits_left">
				<div class="expenses_left">
					<div class="profits_icon">&nbsp</div>
					<div class="profits_text">Приходи</div>
					<div class="expenses_bash"><?php echo $row['money_earned']; ?></div>
				</div>
			</div>
			<div class="prof_exp_line_split">&nbsp;</div>
			<div class="expenses_profits_left">
				<div class="expenses_left">
					<div class="pechalba_icon">&nbsp</div>
					<div class="pechalba_text">Печалба</div>
					<div class="expenses_bash" <?php if($row['pechalba'] < 1) { ?> style="color:#9e171a;" <?php } else { ?> style="color:#0c8f0c;" <?php }?>>
						<?php echo $row['pechalba']; ?>
					</div>
				</div>
			</div>
			<br/>
			<div style="padding-left:30px;">
			<a href="<?php echo base_url().'more/area/'.$row['ao_area_id'];?>" style="color:#20808C;text-decoration:none;">Виж подробни данни</a>
			</div>
		</div>
		<div class="bm_right_side">
		<?php if($row['tomato_education'] == 0) { // if the user hasn't education ?>
			<div class="build_create_container">
				<div class="lm_uni_icon">&nbsp;</div>
				<div class="building_crate_text">Нямате образование за земеделие</div>
				<div class="building_crate_smalltext" style="margin-left:5px;">
					Можете да го получите от 
					<a class="licesense_link" href="<?php echo base_url(); ?>university">университета</a>
				</div>
			</div>
		<?php } else {  ?>
			<!-- AREA SPACE -->
			<div class="build_create_container">
				<div class="building_area_icon">&nbsp;</div>
				<div class="building_crate_text">Площ: <?php echo $row['ao_space'];?> декара</div>
				<div class="building_crate_buy_button">
				<input type="button" onclick="show_more_buyarea_div(<?php echo $row['ao_area_id']; ?>)" value="Купи още"/>
				</div>
			</div>
			<!-- END OF AREA SPACE -->
			<!--- MINIMAL REQUIREMENTS --->
			<div class="build_create_container">
				<div class="cow_building_icon">&nbsp;</div>
				<div class="building_crate_text">Информация за производството</div>
				<?php //if($row['level'] == 2) cena 500, 1100kv.m. ?>
				<div class="building_crate_smalltext">Посеви</div>
				<div class="building_crate_smalltext">30 грама семена за декар</div>
				<div class="building_crate_smalltext">Цена: 120 за декар</div>
				<div class="building_crate_smalltext">&nbsp;</div>
				<div class="building_crate_smalltext">Вода/Поливане</div>
				<div class="building_crate_smalltext">40 куб. на декар</div>
				<div class="building_crate_smalltext">Цена за кубик: 1,50</div>
				<div class="building_crate_smalltext">Обща цена на декар: 60</div>
				<div class="building_crate_smalltext">&nbsp;</div>
				<div class="building_crate_smalltext">Добив</div>
				<div class="building_crate_smalltext">5 тона домати от 1 декар</div>
				<div class="building_crate_smalltext">Цена на изкупуване за тон: 500</div>
				<div class="building_crate_smalltext">&nbsp;</div>
				<div class="building_crate_smalltext">Време за растеж: 3 дни</div>
				<div class="building_crate_smalltext">&nbsp;</div>
				<div class="building_crate_smalltext">
					Засяване на площ: 
					<input type="text" onkeypress="validate(event)" id="tf_space_seed" maxlength="4" style="width:75px;"/>
					<input type="button" onclick="calc_tomato_seed()" id="df_space_calc_design" value="Изчисли"/>
				</div>
				<div class="building_crate_smalltext"><div id="show_cow_calc_space"></div></div>
			</div>
			<!--- END OF MINIMAL REQUIREMENTS --->
			<!-- BUILD BUTTON -->
			<div class="area_button">
				<input type="button" onclick="tomato_seed(<?php echo $row['ao_area_id']; ?>)" value="Засяване" />
			</div>
			<!-- END OF BUILD BUTTON -->
		<?php } ?>
		</div>
	</div>
</div>
<div id="buy_morearea_div_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hide_morebuy_area_div()" style="color:#fff;">Close</a>
	<div class="buy_area_div_container" id="sa">
		<div class="text_buyarea_title">Купуване на площ</div>
		<div class="text_buyarea_left"><div style="width:150px;float:left;">Цена за декар: 300</div> <div class="lm_money_icon">&nbsp;</div></div><br/>
		<div class="text_buyarea_left">
			Напишете колко декара искате: <input type="text" maxlength="4" id="area_buy_space_wanted" onkeypress='validate(event)' />
			<div class="area_calculate"><input type="button" value="Изчисли" onclick="calculate_buymore_area(300, 900, 10)"/></div>
		</div>
		<div id="text_buyarea_calculated"></div><br/>
		<div class="area_buy_button">
		<input type="button" id="buy_area_button" value="Купи" 
		onclick="buy_more_area(300, <?php echo $row['ao_area_id']; ?>, load_build_tomatos);"/>
		</div>
		
	</div>
</div>
<!-- END OF BUILD APARTMENTS VIEW -->