<h2><?= $title; ?></h2>

<? if(count($refs)){ ?>
	<p>
		<? foreach($refs as $url=>$ref_name){ ?>
			<a href="<?= $url; ?>"><?= $ref_name; ?></a> / 
		<? } ?>
	</p>
<? } ?>

<form action="<?= site_url("/$controller/{$action}_do"); ?>" method="post" accept-charset="utf-8" id="form_add" class='form-horizontal' enctype="multipart/form-data">
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
		<a href='<?= site_url("educations/edit/$pid") ?>' class='btn-red'>Закрыть</a>
	</p>
</form>

<p id='error'></p>
<script>
	$(document).ready(function(){
		$('input[type=hidden]').closest('.form-group').hide();
	});
</script>