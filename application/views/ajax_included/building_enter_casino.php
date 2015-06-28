<!-- ENTERS CASINO VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Казино на <a href="<?php echo base_url().'profile/'.$row['owner_id']?>"><?php echo $row['owner']; ?></a></div>
	</div>
	<div class="build_mansions">
		<center>
			<div id="show">
			<div id="randNum"></div>
			<div id="randNum2"></div>
			<div id="randNum3"></div>
			</div>
		</center>
		<br/>
		<!-- BET INPUT AREA AND MAX BET -->
		<div class="casino_prizes_title">
			Максимален залог <?php echo number_format($row['b_casino_max_bet'], 0, '.', ' ');?>
		</div>
		<div id="makeZalog">
			<input type="text" id="zalog" onkeypress='validate(event)' />
			<input type="button" id="zalojogBut" onclick="zaloji(<?php echo $row['casino_id'].', '.$area_id; ?>);" value="Заложи"/>
		
		<!-- END OF BET INPUT AREA -->
		<!-- CASINO BUTTONS -->
			<div id="casino_button">
			<input type="button" id="sbut" onclick="randomJS();" value="Разбъркай" />
			<input type="button" id="but" onclick="gase();" value="Спри" />
			</div>
		<!-- END OF CASINO BUTTONS -->
		
		<div id="showInfo"></div>
		</div>
		<div class="prizes">
			<!-- LEFT SIDE CASINO PRIZES -->
			<div class="casino_left_prizes">
				<div class="casino_prizes_subtitle">При съвпадение от три еднакви наградите са:</div>
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
				наградата е <b><?php echo number_format($prize['bcp_prize'], 0, '.', ' '); ?></b>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
			<!-- END OF LEFT SIDE PRIZES -->
			<!-- RIGHT SIDE CASINO PRIZES -->
			<div class="casino_right_prizes">
				<div class="casino_prizes_subtitle">При съвпадение от две еднакви</div>
				<div class="casino_bash_prizes">
				<?php foreach($row['prizes'] AS $prize) { ?>
				<?php if($prize['bcp_how_numbers'] == 2) { // two same digits?> 
				<div class="prize_div">
				<b><?php
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
				?></b> 
				залогът се увеличава с <b><?php echo $prize['bcp_prize'].'%'; ?></b>
				</div>
				<?php } ?>
				<?php } ?>
				</div>
			</div>
			<!-- END OF RIGHT SIDE -->
		</div>
	</div>
</div>
<!-- END OF CASINo -->
