<!-- SELL MAIN CATS -->
<div class="sell_main_cats">
	<div class="sell_main_cats_title"></div>
	<?php if(!isset($products['product_num_rows'])) { ?>
	<div id="all_sell_main_cats">
		<div class="middle_top_shop">
			<div class="shop_div_icon"></div>
			<div class="shop_product_title">Продукт</div>
			<div class="shop_quantity_title" title="Количество">Кол.</div>
			<div class="shop_prize_title">Определи количество</div>
			<div class="shop_prize_title">Определи цена</div>
		</div>
		<div class="shop_products">
		<?php foreach($products AS $product) { ?> 
			<div class="shop_one_product">
				<div class="<?php echo $product['div_icon']; ?>_div_icon">&nbsp;</div>
				<div class="shop_product_title"><?php echo $product['shop_subcategory']; ?></div>
				<div class="shop_quantity_title"><?php echo $product['q_property_quantity']; ?></div>
				<div class="shop_q_field">
					<input type="text" class="dish_price" id="quantity_<?php echo $product['shop_subcat_id'];?>" onkeypress='validate(event)' maxlength="15"/>
				</div>
				<div class="shop_q_field">
					<input type="text" class="dish_price" id="prize_<?php echo $product['shop_subcat_id'];?>" onkeypress='validate(event)' maxlength="15"/>
				</div>
				<div class="shop_buy_button_cont">
					<div class="shop_buy_button">
						<input type="button" onclick="sell_shop(<?php echo $product['shop_subcat_id'].', '.$product['shop_cat_id']; ?>)" value="Пусни"/>
					</div>
				</div>
			</div>
			<div id="sell_div_notification_<?php echo $product['shop_subcat_id']; ?>"></div>
		<?php } ?>
		</div>
	</div>
	<?php } else { ?>
	<div class="sell_no_products">
		Вие нямате продукти от тази категория
	</div>
	<?php } ?>
</div>