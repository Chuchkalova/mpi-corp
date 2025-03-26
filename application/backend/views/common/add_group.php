<h2><?= $title; ?></h2>

<? if(count($refs)){ ?>
	<p>
		<? foreach($refs as $url=>$ref_name){ ?>
			<a href="<?= $url; ?>"><?= $ref_name; ?></a> / 
		<? } ?>
	</p>
<? } ?>

<form action="<?= site_url("/$controller/{$action}_do"); ?>" method="post" accept-charset="utf-8" class='form-horizontal' id="form_add" enctype="multipart/form-data">
	<?
		if(count($fields)){
			foreach($fields as $name=>$field){
				if(strpos($field,'CKEDITOR')===false){
	?>
					<div class="form-group row">
						<label class="col-sm-2 control-label"><?= $name; ?></label>
						<div class="col-sm-10">
							<?= $field; ?>
						</div>
					</div>
	<?
				}
				else{
	?>
					<div class="form-group row">
						<label class="col-sm-12 control-label"><?= $name; ?></label>
						<div class="col-sm-12">
							<?= $field; ?>
						</div>
					</div>
	<?
				}
			}
		}
	?>
	
	<?= $after_content; ?>
	<p class='add_action'>
		<?= form_submit(array('name'=>'submit','id'=>'submit'), 'Внести'); ?>
		&nbsp;
		<?= form_submit(array('name'=>'save','id'=>'save'), 'Сохранить'); ?>
		&nbsp;		
		<?= form_button('mybutton', 'Закрыть', "onclick=\"javascript:location.href=history.go(-1);\""); ?>
	</p>
</form>

<p id='error'></p>