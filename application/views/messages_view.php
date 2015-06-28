<!-- MESSAGES VIEW -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Лични съобщения
	</div>
	<?php 
	if(empty($row_mess)) { ?>
		<div class="sell_not"><div class="sell_red">Вие нямате лични съобщения</div></div>
	<?php
	} else {
	foreach($row_mess AS $row) { ?>
	<a href="<?php echo base_url()?>messages/conversation/<?php echo $row['mess_hash']; ?>" class="redirect_tomessview">
		<span 
		<?php if($row['mess_viewed']==0 && $row['mess_from_id']!=$this->session->userdata('user_id')){ ?> 
			class="un_read_mess" 
		<?php } else { ?> 
			class="mess_conversations" 
		<?php } ?>>
		
			<span class="fav_pic">
				<?php if($row['picture'] != 'none') { ?>
				<img src="<?php echo base_url(); ?>uploaded_pictures/avatars/<?php echo $row['picture']; ?>" />
				<?php } else { ?>
				<img src="<?php echo base_url(); ?>uploaded_pictures/none/none.gif" />
				<?php } ?>
			</span>
			<span class="mess_name">
				<?php if(isset($row['username'])) { echo $row['username']; } ?>
			</span>
			<span class="mess_date">
				<?php if(isset($row['mess_date'])) { echo date("d.m.Y ", $row['mess_date']);  } 
					  if(isset($row['mess_date'])) { echo $row['mess_clock'];  } 
				?>
			</span>
			<span class="row_mess_lm">
			<?php if(isset($row['last_mess'])) { echo $row['last_mess'];
												if(mb_strlen($row['last_mess'], "UTF-8")>=100) echo "..."; } ?>
			</span>
		</span>
	</a>
	<br/>
	<?php } ?>
	<?php } ?>
</div>
<!-- END OF MESSAGES VIEW -->