<!-- IS TEST PASSED -->
<div class="is_test_passed">
	<!-- IF IT IS PASSED -->
	<?php if($is_passed == 'test_passed') { ?>
	<div class="test_passed">
		<div class="big_green_tick">&nbsp;</div>
		<div class="test_passed_info">
			<span class="test_passed_text">Успешно взет тест</span><br/>
			<span class="test_passed_result">Верни <?php echo $result; ?>/3</span>
		</div>
	</div>
	<!-- END OF IF IT IS PASSED -->
	<?php } else { ?> 
	<!-- IF IT IS PASSED -->
	<div class="test_passed">
		<div class="big_red_tick">&nbsp;</div>
		<div class="test_passed_info">
			<span class="test_passed_text">Неуспешен тест</span><br/>
			<span class="test_passed_result">Верни <?php echo $result; ?>/3</span>
		</div>
	</div>
	<?php } ?>
</div>