<!-- BUILD BANK -->
<div id="build_bank">
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Банка</div>
	</div>
	<div class="build_bank">
		<?php if($row['is_build'] == 0) { ?>
		<table>
			<tr><td>Добавете сума за старт:</td></tr>
			<tr><td><input type="text" maxlength="9" id="bank_sum_start" onkeypress="validate(event);" /></td></tr>
			<tr><td><input type="button" value="Старт" onclick="build_bank(<?php echo $area_id; ?>)" /></td></tr>
		</table>
		<?php } else {?>
		<table>
			<tr><td>Сума в банката</td><td><?php echo $row['money_in_the_bank'];?></td></tr>
		</table>
		<br/>
		<span><b>Изтеглени кредити</b></span>
		<br/><br/>
		<table border="1" style="text-align:center;">
			<tr>
				<td>ID</td>
				<td>Потребител</td>
				<td>Изтеглена сума</td>
				<td>Общо за връщане</td>
				<td>Платил досега</td>
				<td>Вноска</td>
				<td>Изтеглен</td>
				<td>Краен срок</td>
			</tr>
			<?php foreach($credits as $credit) { ?>
			<tr>
				<td><?php echo $credit['bb_credit_id']; ?></td>
				<td><a href="<?php echo base_url().'profile/'.$credit['bbc_user_id']; ?>"><?php echo $credit['bbc_user_id']; ?></a></td>
				<td><?php echo $credit['bbc_wanted_money']; ?></td>
				<td><?php echo $credit['bbc_total_money']; ?></td>
				<td><?php echo $credit['bbc_howmuch_paid']; ?></td>
				<td><?php echo $credit['bbc_payment_per_days']; ?></td>
				<td><?php echo date('d.m.Y H:i:s', $credit['bb_credit_date']); ?></td>
				<td><?php echo date('d.m.Y H:i:s', $credit['bbc_date_limit']); ?></td>
			</tr>
			<?php } ?>
		</table>
		<?php } ?>
	</div>
</div>
</div>
<!-- END OF BUILDING BANK -->