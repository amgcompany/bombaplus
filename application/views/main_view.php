<!-- MAIN VIEW -->
<div id="main_container_view">
	<div class="zones_cont">
	<div class="city_zone_container_link">
		<a href="javascript:void(0)" onclick="load_center_areas_view(1, 0)"><?php echo $zone[0]['city_zone']; ?></a>
	</div>
	<!-- SHOWS ALL ZONES FROM THE CITY -->
	<div id="city_zone">

	</div>
	<!-- END OF CITY ZONE -->
	<div class="city_zone_container_link">
		<a href="<?php echo base_url(); ?>living_area"><?php echo $zone[1]['city_zone']; ?></a>
	</div>
	<div class="city_zone_container_link">
		<a href="<?php echo base_url(); ?>industrial" onclick="call_indus_zone()"><?php echo $zone[2]['city_zone']; ?></a>
	</div>
	</div>
</div>
<!-- END OF MAIN VIEW -->
<div id="buy_area_div_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hide_buy_area_div()" style="color:#fff;">Close</a>
	<div class="buy_area_div_container" id="sa">
		<div class="text_buyarea_title">Купуване на площ</div>
		<div class="text_buyarea_left"><div style="width:150px;float:left;">Цена за кв.м: 400</div> <div class="lm_money_icon">&nbsp;</div></div><br/>
		<div class="text_buyarea_left">
			Напишете колко кв.м. искате: <input type="text" maxlength="4" id="area_buy_space_wanted" onkeypress='validate(event)' />
			<div class="area_calculate"><input type="button" value="Изчисли" onclick="calculate_buy_area(400, 5000)"/></div>
		</div>
		<div id="text_buyarea_calculated"></div><br/>
		<div class="area_buy_button"><input type="button" id="buy_area_button" value="Купи" onclick="buy_area(400, <?php echo $this->session->userdata('user_id'); ?>, 0)"/></div>
		
	</div>
</div>
<input type="hidden" id="hidden_zone_id" value="<?php echo $zone[0]['cz_id']; ?>"/>
<input type="hidden" id="hidden_zone_hide_id" value="1"/>
<input type="hidden" id="hidden_page_number" value="0"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/main.js"></script>