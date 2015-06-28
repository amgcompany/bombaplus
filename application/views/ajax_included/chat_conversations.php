<!-- CHAT_BOX DIV CONTAINER -->
<div id="chat_title">Съобщения</div>
<div id="chat_container">
	<?php foreach($row_mess AS $row) { ?>
	<div class="one_message">
	<a href="javascript:void(0)" onclick="load_conversation(<?php echo $row['mess_hash']; ?>)" class="redirect_tomessview">
	<span class="chat_pic">
		<?php if($row['picture'] != 'none') { ?>
			<img src="<?php echo base_url(); ?>uploaded_pictures/avatars/<?php echo $row['picture']; ?>" />
		<?php } else { ?>
			<img src="<?php echo base_url(); ?>uploaded_pictures/none/none.gif" width="45" height="45" />
		<?php	
			}
		?>
	</span>
	<span>
	<span class="chat_name">
		<?php if(isset($row['username'])) { echo $row['username']; } ?>
	</span>
	<span class="chat_mess_lm">
		<?php if(isset($row['last_mess'])) { echo $row['last_mess'];
											if(mb_strlen($row['last_mess'], "UTF-8")>=100) echo "..."; } ?>
	</span>
	</span>
	</a>
	</div>
	<?php } ?>
</div>