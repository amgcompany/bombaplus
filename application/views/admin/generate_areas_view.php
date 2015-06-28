<!-- GENERETE AREAS VIEW -->
<div class="bugs_view">
	<h3>Генериране на площи/имоти</h3>
	<span>Генерира площи/имоти кв.м./дка. в град и зона, която сте избрали</span>
	<br/><br/><br/>
	<!-- SHOWS ALL ADMINS -->
	<div class="show_bugs">
		<table>
			<tr><td><b>Изберете град:</b></td></tr>
			<tr><td>
				<select id="admin_select_city">
					<option value="0">----
					<option value="1">София
				</select>
			</td></tr>
			<tr><td><b>Изберете зона:</b></td></tr>
			<tr><td>
				<select id="admin_select_zone">
					<option value="0">----
					<option value="1">Център
					<option value="2">Жилищен квартал
					<option value="3">Индустриална зона
				</select>
			</td></tr>
			<tr><td><b>Колко кв.м. да бъдат площите</b></td></tr>
			<tr><td><input type="text" id="areas_space" onkeypress='validate(event)' /></td></tr>
			<tr><td><b>Колко на брой площи искате да генерирате</b></td></tr>
			<tr><td><input type="text" id="areas_to_generate" maxlength="2" onkeypress='validate(event)' /></td></tr>
			<tr><td><input type="button" onclick="generete_area()" value="Генерирай!!!" /></td></tr>
		</table>
	</div>
</div>
<!-- END OF GENERETE AREAS VIEW -->