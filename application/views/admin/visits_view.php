<h4>Уникални посещения днес <?php echo date('d.m.Y'); ?></h4>
<?php if($res['home_visits']>=1) { ?>
	Начална станица: <b><?php echo $res['home_visits']; ?></b> уникални
<?php } else { ?>
	Начална станица: 0 уникални
<?php } ?>
<br/><br/>
<?php if($res['main_visits'] >= 1) { ?>
	Главна станица: <b><?php echo $res['main_visits']; ?></b> уникални
<?php } else { ?>
	Главна станица: 0 уникални
<?php } ?>