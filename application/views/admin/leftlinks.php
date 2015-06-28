<!-- ADMIN LEFT MENU LINKS -->
<div id="admin_left_menu">
	<ul>
		<li><a href="<?php echo base_url(); ?>admin/home">Начало</a>
		<li><a href="javascript:void(0)" onclick="show_admins()">Администратори</a>
			<ul id="ul_admins">
				<li><a href="javascript:void(0)" onclick="load_admins()">Администратори</a></li>
				<li><a href="javascript:void(0)" onclick="load_admin_attempts()">Опити за вход</a></li>
				<li><a href="javascript:void(0)" onclick="create_admin()">Създай администратор</a></li>
			</ul>
		</li>
		<li><a href="javascript:void(0)" onclick="show_tables()">БД Таблици</a>
			<ul id="ul_dbs">
				<?php 
				foreach($res as $row) { ?>
					<li><a href="javascript:void(0)" onclick="load_table('<?php echo $row;?>')"><?php echo $row;?></a></li>
				<?php } ?>
			</ul>
		</li>
		<li><a href="javascript:void(0)" onclick="load_bugs()">Бъгове</a>
		<li><a href="javascript:void(0)" onclick="load_areas()">Генериране на площи</a>
		<li><a href="javascript:void(0)" onclick="load_users()">Потребители</a>
		<li><a href="javascript:void(0)" onclick="load_visits()">Посещения</a>
		<li><a href="javascript:void(0)" onclick="load_destroy()">Разрушаване на сграда</a></li>
		<li><a href="<?php echo base_url(); ?>admin/add_category_buildng">Добави категория</a></li>
	</ul>
</div>
<!-- END OF ADMIN LEFT MENU LINKS -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/home.js"></script>