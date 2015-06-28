<!-- LICENSES DESIGN -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Университет
	</div>
	<div class="license_container">
		<div id="apartment_notification"></div>
		<div class="uni_specialty_top">
			<div class="specialties_icon">&nbsp;</div>
			<div class="specialties_title">Специалности</div>
		</div>
		<?php foreach($row['categories'] AS $spec) { ?>
		<div class="uni_specialty">
			<?php if($spec['uni_spec_id'] == 1) { ?>
			<div class="tractor_icon">&nbsp;</div>
			<?php } else if($spec['uni_spec_id'] == 2) { ?>
			<div class="cow_icon">&nbsp;</div>
			<?php } else if($spec['uni_spec_id'] == 3) { ?>
			<div class="shapka_icon">&nbsp;</div>
			<?php } ?>
			<div class="casino_license_text"><?php echo $spec['u_specialty_title']; ?></div>
			<?php if($spec['spec_num_rows'] == 0) { ?>
			<div class="casino_license_text">Цена за вход: <?php echo $spec['u_specialty_enter_prize']; ?></div>
			<div class="casino_buy_button">
			<div class="start_uni_specialty_button">
				<input type="button" onclick="start_education(<?php echo $spec['uni_spec_id']; ?>, '<?php echo base_url(); ?>')" value="Започни">
			</div>
			</div>
			<?php } else if($spec['uni_spec_id']>=1) { ?>
			<div class="casino_license_text">Цена на теста: <?php echo $spec['us_test_prize'];?></div>
			<div class="casino_buy_button">
			<div class="test_uni_specialty_button">
				<a href="<?php echo base_url(); ?>university/test/<?php echo $spec['uni_spec_id']; ?>">Тест</a>
			</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
</div>
<!-- END OF LICENSES DESIGN -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/main.js"></script>