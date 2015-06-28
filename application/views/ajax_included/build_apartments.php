<!-- BUILD APARTMENTS VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Строеж на жилищен блок</div>
	</div>
	<div id="build_mansions_not_div"></div>
	<div class="build_mansions">
		<div class="bm_left_side">
			<div class="area">
				<?php if($row['is_build'] == 0 || ($row['is_build'] == 1 && $row['b_apartment_level'] == 1)) { ?>
				<div class="apartments_level_one">&nbsp;</div>
				<?php } else if($row['b_apartment_level'] == 2) { ?>
				<div class="apartments_level_two">&nbsp;</div>
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
			<div class="building_crate_title">Жилищен блок</div>
			<div class="building_crate_text_level">Ниво: 0</div>
			<!-- AREA SPACE -->
			<div class="build_create_container">
				<div class="building_area_icon">&nbsp;</div>
				<div class="building_crate_text">Площ: <?php echo $row['ao_space'];?> кв.м</div>
				<?php // if($row['ao_space']<900 && $row['is_build'] == 0) ?>
				<div class="building_crate_smalltext">Изисква се минимална площ от 900 кв.м</div>
				<div class="building_crate_buy_button"><input type="button" onclick="show_more_buyarea_div(<?php echo $row['ao_area_id']; ?>)" value="Купи още"/></div>
			</div>
			<!-- END OF AREA SPACE -->
			<!-- Allow to build -->
			<div class="build_create_container">
				<div class="building_area_allowbuild_icon">&nbsp;</div>
				<div class="building_crate_text">Разрешително за строеж</div>
				<?php if($row['license_to_build'] == 0) { ?>
				<div class="building_crate_smalltext">Цена: 10 000</div>
				<div class="building_crate_buy_button"><input type="button" onclick="buy_allow_build(<?php echo $row['ao_area_id']; ?>, load_build_apartment)" value="Купи"/></div>
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
				<div class="building_crate_smalltext">Цена: 220 за кв.м</div>
				<div class="building_crate_smalltext">Общо: 900х220 = <?php echo number_format(900*220, 0, '.', ' ');?></div>
			</div>
			<!-- END of Building -->
			<!-- APARTMENTS -->
			<div class="build_create_container">
				<div class="building_area_apartments_icon">&nbsp;</div>
				<div class="building_crate_text">Апартаменти: 5</div>
				<div class="building_crate_smalltext">Цени стандарт, след завършен  строеж</div>
				<br/>
				<div class="building_crate_smalltext">Наем/Седмица: 500</div>
				<div class="building_crate_smalltext">Продажба: 350 000</div>
			</div>
			<!-- END of APARTMENTS -->
			<!-- Time to build -->
			<div class="build_create_container">
				<div class="building_area_clock_icon">&nbsp;</div>
				<div class="building_crate_text">Време за строеж</div>
				<div class="building_crate_smalltext">8 часа</div>
			</div>
			<!-- END of time to build -->
			<!-- BUILD BUTTON -->
			<?php if($row['is_build'] == 0 && $row['ao_space']>=900 && $row['license_to_build'] == 1) { ?>
			<div class="area_button">
				<input type="button" onclick="build_apartments(<?php echo $row['ao_area_id'].', 1, 198000'; ?>)" value="Строеж 1 ниво" />
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
				<span>Апартаменти</span>
				<br/><br/>
				<div class="apartment_price">
					<div class="building_area_price_tag">&nbsp;</div> 
					<div class="apartment_text_title">Опеределете цена за апартамент</div>
					<div class="apartment_sold">
						<div><input type="text" maxlength="8" id="apartmen_define_price" onkeypress='validate(event)' /></div>
						<div class="define_price_button">
							<input type="button" onclick="define_apartment_prize(<?php echo $row['ao_area_id']; ?>);" value="Определи"/>
						</div>
						<div id="show_prize_result"></div>
					</div>
				</div>
				<?php $i=0; foreach($row['ba_owners'] AS $row_bao) { $i++; ?> 
					<div class="apartment">
						<div>
						<div class="building_area_apartments_icon">&nbsp;</div> 
							<span class="apartment_text_title">Апартамент &numero; <?php echo $i;//$row_bao['ba_owners_id']; ?></span>
						</div>
						<?php if($row_bao['ba_owner_sold'] == 0) { ?>
						<div class="apartment_sold">
							<div class="apartment_text_padding">Продава се</div>
							<div class="apartment_text_padding">Цена: <?php echo number_format($row_bao['bao_price'], 0, '.', ' ');?></div>
							<?php if($row['ao_owner_id'] == $row_bao['ba_owner_user_id']) { ?>
								<div class="buy_apartment_button">
									<input type="button" onclick="live_here(<?php echo $row_bao['ba_owners_id'].', '.$row_bao['bao_area_id']; ?>)" value="Живей тук"/>
								</div>
							<?php } ?>
						</div>
						<?php } else { ?> 
						<div class="apartment_sold">
							<div class="apartment_text_padding">
								<div class="lm_user_icon">&nbsp;</div> 
								<a href="<?php echo base_url()."profile/$row_bao[owner_user_id]"; ?>"><?php echo $row_bao['owner_user']; ?></a>
								живее в този апартамент (продаден)
								<?php if($row['ao_owner_id'] == $row_bao['ba_owner_user_id'] && $row_bao['ba_owner_sold'] == 1) { ?>
								<div class="buy_apartment_button">
									<input type="button" onclick="set_free_apart(<?php echo $row_bao['ba_owners_id'].', '.$row_bao['bao_area_id']; ?>)" value="Освободи"/>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php }?>
					</div>
				<?php } ?>
			</div>
			<!--
			|
			|
			-->
			<br/>
			<hr/>
			<br/>
			<div id="build_mansions_level_two">
			<!-- BUIDLING LEVEL MORE THAN 1 -->
			<?php if($row['b_apartment_level']<2) { ?>
				<div class="building_crate_text_level">Ниво: <?php echo $row['b_apartment_level']; ?></div>
				<!-- AREA SPACE -->
				<div class="build_create_container">
					<div class="building_area_icon">&nbsp;</div>
					<div class="building_crate_text">Площ: <?php echo $row['ao_space'];?> кв.м</div>
					<div class="building_crate_smalltext">
						Изисква се минимална площ от 
						<?php 
						$plosht=0;
						if($row['b_apartment_level']==1) {
							echo "1800 кв.м";
							$plosht = 1800;
						} else if($row['b_apartment_level']==2) {
							echo "2200 кв.м";
							$plosht = 2200;
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
					Цена: <?php if($row['b_apartment_level']==1) {echo "500 за кв.м";} else if($row['b_apartment_level']==2) {echo "1000 за кв.м";}?>
					</div>
					<div class="building_crate_smalltext">
					Общо: 900х<?php 
						$pr=0;
						if($row['b_apartment_level']==1) {
							echo "500";$pr=500;
						} else if($row['b_apartment_level']==2) {
							echo "1000";$pr=1000;
						}
					?> 
					= 
					<?php echo number_format(900*$pr, 0, '.', ' '); $calc = 900*$pr;?>
					</div>
				</div>
				<!-- END of Building -->
				<!-- APARTMENTS -->
				<div class="build_create_container">
					<div class="building_area_apartments_icon">&nbsp;</div>
					<div class="building_crate_text">
					Апартаменти: <?php if($row['b_apartment_level']==1) {echo "10";} else if($row['b_apartment_level']==2) {echo "25";}?>
					</div>
					<div class="building_crate_smalltext">Цени стандарт, след завършен  строеж</div>
					<br/>
					<div class="building_crate_smalltext">Продажба: 350 000</div>
				</div>
				<!-- END of APARTMENTS -->
				<!-- Time to build -->
				<div class="build_create_container">
					<div class="building_area_clock_icon">&nbsp;</div>
					<div class="building_crate_text">Време за строеж</div>
					<div class="building_crate_smalltext">16 часа</div>
				</div>
				<!-- END of time to build -->
				<!-- BUILD BUTTON -->
				<?php if($row['ao_space']>=$plosht) { ?>
				<div class="area_button">
					<input type="button" onclick="build_apartments(<?php $one=$row['b_apartment_level']+1; echo $row['ao_area_id'].','.$one.', '.$calc; ?>)" 
					value="Строеж <?php echo $row['b_apartment_level']+1;?> ниво" />
					<?php /* 1) area_id, 2) level, 3) how much money does the building cost 900*220=198000 */?>
				</div>
				<?php } else { ?> 
				<div class="build_create_container">
					<div class="building_crate_smalltext"><b>Не сте изпълнили всички изисквания, за да започнете строеж на следващо ниво</b></div>
				</div>
				<?php } ?>
				<!-- END OF BUILD BUTTON -->
			<?php } else {
				echo "Всичко е построено до последно ниво";
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
		onclick="buy_more_area(400, <?php echo $row['ao_area_id']; ?>, load_build_apartment);"/>
		</div>
		
	</div>
</div>
<!-- END OF BUILD APARTMENTS VIEW -->