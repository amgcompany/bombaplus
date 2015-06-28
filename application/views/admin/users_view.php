<!-- USERS VIEW -->
<div class="users_view">
	<h3>Потребители</h3>
	<span>Общо: <b><?php echo $all_users;?></b></span><br/>
	<span>Днес: <b><?php echo $today_sign;?></b></span>
	<!-- SHOWS LAST 20 USERS -->
	<div class="some_users">
		<h4>Последни 20</h4>
		<table border="1" style="width:90%;margin:0 auto;">
			<tr>
				<td>ИД</td>
				<td>Потребител</td>
				<td>Е-поща</td>
				<td>IP на рег.</td>
				<td>Дата на рег.</td>
				<td>Ранк</td>
			</tr>
			<?php foreach($last_tw as $user) { ?>
			<tr>
			<td><?php echo $user['user_id']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['ip_of_reg']; ?></td>
			<td><?php echo $user['date_of_reg']; ?></td>
			<td><?php echo $user['rank']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<!-- END OF 20 LAST USERS -->
	<!-- LOOKING FOR USER -->
	<h4>Tърсене на потребител</h4><h6>(FULL TEXT SEARCH)</h6>
	<div class="look_for_user">
		<input type="text" onkeyup="search_user()" id="ussearch" />
		<h6>Може да се наложи да натиснете "ENTER"</h6>
		<div id="show_user">
		</div>
	</div>
	<!-- END OF LOOKING FOR USER -->
</div>
<!-- END OF USERS VIEW -->