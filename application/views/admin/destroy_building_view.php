<!-- DESTROYING BUILDING -->
	<h3>Разрушаване на сгради</h3>
	<table>
		<tr><td>Изберете типа сграда</td></tr>
		<tr><td>
			<select id="destroy_type">
				<option value="0">----</option>
				<option value="1">Блок</option>
				<option value="2">Ресторант</option>
				<option value="3">Казино</option>
				<option value="4">Кравеферма</option>
				<option value="5">Производство на домати</option>
			</select>
		</td></tr>
		<tr><td>Напишете ID на имота</td></tr>
		<tr><td><input type="text" id="destroy_property_id" maxlength="2" /></td></tr>
		<tr><td><input type="button" onclick="destroy_building()" value="Разруши" /></td></tr>
	</table>