<!-- FIND JOB VIEW -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Намери работа
	</div>
	<!-- SHOWS ALL JOBS TO WORK -->
	<div id="city_zone">
	<?php if($jobs[0]['education']>=1) { ?>
		<div class="job_offers">
	<?php foreach($jobs['jobs'] AS $job) { ?> 
		<div class="uni_specialty">
			<div class="briefcase_job_icon">&nbsp;</div>
			
			<div class="casino_license_text"><?php echo $job['job_offer']; ?></div>

			<div class="casino_license_text">Максимална заплата: <?php echo $job['job_max_salary']; ?></div>
			<div class="casino_buy_button">
			<form method="post" action="<?php echo base_url(); ?>findjob/start_job">
			<div class="start_uni_specialty_button">
				<input type="submit" value="Започни">
				<input type="hidden" name="job_offer_id" value="<?php echo $job['job_offer_id']; ?>">
			</div>
			</form>
			</div>
		</div>
	<?php } ?>
		</div>
	<?php } else { ?>
		<div class="no_job_education">
		За да започнете работа, трябва да имате средно образование. <br/>
		Може да го получите от <a href="<?php echo base_url(); ?>university" class="licesense_link">университета</a>
		</div>
	<?php } ?>
	</div>
</div>