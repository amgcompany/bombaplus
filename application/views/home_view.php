<!-- HEADER -->
<div id="header">
	<div id="brand">
		<div class="title">Bomba+</div>
		<div class="subtitle">Онлайн игра, огледало на самоличността</div>
	</div>
	<!-- LOGIN & SignUp Navigation -->
	<nav class="home_nav">
		<ul>
			<li><div class="reg_button"><input type="button" value="Регистрация" onclick="showRegForm();" /></div></li>
			<li><div class="login_button"><input type="button" value="Вход" onclick="showLoginForm();" /></div></li>
		</ul>
	</nav>
	<div class="space_div">&nbsp;</div>
</div>
<!-- END OF HEADER -->
<!-- QUOTE PIC -->
<div id="quote_pic">
	<div class="quote_container">
		<div class="quote_top">”Ако действително можете да преброите парите си, </div>
		<div class="quote_bottom">то вие все още не сте богат човек..” </div>
		<div class="quote_author">Жан Пол Гети</div>
	</div>
</div>
<!-- END OF QUOTE PIC -->

<div class="line">&nbsp;</div>
<!-- COLUMNS DIV -->
<div id="columns">
	<div class="column_container">
		<div class="one_column">
			<div class="first_column_icon">&nbsp;</div>
			<div class="column_title">Избери си зона</div>
			<div class="column_text">Играта Ви предлага три градски зони: Център, Жилищен квартал, Индустриална зона</div>
		</div>
		<div class="one_column">
			<div class="second_column_icon">&nbsp;</div>
			<div class="column_title">Намери си работа</div>
			<div class="column_text">Миньор, рибар, геолог, шофьор, търговоец, банкер. А ти какво ще работиш ?</div>
		</div>
		<div class="one_column">
			<div class="third_column_icon">&nbsp;</div>
			<div class="column_title">Основи свой бизнес</div>
			<div class="column_text">Земеделие, нефт, злато, ресторанти, хотели, казина, банки. Направи своя избор, създай корпорация за милиарди и завладей града</div>
		</div>
		<div class="one_column">
			<div class="fourth_column_icon">&nbsp;</div>
			<div class="column_title">Изкушения</div>
			<div class="column_text">Скъпи къщи, коли. Самолети, яхти, бижута. Можеш ли да устоиш ?</div>
		</div>
	</div>
</div>
<!-- END OF COLUMNS DIV -->

<!-- CAN YOU ESCAPE RAT RACE TEXT -->
<div id="rat_race">
	<div class="grey_arrow">&nbsp;</div>
	<div class="rat_race_text">Можеш ли да се измъкнеш от състезанието за плъхове</div>
	
</div>
<div id="what_rat_race">
	<div class="blue_arrow">&nbsp;</div>
	<div class="ratRaceContainer">
		<div class="ratSymbolFloat"><div class="ratRaceSymbol">&nbsp;</div></div>
		<div class="ratLeftSide">
			<div class="ratTitle">Какво е състезание за плъхове ?</div>
			<div class="ratBullets">
				<ul>
					<li>Завършвате университет с висока оцека, за си намерите сигурна работа</li>
					<li>Намирате си сигурна работа, работите по 8 часа на ден за добри пари</li>
					<li>Харесавате си къща , скъпа кола, но спестяванията Ви не стигат</li>
					<li>Теглите кредит, купувате желаните от вас неща</li>
					<li>Погасявате високи кредити, заедно с  лукса и данъците Ви нарастват</li>
					<li>Парите Ви не стигат и отново се връщате на сигурната си работа, и така до старини вие сте роб на банките и на вискоките данъци</li>
				<ul>
			</div>
		</div>
	</div>
</div>
<!-- END OF CAN YOU ESCAPE RAT RACE TEXT -->

<!-- FOOTER -->
<div id="indexFooter">	
	<div class="foot_arrow">&nbsp;</div>
	<div class="indexFooterContainer">
		<div class="iFCLeft">
			<div class="iFCText">Какво е Bomba+ ?</div><br/>
			<div class="iFCInfo">Проeктът е онлайн-социална игра, огледало на самоличността. Защо огледало? Действията, които играчите ще предприемат в играта са повечето действия които те биха предпочели и в реалния живот. 
			По трози начин играта може да прави разлика между бедни, средна класа и богати</div>
		</div>
		<div class="iFCRight">
			<div class="iFCText">Връзки</div><br/>
			<!--<ul>
				<li><a href="">За проекта</a></li>
				<li><a href="">Общи условия</a></li>
				<li><a href="">Anti-social Networks</a></li>
			</ul>-->
			<ul>
				<li><a href="<?php echo base_url(); ?>contacts">Контакти</a></li>
				<li><a href="http://www.sb.pleven-mg.com" target="new">SpaceBrainer</a></li>
			</ul>
		</div>
	</div>
