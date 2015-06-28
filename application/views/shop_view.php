<!-- SHOP VIEW  -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Пазар
	</div>
	<div class="top_shop">
		<div class="top_shop_left">
			<!--<div class="shop_cat_icon">&nbsp;</div>
			<div class="shop_cat_title">Изберте категория</div>-->
		</div>
		<div class="top_shop_right">
			<a href="<?php echo base_url(); ?>sell" class="main_shop_button">Пусни за продан</a>
		</div>
	</div>
	<div class="middle_shop">
		<div class="middle_top_shop">
			<div class="shop_div_icon"></div>
			<div class="shop_product_title">Продукт</div>
			<div class="shop_user_title">Потребител</div>
			<div class="shop_quantity_title" title="Количество">Кол.</div>
			<div class="shop_prize_title">Цена</div>
			<div class="shop_prize_title">Кол.</div>
		</div>
		<div class="shop_products">
		<?php if(!isset($articles['product_num_rows'])) { ?>
		<?php foreach($articles AS $product) { ?>
			<!-- ONE SHOP PRODUCT FROM ALL ARTICLES -->
			<div class="shop_one_product">
				<div class="<?php echo $product['div_icon']; ?>_div_icon">&nbsp;</div>
				<div class="shop_product_title"><?php echo $product['shop_subcategory']; ?></div>
				<div class="shop_user_title"><a href="<?php echo base_url().'profile/'.$product['user_id']; ?>"><?php echo $product['username']; ?></a></div>
				<div class="shop_quantity_title"><?php echo $product['shop_art_quantity']; ?></div>
				<div class="shop_prize_title"><?php echo $product['prize']; ?></div>
				<?php if($product['user_id'] == $this->session->userdata('user_id')) { ?> 
				<div class="shop_q_field">
					<a href="javascript:void(0)" onclick="delete_shop_article(<?php echo $product['shop_article_id']; ?>)">Изтрий</a>
				</div>
				<?php } else { ?>
				<div class="shop_q_field">
					<input type="text" id="product_quantity_<?php echo $product['shop_article_id']; ?>" class="dish_price" onkeypress='validate(event)' maxlength="15"/>
				</div>
				<div class="shop_buy_button_cont">
					<div class="shop_buy_button">
						<input type="button" onclick="buy_thing_shop(<?php echo $product['shop_article_id']; ?>)" value="Купи"/>
					</div>
				</div>
				<?php } ?>
			</div>
			<!-- END OF ONE PRODUCT -->
			<div id="sell_div_notification_<?php echo $product['shop_article_id']; ?>"></div>
		<?php } ?>
		<?php } else { ?> 
		<div class="shop_one_product" id="no_articles_in_shop">
			Няма обяви за продан
		</div>
		<?php } ?>
		</div>
	</div>
	<div id="shop_pagination">
	<?php echo $this->pagination->create_links(); ?>
	</div>
</div>
<!-- END OF SHOP VIEW -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/shop.js"></script>