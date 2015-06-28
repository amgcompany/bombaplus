<!-- DAIRY FARM ADMINISTRATION -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Администрация на кравеферма</div>
	</div>
	<div id="build_mansions_not_div"></div>
	<div id="dairy_farm_main_info">
		<div class="area">
			<div class="area_for_sale_title">Крави: <b><?php echo $row['df_cows']; ?></b></div>
			<div class="cow_pixel_art">&nbsp;</div>
		</div>
		<div class="area">
			<div class="area_for_sale_title">Капацитет: <b><?php echo $row['cow_capacity']; ?></b> крави</div>
			<div class="small_building_art">&nbsp;</div>
		</div>
		<div class="area">
			<div class="area_for_sale_title">Купи крави</div>
			<div class="arew_cow_container">
				<div class="buy_cow_pricetag">&nbsp;</div>
				<div>Цена за крава: <b>1200</b></div>
				<div class="buy_cow_div_input">
					<div class="credit_text_input">
						<input type="text" id="number_of_cows" value="Брой крави" 
						onfocus="if(this.value=='Брой крави')this.value='';"
						onblur="if(this.value=='')this.value='Брой крави';"
						onkeypress="validate(event);"
						maxlength="4"/>
					</div>
				</div><br/>
				<div class="buy_cow_button">
					<input type="button" onclick="buy_cow(<?php echo $area_id; ?>)" value="Купи крава/и" />
				</div>
			</div>
		</div>
		<div>&nbsp;</div>
		<div class="area">
			<div class="area_for_sale_title">Добив на мляко</div>
			<div class="arew_cow_container">
				<div class="cow_milk">&nbsp;</div>
				<div class="cow_text_left">
					Добив за 6 часа:
					<br/> 
					<?php $lits = $row['df_cows']*240;echo $row['df_cows'].' крави х 240 литра <br/>'.$lits.' литра'; ?>
				</div>
				<div class="cow_text_milk">
					<div class="cow_clock">&nbsp;</div>
					<div>Една крава за 6 часа:<br/> 240 литра</div>
				</div>
				<div class="cow_text_milk">
					<div class="buy_cow_pricetag">&nbsp;</div>
					<div>Цена за литър мляко:<br/> 0,50</div>
				</div>
			</div>
		</div>
		<div class="area">
			<?php if($row['milk_production'] == 0 && $row['dfd_milk_producing'] == 0 && $row['is_finished'] == 0) { ?>
				<div class="area_for_sale_title">Производство на мляко през 6 часа</div> 
				<div class="big_cow_clock">&nbsp;</div>
				<div class="area_bought_button"><input type="button" onclick="milk_production(<?php echo $area_id; ?>)" value="Старт"/></div>
			<?php } else if($row['milk_production'] == 1 && $row['is_finished'] == 0) { ?>
			<div class="arew_cow_container">
				<div class="cow_clock">&nbsp;</div>
				<div class="cow_text_left">
				Завършва в: <?php echo $row['milk_prod_finish']; ?>
				</div>
				<div class="milking_cow_pixel">&nbsp;</div>
			</div>
			<?php } else if($row['milk_production'] == 0 && $row['dfd_milk_producing'] == 1 && $row['is_finished'] == 1) { ?> 
				<div class="area_for_sale_title">Готова продукция</div>
				<div class="milk_basket_pixel">&nbsp;</div>
				<div class="area_bought_button"><input type="button" onclick="get_milk_production(<?php echo $area_id; ?>)" value="Събери продукцията"/></div>
			<?php } ?>
		</div>
		<div class="area">
			<div class="area_for_sale_title">Мляко: <b><?php echo number_format($row['df_litres_milk'], 0, '.', ' ') ?></b> литра</div>
			<div class="milk_storage_pixel">&nbsp;</div>
			<div class="area_bought_button"><input type="button" onclick="sell_milk(<?php echo $area_id; ?>)" value="Продай"/></div>
		</div>
	</div>
	<div class="build_mansions">
		<div class="bm_left_side">
			<div class="area">
				<div class="cow_building_symbol_left">&nbsp;</div>
				<div class="small_building_art">&nbsp;</div>
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
		<!-- AREA SPACE -->
			<div class="build_create_container">
				<div class="building_area_icon">&nbsp;</div>
				<div class="building_crate_text">Площ: <?php echo $row['ao_space'];?> декара</div>
				<div class="building_crate_buy_button">
				<input type="button" onclick="show_more_buyarea_div(<?php echo $row['ao_area_id']; ?>)" value="Купи още"/>
				</div>
			</div>
		<!-- END OF AREA SPACE -->
		<!--- BUILDING BUILDING --->
			<div class="build_create_container">
				<div class="building_area_build_icon">&nbsp;</div>
				<div class="building_crate_text">Сградата за крави: <?php echo $row['df_space_builded']; ?> кв.м.</div>
				<div class="building_crate_smalltext">Капацитет: <?php echo $row['cow_capacity']; ?> крави</div>
				<div class="building_crate_smalltext">Необходимо място за една крава: 15 кв.м</div>
				<div class="building_crate_smalltext">&nbsp;</div>
				<div class="building_crate_smalltext">Цена: 100 за кв.м</div>
				<div class="building_crate_smalltext">
					Застрояване на още кв.м: 
					<input type="text" onkeypress="validate(event)" id="df_space_build" maxlength="4" />
					<input type="button" onclick="calc_cow_morespace(<?php echo $row['cow_capacity']; ?>)" id="df_space_calc_design" value="Изчисли"/>
				</div>
				<div class="building_crate_smalltext"><div id="show_cow_calc_space"></div></div>
			</div>
			<!--- END OF BUILDING BUILDING --->
			<!-- BUILD BUTTON -->
			<div class="area_button">
				<input type="button" onclick="build_more_space_df(<?php echo $row['ao_area_id']; ?>)" value="Застрояване на още кв.м." />
				<?php /* 1) area_id, 2) level, 3) how much money does the building cost 900*220=198000 */?>
			</div>
			<!-- END OF BUILD BUTTON -->
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
		onclick="buy_more_area(300, <?php echo $row['ao_area_id']; ?>, admin_dairy_farm);"/>
		</div>
		
	</div>
</div>
<!-- END OF DAIRY FARM ADMINISTRATION -->