<!-- FOUND USER VIEW -->
<div id="admin_found_users">
	<?php
	if($result != 0) {
	?>
	<?php foreach($result AS $row) { ?>
		<div class="found_user_input">	
			<table border="1" style="width:90%;margin:0 auto;">
			<tr>
				<td>ИД</td>
				<td>Потребител</td>
				<td>Е-поща</td>
				<td>IP на рег.</td>
				<td>Дата на рег.</td>
				<td>Ранк</td>
			</tr>
			<tr>
				<td><?php echo $row['user_id']; ?></td>
				<td><?php echo $row['username']; ?></td>
				<td><?php echo $row['email']; ?></td>
				<td><?php echo $row['ip_of_reg']; ?></td>
				<td><?php echo $row['date_of_reg']; ?></td>
				<td><?php echo $row['rank']; ?></td>
			</tr>
			<table>
		</div>
		<!-- CHECKS LOGS -->
		<?php if($row['is_logs'] == 1) { ?>
		<center><h3>Последни 5 логове</h3></center>
		<table border="1" style="width:90%;margin:0 auto;">
			<tr>
				<td><b>Дата на логин</b></td>
				<td><b>IP на логин</b></td>
			</tr>
		<?php foreach($row['logs'] AS $log) { ?>
			<tr>
				<td><?php echo $log['acc_log_date']; ?></td>
				<td><?php echo $log['acc_log_ip']; ?></td>
			</tr>
		<?php } ?>
		</table>
		<?php } else { echo "<center><h3>Няма логове</h3></center>";} ?>
		<!-- END OF CHECKING LOGS -->
		
		<!-- SHOW 10 LAST ACTIVITIES -->
		<?php if($row['is_activity'] == 1) { ?>
		<center><h3>Последни 20 активности</h3></center>
		<table border="1" style="width:90%;margin:0 auto;">
			<tr>
				<td><b>Действие</b></td>
				<td><b>Описание</b></td>
				<td><b>Изпозлвани пари</b></td>
				<td><b>Дата</b></td>
				<td><b>IP</b></td>
			</tr>
			<?php foreach($row['activity'] AS $act) { ?>
			<tr>
				<td><?php echo $act['ua_action']; ?></td>
				<td><?php echo $act['ua_description']; ?></td>
				<td><?php echo $act['ua_money_spent']; ?></td>
				<td><?php echo $act['ua_date_activity']; ?></td>
				<td><?php echo $act['ua_ip_activity']; ?></td>
			</tr>
			<?php } ?>
		</table>
		<?php } else {echo "<center><h3>Няма резултати за активност</h3></center>";} ?>
	<?php } ?>
	<?php 	} else { ?>
		Не беше намерен такъв потребител
	<?php } ?>
</div>
<!-- END OF FOUND USER VIEW -->