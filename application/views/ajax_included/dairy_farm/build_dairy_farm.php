<!-- BUILD APARTMENTS VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Администрация на кравеферма</div>
	</div>
	<div id="build_mansions_not_div"></div>
	<div class="build_mansions">
		<div class="bm_left_side">
			<div class="area">
				<?php if($row['is_build'] == 0 || ($row['is_build'] == 1)) { ?>
				<div class="cow_building_symbol_left">&nbsp;</div>
				<div class="small_building_art">&nbsp;</div>
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
		<?php if($row['animal_education'] == 0) { // if the user has education?>
			<div class="build_create_container">
				<div class="lm_uni_icon">&nbsp;</div>
				<div class="building_crate_text">Нямате образование за животновъдство</div>
				<div class="building_crate_smalltext" style="margin-left:5px;">
					Можете да го получите от 
					<a class="licesense_link" href="<?php echo base_url(); ?>university">университета</a>
				</div>
			</div>
		<?php } else {  ?>
		<?php if($row['is_build'] == 0) { // if there is no builded mansions before that ?>
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
				<div class="building_crate_text">Минимални изисквания за една крава</div>
				<?php //if($row['level'] == 2) cena 500, 1100kv.m. ?>
				<div class="building_crate_smalltext">5 кв.м - място за живеене</div>
				<div class="building_crate_smalltext">7 кв.м - Сеновал за сено и слама</div>
				<div class="building_crate_smalltext">3 кв.м - Торище</div>
				<div class="building_crate_smalltext">&nbsp;</div>
				<div class="building_crate_smalltext">Общо: 15 кв.м.</div>
			</div>
			<!--- END OF MINIMAL REQUIREMENTS --->
			<!-- Allow to build -->
			<div class="build_create_container">
				<div class="building_area_allowbuild_icon">&nbsp;</div>
				<div class="building_crate_text">Разрешително за строеж</div>
				<?php if($row['license_to_build'] == 0) { ?>
				<div class="building_crate_smalltext">Цена: 10 000</div>
				<div class="building_crate_buy_button"><input type="button" onclick="buy_allow_build(<?php echo $row['ao_area_id']; ?>, load_build_cow)" value="Купи"/></div>
				<?php } else { ?>
				<div class="building_crate_smalltext">Купено</div>
				<?php } ?>
			</div>
			<!-- END of Allow to build -->
			<!--- BUILDING BUILDING --->
			<div class="build_create_container">
				<div class="building_area_build_icon">&nbsp;</div>
				<div class="building_crate_text">Строеж на сграда за крави</div>
				<div class="building_crate_smalltext">Цена: 100 за кв.м</div>
				<div class="building_crate_smalltext">Застрояване на минимум 250кв.м.</div>
				<div class="building_crate_smalltext">
					Колко кв.м. ще застроите: 
					<input type="text" onkeypress="validate(event)" id="df_space_build"/>
					<input type="button" onclick="calc_cow_space()" id="df_space_calc_design" value="Изчисли"/>
				</div>
				<div class="building_crate_smalltext"><div id="show_cow_calc_space"></div></div>
			</div>
			<!--- END OF BUILDING BUILDING --->
			<!-- BUILD BUTTON -->
			<?php if($row['is_build'] == 0 && $row['license_to_build'] == 1) { ?>
			<div class="area_button">
				<input type="button" onclick="build_dairy_farm(<?php echo $row['ao_area_id']; ?>)" value="Строеж на кравеферма" />
				<?php /* 1) area_id, 2) level, 3) how much money does the building cost 900*220=198000 */?>
			</div>
			<?php } else { ?> 
			<div class="build_create_container">
				<div class="building_crate_smalltext"><b>Не сте изпълнили всички изисквания, за да започнете строеж</b></div>
			</div>
			<!-- END OF BUILD BUTTON -->
			<?php } ?>
		<?php } ?>
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
		onclick="buy_more_area(300, <?php echo $row['ao_area_id']; ?>, load_build_cow);"/>
		</div>
		
	</div>
</div>
<!-- END OF BUILD APARTMENTS VIEW -->