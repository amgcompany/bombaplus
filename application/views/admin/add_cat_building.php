<!-- ADDS BUILDING CATEGORY -->
<div id="add_build_cat">
	<form method="post" action="<?php echo base_url(); ?>admin/add_category_buildng/add">
		<table>
			<tr><td><h3>Добавяне на категория</h3></td></tr>
			<tr><td>
			<select name="cat_type">
				<option>----</option>
				<option value="1">Сграда</option>
				<option value="2">Земеделие</option>
				<option value="3">Животновъдство</option>
			</select></td></tr>
			<tr><td><input type="text" name="cat_build" /></td></tr>
			<tr><td><input type="submit" name="click" value="Добави категория" /></td></tr>
		</table> 
	</form>
	<span><?php echo validation_errors(); ?></span>
</div>
<!-- ADDS BUILDING CATEGORY -->