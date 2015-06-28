<!-- LEFT MENU -->
<div id="left_menu">
	<!-- CHAT Div -->
	<div id="chat">
	<a href="javascript:void(0)" onclick="chat_box()">
		<span class="top_blue_line">
			<div class="chat_link">Чат</div>
			<div class="chat_arrow">&nbsp;</div>
		</span>
	</a>
	<div id="chat_box">
		
	</div>
	</div>
	<!-- END OF CHAT Div -->
	<!-- USER div -->
	<div class="lm_Home">
		<div class="lm_user_icon">&nbsp;</div>
		<span class="lm_text"><?php echo $this->session->userdata('username'); ?></span>
	</div>
	<!-- End of USER div -->
	<!-- IF THE USER IS AN ADMIN -->
	<?php if($this->session->userdata('rank') == '1') { ?>
	<div class="lm_job">
		<div class="lm_user_icon">&nbsp;</div>
		<span class="lm_text"><b><a href="<?php echo base_url(); ?>admin/home">АДМИН ПАНЕЛ</a></b></span>
	</div>
	<?php } ?>
	<!-- END OF ADMIN'S DIV -->
	<div class="lm_line">&nbsp;</div>
	<!-- HOME div -->
	<div class="lm_Home">
		<div class="lm_home_icon">&nbsp;</div>
		<span class="lm_text">Жилище</span>
		<?php if($row['uc_home']==1) { // checks if the user has a home ?>
		<div class="lm_green_icon"></div>
		<?php } else { ?>
		<div class="lm_red_icon"></div>
		<?php } ?>
	</div>
	<!-- End of HOME div -->
	<!-- JOB div -->
	<div class="lm_job">
		<div class="lm_job_icon">&nbsp;</div>
		<span class="lm_text">Работа</span>
		<?php if($row['uc_job']==1) { // checks if the user has a job ?>
		<div class="lm_green_icon"></div>
		<?php } else { ?>
		<div class="lm_red_icon"></div>
		<?php } ?>
	</div>
	<!-- End of JOB div -->
	<div class="lm_line">&nbsp;</div>
	<!-- POWER div -->
	<div class="lm_identical">
		<div class="lm_power_icon">&nbsp;</div>
		<div class="lm_text_pw">Власт</div>
		<div class="lm_set"><?php echo $row['uc_power']; ?></div>
	</div>
	<!-- end of POWER div -->
	<!-- ENERGY div -->
	<div class="lm_identical">
		<div class="lm_energy_icon">&nbsp;</div>
		<div class="lm_text_pw">Енергия</div>
		<div class="lm_set"><?php echo $row['uc_energy']."%"; ?></div>
	</div>
	<!-- end of ENERGY div -->
	<!-- FUN div -->
	<div class="lm_identical">
		<div class="lm_fun_icon">&nbsp;</div>
		<span class="lm_text">Забавления</span>
		<div class="lm_set_text"><?php echo $row['uc_fun']."%"; ?></div>
	</div>
	<!-- end of FUN div -->
	<!-- TUZAR div -->
	<div class="lm_identical">
		<div class="lm_glasses_icon">&nbsp;</div>
		<span class="lm_text">Тузар</span>
		<div class="lm_set_text"><?php echo number_format((float)$row['uc_tuz'], 2, '.', ''); ?></div>
	</div>
	<!-- end of TUZAR div -->
	<div class="lm_line">&nbsp;</div>
	<!-- MONEY div -->
	<div class="lm_identical">
		<div class="lm_money_icon">&nbsp;</div>
		<span class="lm_text">Пари</span>
		<div class="lm_set_text"><?php $subtotal =  number_format($row['uc_money'], 0, '.', ' '); echo $subtotal; ?></div>
	</div>
	<!-- end of MONEY div -->
	<!-- AREAS div -->
	<div class="lm_identical">
		<div class="lm_areas_icon">&nbsp;</div>
		<span class="lm_text">Имоти/Площи</span>
		<div class="lm_set_text"><?php echo $row['uc_areas']; ?></div>
	</div>
	<!-- end of AREAS div -->
	<!-- CARS div -->
	<div class="lm_identical">
		<div class="lm_cars_icon">&nbsp;</div>
		<span class="lm_text">Превозни средства</span>
		<div class="lm_set_text"><?php echo $row['uc_vehicles']; ?></div>
	</div>
	<!-- end of CARS div -->
	<!-- JEWELLERIES div -->
	<div class="lm_identical">
		<div class="lm_jews_icon">&nbsp;</div>
		<span class="lm_text">Бижута</span>
		<div class="lm_set_text"><?php echo $row['uc_jewelries']; ?></div>
	</div>
	<!-- end of JEWELLERIES div -->
	<div class="lm_line">&nbsp;</div>
	<!-- license div -->
	<div class="lm_identical">
		<div class="lm_lic_icon">&nbsp;</div>
		<span class="lm_text"><a href="<?php echo base_url();?>license">Комисии за лиценз</a></span>
	</div>
	<!-- end of license div -->
	<!-- UNIVERSITY div -->
	<div class="lm_identical">
		<div class="lm_uni_icon">&nbsp;</div>
		<span class="lm_text"><a href="<?php echo base_url();?>university">Университет</a></span>
	</div>
	<!-- end of UNIVERSITY div -->
	<!-- SHOP div -->
	<div class="lm_identical">
		<div class="lm_shop_icon">&nbsp;</div>
		<span class="lm_text"><a href="<?php echo base_url();?>shop">Пазар</a></span>
	</div>
	<!-- end of SHOP div -->
	<!-- ARTICLES div -->
	<div class="lm_identical">
		<div class="lm_art_icon">&nbsp;</div>
		<?php if($row['uc_job']==0) { // checks if the user has a job ?>
		<span class="lm_text"><a href="<?php echo base_url();?>findjob">Намери работа</a></span>
		<?php } else { ?>
		<span class="lm_text"><a href="<?php echo base_url();?>job">Работа</a></span>	
		<?php } ?>
	</div>
	<!-- end of ARTICLES div -->
</div>
<!-- END OF LEFT MENU -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/chat.js"></script>
