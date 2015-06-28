<!-- ADMINISTRATORS VIEW -->
<div class="bugs_view">
	<h3>Администратори</h3>
	<!-- SHOWS ALL ADMINS -->
	<div class="show_bugs">
		<table border="1">
			<tr>
				<td><b>Е-майл</b></td>
				<td><b>Потребителско име</b></td>
				<td><b>Дата на добавяне</b></td>
				<td><b>ИП на добавяне</b></td>
			</tr>
			<?php foreach($admins AS $row) {  ?>
			<tr>	
				<td><?php echo $row['admin_email'];?></td>
				<td><?php echo $row['admin_username'];?></td>
				<td><?php echo $row['admin_added_date'];?></td>
				<td><?php echo $row['admin_added_ip'];?></td>
			</tr>
			<?php }  ?>
		</table>
	</div>
</div>
<!-- END OF ADMINISTRATORS VIEW -->