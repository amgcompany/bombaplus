<!-- ADMIN LOGIN -->
<div id="admin_login">
	<form method="post" action="<?php echo base_url(); ?>admin/login/sigin">
		<table>
			<tr><td>Потребителско име</td></tr>
			<tr><td><input type="text" name="username" value="<?php echo $this->input->post('username');?>"/></td></tr>
			<tr><td>Електронна поща</td></tr>
			<tr><td><input type="text" name="email" value="<?php echo $this->input->post('email');?>" /></td></tr>
			<tr><td>Парола</td></tr>
			<tr><td><input type="password" name="password" /></td></tr>
			<tr><td><input type="submit" value="Вход като администратор" name="click" /></td></tr>
		</table>
	</form>
	<span><?php echo validation_errors(); ?></span>
</div>
<!-- END OF ADMIN LOGIN -->