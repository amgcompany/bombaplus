<!-- PROFILE VIEW -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Профил
	</div>
	<div id="user_profile">
		<div id="user_profile_left">
			<!-- AVATAR PICTURE -->
			<div class="up_avatar_div">
			<?php if($user[0]['avatar_picture'] != 'none') { ?> 
			<img src="<?php echo base_url().'uploaded_pictures/avatars/'.$user[0]['avatar_picture']; ?>" width="180" />
			<?php } else { ?> 
			<img src="<?php echo base_url(); ?>uploaded_pictures/none/none.gif" />
			<?php }?>
			</div>
			<!-- AVATAR UPLOAD PIC LINK DIV -->
			<?php if($this->session->userdata('user_id') == $user[0]['user_id']) { ?>
			<div class="upa_link_div">
				<div class="upa_icon">&nbsp;</div>
				<a href="javascript:void(0);" onclick="show_upload_avatar();" />Снимка на профила</a>
			</div>
			<?php } ?>
		</div>
		<!-- RIGHT SIDE -->
		<div id="user_profile_right">
			<!-- USERNAME -->
			<div class="one_user_condition">
				<div class="lm_user_icon">&nbsp;</div>
				<?php echo $user[0]['username']; ?>
			</div>
			<!-- POWER -->
			<div class="one_user_condition">
				<div class="lm_power_icon">&nbsp;</div>
				<?php echo $user[0]['uc_power']; ?>
			</div>
			<!-- TUZ -->
			<div class="one_user_condition">
				<div class="lm_glasses_icon">&nbsp;</div>
				<?php echo number_format((float)$user[0]['uc_tuz'], 2, '.', ''); ?>
			</div>
			<?php if($this->session->userdata('user_id') != $user[0]['user_id']) { ?>
			<!-- SEND MESSAGE BUTTON -->
			<div class="one_user_condition">
				<div class="send_message_pb">
					<?php if($conv != '0') { ?>
					<input type="button" onclick="load_conversation(<?php echo $conv; ?>);" value="Съобщение"/>
					<?php } else { ?>
					<input type="button" onclick="show_send_mess();" value="Съобщение"/>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<br/>
</div>
<!-- SEND MESSAGE --->
<div id="send_message_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hide_sm();" style="color:#fff;">Close</a>
	<div id="upload_avatar_picture">
		<table>
		<tr><td><textarea id="mess_content" rows="5" cols="50"></textarea></tr></td>
		<tr><td><input type="button" onclick="send_message(<?php echo $this->session->userdata('user_id').', '.$user[0]['user_id']; ?>)" value="Изпрати"></tr></td>
		<tr><td><div id="suc_send"></div></tr></td>
		</table>
	</div>
</div>
<!--- UPLOAD AVATAR PICTURE --->
<div id="buy_area_div_overlay">
	<a href="javascript:void(0)" rel="previous" class="pgzoomclose" title="Затвори" onClick="hide_upa();" style="color:#fff;">Close</a>
	<div id="upload_avatar_picture">
		<div class="uap_left">
		<?php if($user[0]['avatar_picture'] != 'none') { ?> 
		<img src="<?php echo base_url().'uploaded_pictures/avatars/'.$user[0]['avatar_picture']; ?>" width="180" />
		<?php } else { ?> 
		<img src="<?php echo base_url(); ?>uploaded_pictures/none/none.gif" width="180" />
		<?php }?>
		</div>
		
		<div class="uap_right">
			<div class="upa_link_div">
				<div class="upa_icon">&nbsp;</div>
				<span class="uap_text" />Снимка на профила</span>
			</div>
			<div class="upa_link_div">
				<div class="upa_icon">&nbsp;</div>
				<span class="uap_text" />Формати: JPG, GIF, PNG</span>
			</div>
			<form method="post" enctype="multipart/form-data" action="<?php echo base_url()?>profile/upload_avatar/<?php echo $user[0]['user_id']; ?>">
				<input type="file" name="userfile" />
				<input type="submit" name="click" value="Добави" />
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/profile.js"/></script>