<div id="main_container_view">
	<br/>
	<div class="choose_build_title">Информация за приходи и разходи за имот</div>
	<br/>
	<div class="more_expenses_div">
		<div class="expenses_title"><center>Приходи</center></div>
		<br/>
		<table border="1">
			<tr>
				<td><b>&numero;</b></td>
				<td><b>Действие</b></td>
				<td><b>Спечелени пари</b></td>
				<td><b>Дата</b></td>
			</tr>
			<?php $i=0; foreach($profs AS $prof) { $i++;?>
			<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $prof['aerna_money_description']; ?></td>
			<td><?php echo number_format($prof['aem_money_earn'], 0, '.', ' '); ?></td>
			<td><?php echo $prof['aem_date']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<br/>
	<div class="more_expenses_div">
		<div class="expenses_title"><center>Разходи</center></div>
		<br/>
		<table border="1">
			<tr>
				<td><b>&numero;</b></td>
				<td><b>Действие</b></td>
				<td><b>Инвестирани пари</b></td>
				<td><b>Дата</b></td>
			</tr>
			<?php $j=0; foreach($exps AS $exp) { $j++; ?>
			<tr>
			<td><?php echo $j; ?></td>
			<td><?php echo $exp['aspent_money_description']; ?></td>
			<td><?php echo number_format($exp['asm_money_invest'], 0, '.', ' '); ?></td>
			<td><?php echo $exp['asm_date']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<br/>
</div>