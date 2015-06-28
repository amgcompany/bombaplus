<!-- SELL VIEW -->
<div id="main_container_view">
	<div class="city_zone_container_link">
		Пазар - Пусни за продан
	</div>
	<div class="top_shop">
		<div class="top_shop_left">
			<div class="shop_cat_icon">&nbsp;</div>
			<div class="shop_sell_cat_title">Изберте категория</div>
			<div class="shop_category_menu">
				<ul>
					<li>
						<a href="javascript:void(0);">Категории</a>
						<ul>
						<?php foreach($categories as $categoru) { ?> 
							<li><a href="javascript:void(0);" onclick="get_sell_category(<?php echo $categoru['shop_cat_id']; ?>);">
							<?php echo $categoru['shop_category']; ?>
							</a></li>
						<?php } ?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="sell_users_properties">
	</div>
	<br/>
</div>
<!-- END OF SHOP VIEW -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/sell_properties.js"></script>