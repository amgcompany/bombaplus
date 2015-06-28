<div class="question">
	<?php echo $row[0]['question']; ?>
</div>
<div class="answers">
	<?php
	$answ_let = array();
	$answ_let[0] = "A";
	$answ_let[1] = "B";
	$answ_let[2] = "C";
	$answ_let[3] = "D";
	for($i=1;$i<=4;$i++) {
	?>
		<div class="answer">
		<input type="button" class="answer_button" onclick="check_question(<?php echo $row[$i]['correct']; ?>, <?php echo $row[0]['question_level'];?>)" value="<?php echo $answ_let[$i-1]; ?>">
		<div class="full_answer"><?php echo $row[$i]['answer']; ?></div>
		</div>
	<?php
	}
	?>
</div>
<div class="level_question">
Ниво въпрос: <?php echo $row[0]['question_level'];?>
</div>