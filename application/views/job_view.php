<!-- JOB VIEW -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Работа
	</div>
	<div id="job">
		<div id="build_mansions_not_div"></div>
		<div class="area">
			<div class="area_for_sale_title">Професия: <b><?php echo $job[0]['job_offer']; ?></b></div>
			<div class="job_pixel_art">&nbsp;</div>
		</div>
		<div class="area">
		<?php if($job[0]['js_level']<=2 || $job[0]['limit_passed'] == 1) { ?>
			<div class="area_for_sale_title">Заплата: <b><?php echo $job[0]['salary']; ?></b></div>
			<div class="work_pixel_art">&nbsp;</div>
			<div class="area_bought_button"><input type="button" onclick="work()" value="Работа" /></div>
		<?php } else { ?>
			<div class="area_for_sale_title">Може да работите отново<br/> след 15 мин. в: <b><?php echo date('H:i:s', $job[0]['limit']); ?></b> ч.</div>
			<div class="work_pixel_art">&nbsp;</div>
		<?php } ?>
		</div>
		<div class="area">
			<div class="area_for_sale_title">Напускане</div>
			<div class="quitjob_pixel_art">&nbsp;</div>
			<div class="area_bought_button">
			<input type="button" onclick="quit_job('<?php echo base_url(); ?>findjob')" value="Напусни работата" />
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/job.js"></script>
