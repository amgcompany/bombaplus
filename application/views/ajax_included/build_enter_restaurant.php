<!-- ENTERS RESTAURANT VIEW -->
<div class="build_apartments">
	<div class="ajax_header_container">
		<a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)" class="ajax_back_icon">&nbsp;</a>
		<div class="back_icon_title"><a href="javascript:void(0)" onclick="load_center_areas_view(<?php echo $zone_id.', '.$page; ?>)">Назад</a></div>
		<div class="choose_build_title">Ресторант</div>
	</div>
	<div class="build_mansions">
		<div class="dishes">
		<span>Ястия</span>
		<br/><br/>
		<div class="apartment_sold">
			<div id="show_bought_dish"></div>
			<div class="top_dishes">
				<div class="top_dish">
					<div class="dish_icon">&nbsp;</div>
					<span class="dish_top_title">Ястие</span>
				</div>
				<div class="top_energy">
					<div class="dish_energy_icon">&nbsp;</div>
					<span class="dish_top_title">Енергия</span>
				</div>
				<div class="top_energy">
					<div class="dish_quantity_icon">&nbsp;</div>
					<span class="dish_top_title">Количество</span>
				</div>
				<div class="top_energy">
					<div class="dish_price_icon">&nbsp;</div>
					<span class="dish_top_title">Цена</span>
				</div>
			</div>
			<div class="bottom_dishes">
			<table>
				<?php foreach($row['dishes'] as $dish) { ?> 
					<tr>
						<td class="dish"><?php echo $dish['br_dish']; ?></td>
						<td class="dish_energy"><?php echo $dish['br_dish_energy']; ?></td>
						<td class="dish_quantity">
							<select id="get_dish_quantity_<?php echo $dish['dish_id']; ?>">
								<option value="0">---</option>
								<?php $i=0;for($i=1;$i<=5;$i++) { ?> 
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</td>
						<td><div class="dish_price"><?php echo $dish['br_dish_price']; ?></div></td>
						<td>
							<input type="button" 
							onclick="buy_dish(<?php echo $row['ao_area_id']; ?>, <?php echo $dish['dish_id']; ?>);" 
							value="Купи ястие"/>
						</td>
					</tr>
				<?php } ?>
			</table>
			</div>
			<div id="show_prize_result"></div>
		</div>
		</div>
	</div>
</div>
<!-- END OF enter_restaurant -->