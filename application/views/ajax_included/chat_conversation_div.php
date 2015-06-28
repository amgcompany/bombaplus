<?php foreach($conv AS $row) { ?>
	<div class="one_message">
		<span class="chat_pic">
			<a href="<?php echo base_url().'profile/'.$row['mess_from_id']; ?>">
				<?php if($row['picture'] != 'none') { ?>
					<img src="<?php echo base_url(); ?>uploaded_pictures/avatars/<?php echo $row['picture']; ?>" />
				<?php } else { ?>
					<img src="<?php echo base_url(); ?>uploaded_pictures/none/none.gif" width="45" height="45" />
				<?php	
					}
				?>
			</a>
		</span>
		<span>
		<span class="chat_name">
			<a href="<?php echo base_url().'profile/'.$row['mess_from_id']; ?>" >
				<?php echo $row['username']; ?>
			</a>
		</span>
		<span class="chat_mess_lm">
			<?php echo $row['message']; ?>
		</span>
		</span>
	</div>
<?php } ?>