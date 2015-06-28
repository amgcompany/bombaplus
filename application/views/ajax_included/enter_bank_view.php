<!-- BANK VIEW -->
<?php if($credit['does_exists'] == 1) { ?>
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Системна банка</div>
	</div>
	<div class="build_mansions">
		<div class="bm_left_side">
			<div class="area">
				<div class="bank_pixel_art">&nbsp;</div>
			</div>
		</div>
		<div class="bm_right_side">
		<?php if($credit['is_credit_downlaoded'] == 0) { ?>
			<div class="down_credit">
				<div>
					<div class="credit_card_icon">&nbsp;</div> 
					<span class="credit_title">Изтегли бърз кредит</span>
				</div>
				<!-- UP TO 5K -->
				<div class="up_to_fk">
					<div>До 5000</div>
					<div class="credit_rules">
						<span>Правила за спазване при изтеглен бърз кредит</span><br/><br/>
						<span>1. Лихва - 50%</span><br/>
						<span>2. Вноска всеки ден</span><br/>
						<span>3. Краен срок - 6 дни след изтеглянето</span>
					</div>
					<div class="credit_text_input">
					<input type="text" id="credit_sum" maxlength="4" value="Въведете сума" 
					onfocus="if(this.value=='Въведете сума')this.value='';"
					onblur="if(this.value=='')this.value='Въведете сума';"
					onkeypress="validate(event);"/>
					</div>
					<div class="credit_button">
						<input type="button" value="Изтегли" onclick="get_credit(<?php echo $bank_id.', '.$area_id; ?>)"/>
					</div>
					<div id="credit_notification"></div>
				</div>
				<!-- END OF UP TO 5K -->
			</div>
		<?php } else if($credit['is_credit_downlaoded'] == 1 && $credit['is_credit_paid'] ==0) { ?> 
			<div>
				<div class="credit_card_icon">&nbsp;</div> 
				<span class="credit_title">Вашият кредит</span>
				<div class="up_to_fk">
					<table>
						<tr>
						<td>Стойност:</td>
						<td><?php echo number_format($credit[0]['bbc_wanted_money'], 0, '.', ' ');?></td>
						</tr>
						<tr>
						<td>Внасяне на ден/дни:</td>
						<td><?php echo number_format($credit[0]['bbc_per_days'], 0, '.', ' ');?></td>
						</tr>
						<tr>
						<td>Вноски:</td>
						<td>6</td>
						</tr>
						<td>Вноска:</td>
						<td><?php echo number_format($credit[0]['bbc_payment_per_days'], 0, '.', ' ');?></td>
						</tr>
						<tr>
						<td>Изтеглен:</td>
						<td><?php echo date('d.m.Y H:i:s', $credit[0]['bb_credit_date']);?></td>
						</tr>
						<tr>
						<td>Краен срок за връщане:</td>
						<td><?php echo date('d.m.Y H:i:s', $credit[0]['bbc_date_limit']);?></td>
						</tr>
					</table>
					<br/>
					<table>
						<tr><td><b>Напарави вноска</b></td></tr>
						<tr>
							<td>Брой вноски, които ще венесете:</td>
							<td>
								<select id="how_many_payments">
								<option value="0">---
								<?php $i = 0; for($i=1;$i<=10;$i++) { ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
								</select> x <?php echo number_format($credit[0]['bbc_payment_per_days'], 0, '.', ' ');?>
							</td>
						</tr>
						<tr><td>
						<div class="credit_button">
						<input type="button" 
						onclick="credit_payment(<?php echo $credit[0]['bb_credit_id'].', '.$credit[0]['bbc_payment_per_days'].', '.$area_id.', '.$bank_id; ?>)" 
						value="Вноска" />
						</div>
						</td></tr>
						<tr><td><div id="not"></div></td></tr>
					</table>
					<div>
					<br/>
					<span class="credit_title">Вноски</span><br/><br/>
					<table style="text-align:center; width:100%">
						<tr>
							<td>№</td>
							<td>Вноска</td>
							<td>Дата</td>
						</tr>
					<?php $i=0; foreach($payments AS $pay) { $i++; ?>
						<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $pay['bcp_payment']; ?></td>
						<td><?php echo date('d.m.Y H:i:s', $pay['bcp_date']); ?></td>
						</tr>
					<?php } ?>
					</table>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php } else { echo "Няма такава банка";} ?>
<!-- END OF BUILD APARTMENTS VIEW -->