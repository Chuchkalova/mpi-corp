<h2><?= $data['name']; ?> - конфигурация (<a href='<?= site_url("configurator/init/$model"); ?>' target='_blank'>обновить</a>)</h2>
<form action="<?= site_url("/$controller/config_do"); ?>" method="post" accept-charset="utf-8" id="form_add" enctype="multipart/form-data" class='form-horizontal'>
	<h3>Названиe модуля</h3>
	<p>
		<?= form_input(array(
				'name'        => "name",
				'id'          => "name",
				"required"	  => "required",
				'maxlength'   => '100',
				'value'		  => $data['name'],
				'class'		  => 'form-control',
		)); ?>
	</p>
	
	<h3>Конфигурация полей</h3>
	<?
		foreach($data['fields'] as $name=>$field){
			if(!$field['is_always']){
	?>
			<div class='clearfix'>
				<label class="radio-inline">
					<?= form_checkbox("fields[{$name}]",'', $field['is_active']); ?>
					<?= $field['russian_name']; ?>
				</label>			
			</div>
	<?
			}
		}
	?>
	
	<? if(isset($data['settings'])&&count($data['settings'])){ ?>
		<h3>Конфигурация страниц</h3>
		<?
			foreach($data['settings'] as $block_name=>$data_one){
		?>
				<p><b><?= $data_one['name']; ?></b></p>
				<?
					foreach($data_one['data'] as $field_name=>$field_data){
				?>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?= $field_data['name']; ?></label>
							<div class="col-sm-10">
								<?
									if($field_data['type']=="checkbox"){
										echo form_checkbox("settings[{$block_name}][{$field_name}]", '', $field_data['value']);
									}
									else if($field_data['type']=="select"){
										echo form_dropdown("settings[{$block_name}][{$field_name}]", $field_data['values'], $field_data['value'], "class='form-control' ");
									}
									else{									
										echo form_input(array(
										   'name'        => "settings[{$block_name}][{$field_name}]",
										   'maxlength'   => '100',
										   'class'		 => 'form-control',
										   'value' 		 => $field_data['value'],
										));
									}
								?>
							</div>
						</div>
				<?
					}
				?>
		<? } ?>
	<? } ?>
	
	<h3>Права</h3>
	<div class='clearfix'>
		<label class="radio-inline">
			<?= form_checkbox("user_rools[access]",'', (isset($data['rools']['access'])&&$data['rools']['access'])); ?>
			Доступ
		</label>
	</div>
	<div class='clearfix'>
		<label class="radio-inline">
			<?= form_checkbox("user_rools[show]",'', (isset($data['rools']['show'])&&$data['rools']['show'])); ?>
			Показ
		</label>
	</div>
	<div class='clearfix'>
		<label class="radio-inline">
			<?= form_checkbox("user_rools[add]",'', (isset($data['rools']['add'])&&$data['rools']['add'])); ?>
			Добавление
		</label>
	</div>
	<div class='clearfix'>
		<label class="radio-inline">
			<?= form_checkbox("user_rools[edit]",'', (isset($data['rools']['edit'])&&$data['rools']['edit'])); ?>
			Редактирование
		</label>
	</div>
	<div class='clearfix'>
		<label class="radio-inline">
			<?= form_checkbox("user_rools[delete]",'', (isset($data['rools']['delete'])&&$data['rools']['delete'])); ?>
			Удаление
		</label>
	</div>
	
	<br>
	<p class='add_action'>
		<?= form_hidden('model', $model); ?>
		<?= form_submit(array('name'=>'save','id'=>'save'), 'Сохранить'); ?>
		&nbsp;		
		<?= form_button('mybutton', 'Закрыть', "onclick=\"javascript:location.href=history.go(-1);\""); ?>
	</p>
</form>
<br/>