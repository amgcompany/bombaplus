<!-- SHOWS TABLE -->
<div id="admin_table">
	<table border="1" style="width:90%">
		<tr><h3>Полета</h3></tr>
		<tr><h3><?php echo $table; ?></h3></tr>
		<?php foreach($columns as $column) { ?>
			<tr><td><b><?php echo $column; ?></b></td></tr>
		<?php } ?>
	</table>
</div>