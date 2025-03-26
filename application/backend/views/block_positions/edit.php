<h2><?= $title; ?></h2>
<script>
	$(document).ready(function() {
		function set_method(set_callback){
			model=$('#field_model option:selected').val();
			method=$('#field_method option:selected').val();
			
			$.post("<?= site_url("block_positions/ajax/"); ?>", {
				model: model,
				method: method,
			},
			function (result) {
				obj = JSON.parse(result);
				if(obj.methods){
					$("#field_method").empty();
					$("#field_method").append(obj.methods);
					
					if(!set_callback){
						$("#field_method").val(0);
					}
					else{
						$("#field_method").val("<?= $item['method']; ?>");
						set_parametrs();
					}
					
					$("#parametrs").empty();
				}
			});
		}
		
		function set_parametrs(){
			model=$('#field_model option:selected').val();
			method=$('#field_method option:selected').val();
			
			$.post("<?= site_url("block_positions/ajax/"); ?>", {
				model: model,
				method: method,
				item_id: <?= $item['id']; ?>
			},
			function (result) {
				obj = JSON.parse(result);
				if(obj.parametrs){
					$("#parametrs").empty();
					$("#parametrs").append(obj.parametrs);
				}
			});
		}
	
		$('#field_model').change(function() {
			set_method(false);
		});
		$('#field_method').change(function() {
			set_parametrs();
		});
		
		$('#form_add').submit(function() {
			model=$('#field_model option:selected').val();
			method=$('#field_method option:selected').val();
			if(!model||!method){
				$('#error').html('Не выбран модуль');
				return false;
			}
			return true;
		});
		
		set_method(true);
	});
</script>

<? if(count($refs)){ ?>
	<p>
		<? foreach($refs as $url=>$ref_name){ ?>
			<a href="<?= $url; ?>"><?= $ref_name; ?></a> / 
		<? } ?>
	</p>
<? } ?>

<form action="<?= site_url("/$controller/{$action}_do"); ?>" method="post" accept-charset="utf-8" id="form_add" class='form-horizontal' enctype="multipart/form-data" >
	<?
		if(count($fields)){
			foreach($fields as $name=>$field){
	?>
				<div class="form-group row">
					<label class="col-sm-2 control-label"><?= $name; ?></label>
					<div class="col-sm-10">
						<?= $field; ?>
					</div>
				</div>
	<?
			}
		}
	?>
	<div id="parametrs">
		<?= $after_content; ?>
	</div>
	<p class='add_action'>
		<input type='hidden' value='<?= $pid; ?>' name='item_id' id='item_id'>
		<?= form_submit(array('name'=>'submit','id'=>'submit'), 'Внести'); ?>
		&nbsp;
		<?= form_submit(array('name'=>'save','id'=>'save'), 'Сохранить'); ?>
		&nbsp;		
		<?= form_button('mybutton', 'Закрыть', "onclick=\"javascript:location.href=history.go(-1);\""); ?>
	</p>
</form>

<p id='error'></p>