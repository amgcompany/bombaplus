<!-- BUILD APARTMENTS VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Администрация на ресторант</div>
	</div>
	<div id="build_mansions_not_div"></div>
	<div class="build_mansions">
		<?php if($row['is_build'] == 1) { ?>
		<div class="dishes">
		<span>Ястия</span>
		<br/><br/>
		<div class="apartment_sold">
			<div class="top_dishes">
				<div class="top_dish">
					<div class="dish_icon">&nbsp;</div>
					<span class="dish_top_title">Ястие</span>
				</div>
				<div class="top_energy">
					<div class="dish_energy_icon">&nbsp;</div>
					<span class="dish_top_title">Енергия</span>
				</div>
				<div class="top_energy">
					<div class="dish_quantity_icon">&nbsp;</div>
					<span class="dish_top_title">Количество</span>
				</div>
				<div class="top_energy">
					<div class="dish_price_icon">&nbsp;</div>
					<span class="dish_top_title">Цена</span>
				</div>
			</div>
			<div class="bottom_dishes">
			<table>
				<?php foreach($row['dishes'] as $dish) { ?> 
					<tr>
						<td class="dish"><?php echo $dish['br_dish']; ?></td>
						<td class="dish_energy"><?php echo $dish['br_dish_energy']; ?></td>
						<td class="dish_quantity"><?php echo $dish['br_dish_quantity']; ?></td>
						<td><input type="text" class="dish_price" id="dish_price_<?php echo $dish['dish_id'];?>" onkeypress='validate(event)' maxlength="4" value="<?php echo $dish['br_dish_price']; ?>"/></td>
						<td>
							<input type="button" 
							onclick="define_dish_price(<?php echo $row['ao_area_id']; ?>, <?php echo $dish['dish_id']; ?>);" 
							value="Определи"/>
						</td>
					</tr>
				<?php } ?>
			</table>
			</div>
			<div id="show_prize_result"></div>
		</div>
				
		</div>
		<?php } ?>
		<div class="bm_left_side">
			<div class="area">
				<?php if($row['is_build'] == 0 || ($row['is_build'] == 1 && $row['b_restaurant_level'] == 1)) { ?>
				<div class="restaurant_level_one">&nbsp;</div>
				<?php } else if($row['b_restaurant_level'] == 2) { ?>
				<div class="restaurant_level_two">&nbsp;</div>
				<?php }  ?>
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
		<?php if($row['is_build'] == 0) { // if there is no builded mansions before that ?>
			<div class="building_crate_title">Ресторант</div>
			<div class="building_crate_text_level">Ниво: 0</div>
			<!-- AREA SPACE -->
			<div class="build_create_container">
				<div class="building_area_icon">&nbsp;</div>
				<div class="building_crate_text">Площ: <?php echo $row['ao_space'];?> кв.м</div>
				<?php // if($row['ao_space']<900 && $row['is_build'] == 0) ?>
				<div class="building_crate_smalltext">Изисква се минимална площ от 150 кв.м</div>
				<div class="building_crate_buy_button">
				<input type="button" onclick="show_more_buyarea_div(<?php echo $row['ao_area_id']; ?>)" value="Купи още"/>
				</div>
			</div>
			<!-- END OF AREA SPACE -->
			<!-- Allow to build -->
			<div class="build_create_container">
				<div class="building_area_allowbuild_icon">&nbsp;</div>
				<div class="building_crate_text">Разрешително за строеж</div>
				<?php if($row['license_to_build'] == 0) { ?>
				<div class="building_crate_smalltext">Цена: 10 000</div>
				<div class="building_crate_buy_button"><input type="button" onclick="buy_allow_build(<?php echo $row['ao_area_id']; ?>, load_build_restaurant)" value="Купи"/></div>
				<?php } else { ?>
				<div class="building_crate_smalltext">Купено</div>
				<?php } ?>
			</div>
			<!-- END of Allow to build -->
			<!-- Building -->
			<div class="build_create_container">
				<div class="building_area_build_icon">&nbsp;</div>
				<div class="building_crate_text">Строеж </div>
				<?php //if($row['level'] == 2) cena 500, 1100kv.m. ?>
				<div class="building_crate_smalltext">Цена: 150 за кв.м</div>
				<div class="building_crate_smalltext">Общо: 150х150 = <?php echo number_format(150*150, 0, '.', ' ');?></div>
			</div>
			<!-- END of Building -->
			<!-- Time to build -->
			<div class="build_create_container">
				<div class="building_area_clock_icon">&nbsp;</div>
				<div class="building_crate_text">Време за строеж</div>
				<div class="building_crate_smalltext">4 часа</div>
			</div>
			<!-- END of time to build -->
			<!-- BUILD BUTTON -->
			<?php if($row['is_build'] == 0 && $row['ao_space']>=150 && $row['license_to_build'] == 1) { ?>
			<div class="area_button">
				<input type="button" onclick="build_restaurant(<?php echo $row['ao_area_id'].', 1, 22500'; ?>)" value="Строеж 1 ниво" />
				<?php /* 1) area_id, 2) level, 3) how much money does the building cost 900*220=198000 */?>
			</div>
			<?php } else { ?> 
			<div class="build_create_container">
				<div class="building_crate_smalltext"><b>Не сте изпълнили всички изисквания, за да започнете строеж</b></div>
			</div>
			<!-- END OF BUILD BUTTON -->
			<?php } ?>
			<!-- IF THERE IS BUILD MANSIONS -->
			<?php } else { ?>
			<div class="apartments_owner">
			<!--
			|
			|
			-->
			<!-- LOADS STOCKS -->
			<div class="load_res_stocks">
				<table>
					<tr><td><b>Зареждане на ресторанта</b></td></tr>
					<tr><td>Изберете ястие</td></tr>
					<tr><td>
						<select id="load_stocks">
						<option value="0">---</option>
						<?php foreach($row['dishes'] as $dish) { ?> 
							<option value="<?php echo $dish['dish_id']; ?>"><?php echo $dish['br_dish']; ?></option>
						<?php } ?>
						</select>
					</td></tr>
					<tr><td>Количество: 100</td></tr>
					<tr><td>Цена: 500</td></tr>
					<tr><td><input type="button" onclick="load_restaurant_stocks(<?php echo $area_id; ?>);" value="Зареди"/></td></tr>
				</table>
			</div>
			<div id="build_mansions_level_two">
			<!-- BUIDLING LEVEL MORE THAN 1 -->
			<?php if($row['b_restaurant_level']<2) { ?>
				<div class="building_crate_text_level">Ниво: <?php echo $row['b_restaurant_level']; ?></div>
				<!-- AREA SPACE -->
				<div class="build_create_container">
					<div class="building_area_icon">&nbsp;</div>
					<div class="building_crate_text">Площ: <?php echo $row['ao_space'];?> кв.м</div>
					<div class="building_crate_smalltext">
						Изисква се минимална площ от 
						<?php 
						$plosht=0;
						if($row['b_restaurant_level']==1) {
							echo "450 кв.м";
							$plosht = 450;
						} else if($row['b_restaurant_level']==2) {
							echo "700 кв.м";
							$plosht = 700;
						}?>
					</div>
					<div class="building_crate_buy_button"><input type="button" onclick="show_more_buyarea_div(<?php echo $row['ao_area_id']; ?>)" value="Купи още"/></div>
				</div>
				<!-- END OF AREA SPACE -->
				<!-- Building -->
				<div class="build_create_container">
					<div class="building_area_build_icon">&nbsp;</div>
					<div class="building_crate_text">Строеж </div>
					<?php //if($row['level'] == 2) cena 500, 1100kv.m. ?>
					<div class="building_crate_smalltext">
					Цена: <?php if($row['b_restaurant_level']==1) {echo "350 за кв.м";} else if($row['b_restaurant_level']==2) {echo "700 за кв.м";}?>
					</div>
					<div class="building_crate_smalltext">
					Общо: 450х<?php 
						$pr=0;
						if($row['b_restaurant_level']==1) {
							echo "350";$pr=350;
						} else if($row['b_restaurant_level']==2) {
							echo "700";$pr=700;
						}
					?> 
					= 
					<?php echo number_format(450*$pr, 0, '.', ' '); $calc = 450*$pr;?>
					</div>
				</div>
				<!-- END of Building -->
				<!-- Time to build -->
				<div class="build_create_container">
					<div class="building_area_clock_icon">&nbsp;</div>
					<div class="building_crate_text">Време за строеж</div>
					<div class="building_crate_smalltext">10 часа</div>
				</div>
				<!-- END of time to build -->
				<!-- BUILD BUTTON -->
				<?php if($row['ao_space']>=$plosht) { ?>
				<div class="area_button">
					<input type="button" onclick="build_restaurant(<?php echo $row['ao_area_id'].', 2, 157500'; ?>)" 
					value="Строеж <?php echo $row['b_restaurant_level']+1;?> ниво" />
					<?php /* 1) area_id, 2) level, 3) how much money does the building cost 900*220=198000 */?>
				</div>
				<?php } else { ?> 
				<div class="build_create_container">
					<div class="building_crate_smalltext"><b>Не сте изпълнили всички изисквания, за да започнете строеж на следващо ниво</b></div>
				</div>
				<?php } ?>
				<!-- END OF BUILD BUTTON -->
			<?php } else {
				echo "<br/>Всичко е построено до последно ниво";
			} ?>
			<!-- END OF BUIDLING LEVEL 2 -->
			</div>
		<?php }?>
		</div>
	</div>
</div>
<div id="buy_morearea_div_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hide_morebuy_area_div()" style="color:#fff;">Close</a>
	<div class="buy_area_div_container" id="sa">
		<div class="text_buyarea_title">Купуване на още площ</div>
		<div class="text_buyarea_left"><div style="width:150px;float:left;">Цена за кв.м: 400</div> <div class="lm_money_icon">&nbsp;</div></div><br/>
		<div class="text_buyarea_left">
			Напишете колко кв.м. искате: <input type="text" maxlength="4" id="area_buy_space_wanted" onkeypress='validate(event)' />
			<div class="area_calculate"><input type="button" value="Изчисли" onclick="calculate_buymore_area(400, 5000, 10)"/></div>
		</div>
		<div id="text_buyarea_calculated"></div><br/>
		<div class="area_buy_button">
		<input type="button" id="buy_area_button" value="Купи" 
		onclick="buy_more_area(400, <?php echo $row['ao_area_id']; ?>, load_build_restaurant);"/>
		</div>
		
	</div>
</div>
<!-- END OF BUILD APARTMENTS VIEW -->