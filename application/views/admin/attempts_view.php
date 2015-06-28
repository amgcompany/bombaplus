<!-- ADMINISTRATORS VIEW -->
<div class="bugs_view">
	<h3>Опити за вход</h3>
	<!-- SHOWS ALL ADMINS -->
	<div class="show_bugs">
		<table border="1">
			<tr>
				<td><b>Е-майл</b></td>
				<td><b>Потребителско име</b></td>
				<td><b>Парола</b></td>
				<td><b>Дата на опит</b></td>
				<td><b>ИП на опит</b></td>
			</tr>
			<?php foreach($attempts AS $row) {  ?>
			<tr>	
				<td><?php echo $row['atlog_email'];?></td>
				<td><?php echo $row['atlog_username'];?></td>
				<td><?php echo $row['atlog_password'];?></td>
				<td><?php echo $row['atlog_date'];?></td>
				<td><?php echo $row['atlog_ip'];?></td>
			</tr>
			<?php }  ?>
		</table>
	</div>
</div>
<!-- END OF ADMINISTRATORS VIEW -->