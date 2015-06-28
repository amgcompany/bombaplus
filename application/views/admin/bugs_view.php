<!-- BUGS VIEW -->
<div class="bugs_view">
	<h3>Бъгове</h3>
	<!-- ADDS NEW BUGS -->
	<div class="add_bugs">
		<h4>Добавяне на бъгове</h4>
		<table>
			<tr><td>
				<select id="bug_type">
					<option value="0">Избери тип
					<option value="0">---
					<option value="1">Визуален/Дизайн
					<option value="2">Логически
				</select>
			</td></tr>
			<tr><td>Обяснение на проблема</td></tr>
			<tr><td><textarea rows="5" cols="50" id="description"></textarea></td></tr>
			<tr><td>Конкретна страница/файл/ред/език</td></tr>
			<tr><td><input type="text" id="page" /></textarea></td></tr>
			<tr><td><input type="button" id="add_bug" onclick="add_bug()" value="Добави бъг" /></td></tr>
		</table>
	</div>
	<br/>
	<!-- SHOWS ALL BUGS -->
	<div class="show_bugs">
		<h4>Бъгове</h4>
		<table border="1">
			<tr>
				<td>Тип</td>
				<td>Обяснение</td>
				<td>Местоположение</td>
				<td>Дата</td>
				<td>Оправен</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php foreach($res AS $row) {  ?>
			<tr>	
				<td><?php echo $row['bug_type'];?></td>
				<td><?php echo $row['bug_description'];?></td>
				<td><?php echo $row['bug_page'];?></td>
				<td><?php echo $row['bug_date_added'];?></td>
				<td><?php if($row['bug_repaired'] == '0') { ?>
					<img src="<?php echo base_url(); ?>imgs/leftmenu/hiks.png" />
					<?php } else { ?>
					<img src="<?php echo base_url(); ?>imgs/leftmenu/tick.png" />
					<?php }  ?>
				</td>
				<td><a href="javascript:void(0)" onclick="repair_bug(<?php echo $row['bug_id']; ?>)">Оправен</a></td>
				<td><a href="javascript:void(0)" onclick="delete_bug(<?php echo $row['bug_id']; ?>)">Изтрий</a></td>
			</tr>
			<?php }  ?>
		</table>
	</div>
</div>
<!-- END OF BUGS VIEW -->