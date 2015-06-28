<!-- CONTACTS -->
<div id="contacts">
	<h3>Контакти</h3>
	<h4><a href="#">contact@bombaplus.com</a></h4>
	<form method="post" action="<?php echo base_url(); ?>contacts/sendemail">
		<table>
			<tr><td>Име и фамилия</td></tr>
			<tr><td><input type="text" name="namef" /></td></tr>
			<tr><td>Електронна поща</td></tr>
			<tr><td><input type="text" name="email" /></td></tr>
			<tr><td>Тема</td></tr>
			<tr><td><input type="text" name="subject" /></td></tr>
			<tr><td><textarea name="message"></textarea></td></tr>
			<tr><td><input type="submit" value="Изпрати" /></td></tr>
		</table>
	</form>
	<div class="email_error">
	<?php  echo validation_errors(); ?>
	</div>
</div>
<!-- END OF CONTACTS -->