<h2>Выгрузить XLSX с товарами</h2>
<form action="<?= site_url("catalogs/csv_do/$pid"); ?>" method="post" accept-charset="utf-8" id="send_filter_tr" enctype="multipart/form-data">
	<p>
		<label>Файл</label>
		<?= form_upload(array(
			   'name'        => "file",
			   'maxlength'   => '100'
			));
		?>
	</p>
	<br>
	<p class='add_action'>
		<?= form_submit(array('name'=>'save','id'=>'save'), 'Отправить'); ?>
		&nbsp;		
		<?= form_button('mybutton', 'Закрыть', "onclick=\"javascript:location.href='{$_SERVER['HTTP_REFERER']}'\""); ?>
	</p>
</form>