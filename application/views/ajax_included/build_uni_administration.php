<!-- UNIVERSITY ADMINISTRATION -->
<div class="uni_administrations">
	<div class="uni_admin_cats_title"><b>Специалности/Категории</b></div>
	<!-- SHOWS THE UNI'S SPECIALTIES -->
	<div class="all_uni_cats">
		<table border="1">
			<tr>
				<td>Специалност</td>
				<td>Цена за вход</td>
			</tr>
		<?php 
			if($row['categories']!='0') { 
			foreach($row['categories'] AS $spec) { ?> 
			<tr>
				<td><?php echo $spec['u_specialty_title']; ?></td>
				<td><?php echo $spec['u_specialty_enter_prize']; ?></td>
			<tr>
		<?php
			}
			} else {
				echo "Все още няма добавени специалности";
			}?>
		</table>
	</div>
	<!-- END OF UNI'S SPECIALTIES -->
	<!-- ADDING UNI SPECIALTY -->
	<div class="add_uni_spec">
		<div class="uni_admin_cats_title"><b>Добавяне на Специалности/Категории</b></div>
		<table>
			<tr><td>Специалност</td><td><input type="text" id="add_uni_spec" /></td></tr>
			<tr><td>Цена за вход</td><td><input type="text" id="add_uni_enter_prize" onkeypress="validate(event);"  /></td></tr>
			<tr><td>&nbsp;</td><td><input type="button" onclick="add_uni_speacialty(<?php echo $area_id.', '.$uni_id; ?>)" value="Добави специалност"></td></tr>
		</table>
	</div>
	<!-- END OF ADDING NEW UNI SPECIALTY -->
	<!-- ADDING QUESTIONS -->
	<?php if($row['categories']!='0') { ?>
	<div class="add_uni_question">
		<div class="uni_admin_cats_title"><b>Добавяне на въпрос към специалност (за тест)</b></div>
		<table>
			<tr><td>Изберете към коя специалност ще спада въпроса</td></tr>
			<tr>
				<td>
					<select id="cat_id">
					<option value="0">---</option>
					<?php foreach($row['categories'] AS $spec) { ?>
						<option value="<?php echo $spec['uni_spec_id']; ?>"><?php echo $spec['u_specialty_title']; ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr><td>Въпрос</td></tr>
			<tr><td><textarea id="quest" cols="30" rows="5"></textarea></td></tr>
			<tr><td>Ниво въпрос (1-3)</td></tr>
			<tr><td><input type="text" id="level" maxlength="1" onkeypress="validate(event);"/></td></tr>
			<tr><td>Възможни отоговри</td></tr>
			<tr><td><input type="text" id="ans1"></td><td><input type="radio" id="r1" value="answer1"/>Верен</td></tr>
			<tr><td><input type="text" id="ans2"></td><td><input type="radio" id="r2" value="answer2"/>Верен</td></tr>
			<tr><td><input type="text" id="ans3"></td><td><input type="radio" id="r3" value="answer3"/>Верен</td></tr>
			<tr><td><input type="text" id="ans4"></td><td><input type="radio" id="r4" value="answer4"/>Верен</td></tr>
			<tr><td><input type="button" name="add" onclick="add_question(<?php echo $area_id.', '.$uni_id; ?>)" value="Добави въпрос"></td></tr>
		</table>
		<div id="add_quest_error">
		</div>
	</div>
	<?php } ?>
	<!-- END OF ADDING QUESTIONS -->
</div>
<!-- END OF UNI ADMINISTRATION -->