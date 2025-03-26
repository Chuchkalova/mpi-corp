<h2>Конфигуратор</h2>
<h3>Модули</h3>
<?
	foreach($active as $module=>$active){
?>
		<p>
			<label><?= $module; ?></label>
			<? if($active==2){ ?>
				(Установлено)
			<? }else if($active==1){ ?>
				(<a href="<?= site_url("configurator/install/$module"); ?>">Инсталлировать</a>)
			<? }else{ ?>
				(<a href="<?= site_url("configurator/load/$module"); ?>">Загрузить</a>)
			<? } ?>
		</p>
<?
	}
?>
<br>
<h3>Шаблоны</h3>
<?
	foreach($active_templates as $template=>$active){
?>
		<? if($active==0){ ?>
			<p><?= $template; ?> (<a href="<?= site_url("configurator/load_template/$template"); ?>">Загрузить</a>)</p>
		<? }else{ ?>
			<p><?= $template; ?> (<a href="<?= site_url("configurator/install_template/$template"); ?>">Конфигурировать</a>)</p>
		<? } ?>
<?
	}
?>

<br>
<h3>Позиционирование блоков</h3>
<p><a href="<?= site_url("block_positions/"); ?>" class='btn btn-danger'>Редактировать</a></p>