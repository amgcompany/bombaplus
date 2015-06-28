<!-- BUILD CASINO -->
<div id="build_bank">
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Казино</div>
	</div>
	<div id="build_mansions_not_div"></div>
	<div class="bm_left_side">
		<div class="area">
			<?php if($row['is_build'] == 0 || $row['is_build'] == 1) { ?>
			<div class="casino_pixel_art">&nbsp;</div>
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
		<!-- GETS CASINO's MONEY -->
		<?php if($row['is_build'] == 1) { ?>
		<div class="get_casino_money">
			<div class="get_cm_text">Пари в казиното</div>
			<div class="expenses_profits_left">
				<div class="expenses_left">
					<div class="casino_money_icon">&nbsp</div>
					<div class="casino_left_text">Налични</div>
					<div class="expenses_bash"><?php echo number_format($row['b_casino_money'], 0, '.', ' '); ?></div>
				</div>
			</div>
			<div class="get_cm_text">Вкарай пари в казиното</div>
			<div class="casino_left_input">
				<div class="credit_text_input" style="margin-left:30px;">
					<input type="text" id="casino_insert_sum" value="Въведете сума" 
					onfocus="if(this.value=='Въведете сума')this.value='';"
					onblur="if(this.value=='')this.value='Въведете сума';"
					onkeypress="validate(event);"/>
				</div>
			</div>
			<div class="casino_arrow_button">
				<div class="top_arrow_button">
					<input type="button" onclick="insert_more_casino_money(<?php echo $row['ao_area_id']; ?>)"/>
				</div>
			</div>
			<br/><br/>
			<div class="get_cm_text">Изтегли пари от казиното</div>
			<div class="casino_left_input">
				<div class="credit_text_input" style="margin-left:30px;">
					<input type="text" id="casino_sum" value="Въведете сума" 
					onfocus="if(this.value=='Въведете сума')this.value='';"
					onblur="if(this.value=='')this.value='Въведете сума';"
					onkeypress="validate(event);"/>
				</div>
			</div>
			<div class="casino_arrow_button">
				<div class="bottom_arrow_button">
					<input type="button" onclick="get_casino_money(<?php echo $row['ao_area_id']; ?>, 5000000)"/>
				</div>
			</div>
			<div class="expenses_profits_left">
				<div id="apartment_notification" style="text-align:left;"></div>
			</div>
		</div>
		<?php } ?>
		<!-- END OG GETTING CASINO'S MOENY -->
	</div>
	<!-- RIGHT SIDE -->
	<div class="bm_right_side">
		<?php if($row['is_build'] == 0) { ?>
		<?php if($row['has_license'] <= 0) { ?> 
		<div class="build_create_container">
			<div class="lm_lic_icon">&nbsp;</div>
			<div class="building_crate_text">Купете лиценз за казино</div>
			<div class="building_crate_smalltext" style="margin-left:5px;">
				Можете да го купите от 
				<a class="licesense_link" href="<?php echo base_url(); ?>license">комисиите за лиценз</a>
			</div>
		</div>
		<?php 
			} else if($row['has_license'] >= 1 && $row['license_to_build'] == 0) {
		?>
			<div class="build_create_container">
				<div class="lm_lic_icon">&nbsp;</div>
				<div class="building_crate_text">Лиценз купен</div>
			</div>
			<div class="build_create_container">
				<div class="building_area_allowbuild_icon">&nbsp;</div>
				<div class="building_crate_text">Разрешително за строеж</div>
				<?php if($row['license_to_build'] == 0) { ?>
				<div class="building_crate_smalltext">Цена: 10 000</div>
				<div class="building_crate_buy_button"><input type="button" onclick="buy_allow_build(<?php echo $row['ao_area_id']; ?>, load_build_casino)" value="Купи"/></div>
				<?php } else { ?>
				<div class="building_crate_smalltext">Купено</div>
				<?php } ?>
			</div>			
		<?php
			} else if($row['license_to_build'] == 1) {
		?>
		<div class="build_create_container">
			<div class="lm_lic_icon">&nbsp;</div>
			<div class="building_crate_text">Лиценз купен</div>
		</div>
		<div class="build_create_container">
			<div class="building_area_allowbuild_icon">&nbsp;</div>
			<div class="building_crate_text">Разрешително за строеж</div>
			<?php if($row['license_to_build'] == 0) { ?>
			<div class="building_crate_smalltext">Цена: 10 000</div>
			<div class="building_crate_buy_button"><input type="button" onclick="buy_allow_build(<?php echo $row['ao_area_id']; ?>, load_build_casino)" value="Купи"/></div>
			<?php } else { ?>
			<div class="building_crate_smalltext">Купено</div>
			<?php } ?>
		</div>	
		<div class="build_create_container">
			<div class="dish_price_icon">&nbsp;</div>
			<div class="building_crate_text">Добавете сума за старт:</div>
			<div class="credit_text_input" style="margin-left:23px;">
				<input type="text" id="casino_sum" value="Въведете сума" 
				onfocus="if(this.value=='Въведете сума')this.value='';"
				onblur="if(this.value=='')this.value='Въведете сума';"
				onkeypress="validate(event);"/>
			</div>
			<div class="building_crate_smalltext">Минимална сума: 5 000 000</div>
			<div class="building_crate_buy_button">
			<input type="button" value="Добави" onclick="insert_casino_money(<?php echo $area_id; ?>)" />
			</div>
		</div>
		<div class="build_create_container">
			<div id="apartment_notification" style="text-align:left;"></div>
		</div>
		<?php }
		} else {
			/* CHEKS IF IT IS ALL BUILD AND IT IS CATEGORY 7 IN areas */
			if($row['builded_at_all'] == 0) {
		?>
			<div class="build_create_container">
				<div class="lm_lic_icon">&nbsp;</div>
				<div class="building_crate_text">Лиценз купен</div>
			</div>
			<div class="build_create_container">
				<div class="building_area_allowbuild_icon">&nbsp;</div>
				<div class="building_crate_text">Разрешително за строеж</div>
				<?php if($row['license_to_build'] == 1) { ?>
				<div class="building_crate_smalltext">Купено</div>
				<?php } ?>
			</div>	
			<div class="build_create_container">
				<div class="dish_price_icon">&nbsp;</div>
				<div class="building_crate_text">Добавена сума: <?php echo number_format($row['b_casino_money'], 0, '.', ' '); ?></div>
			</div>
			<!-- Building -->
			<div class="build_create_container">
				<div class="building_area_build_icon">&nbsp;</div>
				<div class="building_crate_text">Строеж </div>
				<?php //if($row['level'] == 2) cena 500, 1100kv.m. ?>
				<div class="building_crate_smalltext">Цена: 900 за кв.м</div>
				<div class="building_crate_smalltext">Общо: <?php echo $row['ao_space'];?>х150 = <?php $sum=$row['ao_space']*900;echo number_format($sum, 0, '.', ' ');?></div>
			</div>
			<!-- END of Building -->
			<div class="area_button">
				<input type="button" onclick="build_casino(<?php echo $row['ao_area_id'].', '.$sum; ?>)" value="Строеж на казино" />
			</div>
		<?php
			} else if($row['builded_at_all'] == 1) { 
			/*--- CASINO ADMINISTRATION ---*/
		?>
			<div class="casino_prizes_title">Награди и печалби в казиното</div>
			<br/>
			<div class="casino_prizes_subtitle"><b>При съвпадение от две еднакви, <br/>залогът се увеличава с %</b></div>
			<br/>
			<div class="casino_bash_prizes">
			<?php foreach($row['prizes'] AS $prize) { ?>
			<?php if($prize['bcp_how_numbers'] == 2) { // two same digits?> 
			<div class="prize_div">
			<?php
				if($prize['bcp_type'] == 1) {
				echo '<img src="/imgs/casino/one_small.png" /><img src="/imgs/casino/one_small.png" /> X ';
				}
				if($prize['bcp_type'] == 2) {
					echo '<img src="/imgs/casino/two_small.png" /><img src="/imgs/casino/two_small.png" /> X ';
				}
				if($prize['bcp_type'] == 3) {
					echo '<img src="/imgs/casino/three_small.png" /><img src="/imgs/casino/three_small.png" /> X ';
				}
				if($prize['bcp_type'] == 4) {
					echo '<img src="/imgs/casino/four_small.png" /><img src="/imgs/casino/four_small.png" /> X ';
				}
				if($prize['bcp_type'] == 5) {
					echo '<img src="/imgs/casino/five_small.png" /><img src="/imgs/casino/five_small.png" /> X ';
				}
				if($prize['bcp_type'] == 6) {
					echo '<img src="/imgs/casino/six_small.png" /><img src="/imgs/casino/six_small.png" /> X ';
				}
			?>
			залогът се увеличава с <b><?php echo $prize['bcp_prize'].'%'; ?></b>
			</div>
			<?php } ?>
			<?php } ?>
			<br/>
			<div class="casino_prizes_subtitle"><b>При съвпадение от три еднакви наградите са:</b></div>
			<br/>
			<?php foreach($row['prizes'] AS $prize) { ?>
			<?php if($prize['bcp_how_numbers'] == 3) { // two same digits?> 
			<div class="prize_div">
				
				<?php
				if(($prize['bcp_type']-6) == 1) {
					echo '<img src="/imgs/casino/one_small.png" /><img src="/imgs/casino/one_small.png" /><img src="/imgs/casino/one_small.png" />';
				}
				if(($prize['bcp_type']-6) == 2) {
					echo '<img src="/imgs/casino/two_small.png" /><img src="/imgs/casino/two_small.png" /><img src="/imgs/casino/two_small.png" />';
				}
				if(($prize['bcp_type']-6) == 3) {
					echo '<img src="/imgs/casino/three_small.png" /><img src="/imgs/casino/three_small.png" /><img src="/imgs/casino/three_small.png" />';
				}
				if(($prize['bcp_type']-6) == 4) {
					echo '<img src="/imgs/casino/four_small.png" /><img src="/imgs/casino/four_small.png" /><img src="/imgs/casino/four_small.png" />';
				}
				if(($prize['bcp_type']-6) == 5) {
					echo '<img src="/imgs/casino/five_small.png" /><img src="/imgs/casino/five_small.png" /><img src="/imgs/casino/five_small.png" />';
				}
				if(($prize['bcp_type']-6) == 6) {
					echo '<img src="/imgs/casino/six_small.png" /><img src="/imgs/casino/six_small.png" /><img src="/imgs/casino/six_small.png" />';
				}
				?> 
				наградата е 
				
				<input type="text" value="<?php echo $prize['bcp_prize']; ?>" maxlength="13" class="update_casino_prize" onkeypress="validate(event)" id="casino_sum_to_<?php echo $prize['bc_prize_id'];?>" />
				<input type="button" value="Промени" onclick="change_casino_prize(<?php echo $area_id.', '.$prize['bc_prize_id'];?>)" />
			</div>
			<?php } ?>
			<?php } ?>
			<div id="casino_prize_notification"></div>
			</div>
		<?php
		
			}
			/*** END OF CASINO ADMINISTRATION ***/
		}
		?>
	</div>
</div>
</div>
<!-- END OF BUILD CASINO -->