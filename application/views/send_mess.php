<div class="write_mess">
		<textarea id="mess_content" rows="5" cols="100" ></textarea>
		<input type="button" id="mess_button_send" value="Изпрати" 
									onclick="send_message(<?php echo $this->session->userdata('user_id'); ?>, <?php echo '3' ?>)" />
</div>
<div id="suc_send"></div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/messages.js"></script>