<!-- CHAT_BOX DIV CONTAINER -->
<!--<div id="chat_title">...</div>-->
<div id="chat_write">
	<textarea id="chat_mess" onkeypress="on_enter_press_chat(event, <?php echo $this->session->userdata('user_id'); ?>, <?php echo $select_id.', '.$conv[0]['mess_group_hash']; ?>);"></textarea>
</div>
<div id="chat_container">
	
</div>
