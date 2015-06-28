<!-- MESSAGES VIEW -->
<div id="main_container_view">
	<div class="write_mess">
		<textarea id="mess_content" rows="4" onkeypress="on_enter_press(event, <?php echo $this->session->userdata('user_id'); ?>, <?php echo $select_id; ?>);"></textarea>
		<input type="button" id="mess_button_send" value="Изпрати" 
									onclick="send_message(<?php echo $this->session->userdata('user_id'); ?>, <?php echo $select_id; ?>)" />
	</div>
	<div id="suc_send"></div>
	<div id="convesation" class="messages_container">
		<?php foreach($conv AS $row) { ?>
		<div class="one_message">
			<div class="fav_pic">
				<a href="<?php echo base_url().'profile/'.$row['mess_from_id']; ?>">
					<?php if($row['picture'] != 'none') { ?>
						<img src="<?php echo base_url(); ?>uploaded_pictures/avatars/<?php echo $row['picture']; ?>" />
					<?php } else { ?>
						<img src="<?php echo base_url(); ?>uploaded_pictures/none/none.gif" width="45" height="45" />
					<?php	
						}
					?>
				</a>
			</div>
			
			<div class="fav_name"> 
				<a href="<?php echo base_url().'profile/'.$row['mess_from_id']; ?>" style="font-size:13px;color:#776F6F;">
					<?php echo $row['username']; ?>
				</a>
			</div>
			<span class="mess_date" style="color:#808080;padding-left:10px;">
				<?php 
				echo date("d.m.Y ", $row['mess_date']); 
				echo $row['mess_clock'];
			?>
			</span>

			<div class="bash_message">
				<?php echo $row['message']; ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<br/>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/messages.js"></script>
<!-- END OF MESSAGES VIEW -->