</div>
<!-- END OF FOOTER -->

<!-- LOGIN FORM -->
<div id="login_form_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hideLoginForm()" style="color:#fff;">Close</a>
	<div id="login_form">
	<div class="login_top">
		<div class="login_title">Вход</div>
		<div class="login_icon">&nbsp;</div>
	</div>
	<div class="login_middle">
		<form method="post" action="<?php echo base_url();?>home/login">
			<div class="login_forms">
				<?php if($er == 2) { ?>
					<div class="sucreg">Успешена регистрация. Влезте в профила си.</div>
				<?php } ?>
				<?php if($er == 4) { ?>
					<div class="wrong_login">Грешно потребителско име или парола</div>
				<?php } ?>
				<div class="login_username"><input type="text" name="username" 
										value="<?php 
												if($this->input->post('username')) {echo $this->input->post('username');} 
													else if($er == 2 && ($this->input->post('reg_username'))) {echo $this->input->post('reg_username');}
													else {echo "Потребителско име";}
												?>" 
										onfocus="if(this.value=='Потребителско име')this.value='';"
										onblur="if(this.value=='')this.value='Потребителско име';" /></div>
				<div class="login_password" id="passcontainer"><input type="text" name="password" value="Парола" 
											onfocus="mpass()"
											onblur="if(this.value=='')this.value='Парола';" /></div>
				<div class="login_enter_button"><input type="submit" name="login" value="Вход" /></div>
				<a href="<?php echo base_url(); ?>home/forgotten" class="forgotten_password">Забравена парола</a>
			</div>
		</form>
	</div>
	<div class="login_bottom">
	&nbsp;
	</div>
	</div>
</div>
<!-- END OF LOGIN FORM -->
<!-- SING UP FORM -->
<div id="reg_form_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hideRegForm()" style="color:#fff;">Close</a>
	<div id="reg_form">
	<div class="reg_top">
		<div class="reg_title">Регистрация</div>
		<div class="reg_icon">&nbsp;</div>
	</div>
	<div class="reg_middle">
		<form method="post" action="<?php echo base_url();?>home/register">
			<div class="login_forms">
				<div class="login_username"><input type="text" name="reg_username" 
										value="<?php if($this->input->post('reg_username')) {echo $this->input->post('reg_username');} else {echo "Потребителско име";}?>" 
										onfocus="if(this.value=='Потребителско име')this.value='';"
										onblur="if(this.value=='')this.value='Потребителско име';" /></div>
				<?php echo form_error('reg_username', '<div class="error">', '</div>'); ?>
				<div class="reg_email"><input type="text" name="email" 
										value="<?php if($this->input->post('email')) {echo $this->input->post('email');} else {echo "Електронна поща";}?>" 
										onfocus="if(this.value=='Електронна поща')this.value='';"
										onblur="if(this.value=='')this.value='Електронна поща';" /></div>
				<?php echo form_error('email', '<div class="error">', '</div>'); ?>
				<div class="login_password" id="regpass"><input type="text" 
											value="Парола" 
											onfocus="regmpass()"
											onblur="if(this.value=='')this.value='Парола';" /></div>
				<?php echo form_error('reg_password', '<div class="error">', '</div>'); ?>
				<div class="login_password" id="cregpass"><input type="text" value="Потвърди парола" 
											onfocus="cregmpass()"
											onblur="if(this.value=='')this.value='Потвърди парола';" /></div>
				<?php echo form_error('creg_password', '<div class="error">', '</div>'); ?>
				<div class="reg_enter_button"><input type="submit" name="reg" value="Регистрирай ме" /></div>
				<br/>
			</div>
		</form>
	</div>
	<div class="reg_bottom">
	&nbsp;
	</div>
	</div>
</div>
<!-- END OF SING UP FORM -->
<script type="text/javascript" src="<?php echo base_url();?>js/index.js"></script>
<script type="text/javascript">
<?php if($er == 1) { ?>
document.getElementById("reg_form_overlay").style.visibility = "visible";
<?php } ?>
<?php if($er == 2) { ?>
document.getElementById("login_form_overlay").style.visibility = "visible";
<?php } ?>
<?php if($er == 4) { ?>
document.getElementById("login_form_overlay").style.visibility = "visible";
<?php } ?>
</script>