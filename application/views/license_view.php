<!-- LICENSES DESIGN -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Комисии за лиценз
	</div>
	<div class="license_container">
		<div id="apartment_notification"></div>
		<div class="casino_license">
			<div class="casino_card_icon">&nbsp;</div>
			<div class="casino_license_text">Лиценз за казино</div>
			<?php if($casino['num_rows'] != 1) { ?>
			<div class="casino_license_text">Цена: 250 000</div>
			<div class="casino_buy_button">
			<div class="buy_apartment_button" style="margin-top:0px;margin-left:20px;">
				<input type="button" onclick="buy_license(1, '<?php echo base_url(); ?>')" value="Купи лиценз">
			</div>
			</div>
			<?php } else { ?> 
			<div class="casino_license_text">Купен</div>
			<?php } ?>
		</div>
		<div class="casino_license">
			<div class="casino_gold_icon">&nbsp;</div>
			<div class="casino_license_text">Лиценз за добив на злато</div>
			<?php if($gold['num_rows'] != 1) { ?>
			<div class="casino_license_text">Цена: 5 500 000</div>
			<div class="casino_buy_button">
			<div class="buy_apartment_button" style="margin-top:0px;margin-left:20px;">
				<input type="button" onclick="buy_license(2, '<?php echo base_url(); ?>')" value="Купи лиценз">
			</div>
			</div>
			<?php } else { ?> 
			<div class="casino_license_text">Купен</div>
			<?php } ?>
		</div>
		<div class="casino_license">
			<div class="casino_oil_icon">&nbsp;</div>
			<div class="casino_license_text">Лиценз за добив на нефт</div>
			<?php if($oil['num_rows'] != 1) { ?>
			<div class="casino_license_text">Цена: 30 000 000</div>
			<div class="casino_buy_button">
			<div class="buy_apartment_button" style="margin-top:0px;margin-left:20px;">
				<input type="button" onclick="buy_license(3, '<?php echo base_url(); ?>')" value="Купи лиценз">
			</div>
			</div>
			<?php } else { ?> 
			<div class="casino_license_text">Купен</div>
			<?php } ?>
		</div>
	</div>
</div>
<!-- END OF LICENSES DESIGN -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/main.js"></script>