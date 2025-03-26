<h2><?= $title; ?></h2>
<script>
	$(document).ready(function() {
		function set_element_id(reset_is_module_top){
			module_id=$('#field_module_id option:selected').val();
			if(!reset_is_module_top){
				is_module_top=$('#field_is_module_top option:selected').val();
			}
			else{
				is_module_top=0;
			}
			url_this=$('#field_url_this option:selected').val();
			
			$.post("<?= site_url("menus/ajax/"); ?>", {
				module_id: module_id,
				is_module_top: is_module_top,
				item_id:0,
				type:'menus',
				url_this:url_this,
			},
			function (result) {
				obj = JSON.parse(result);
				if(obj.elements){
					$("#field_element_id").empty();
					$("#field_element_id").append(obj.elements);
				}
				if(obj.special){
					$("#field_url_this").empty();
					$("#field_url_this").append(obj.special);
				}
				if(obj.is_module_top){
					$("#field_is_module_top").empty();
					$("#field_is_module_top").append(obj.is_module_top);
				}
			});
		}
	
		$('#field_url_this').change(function() {
			url_this=$('#field_url_this option:selected').val();
			if(url_this!=-1){
				$("#field_element_id").val(-1).prop('selected',true);
			}
		});
		$('#field_element_id').change(function() {
			url_this=$('#field_element_id option:selected').val();
			if(url_this!=-1){
				$("#field_url_this").val(-1).prop('selected',true);
			}
		});
	
		$('#field_module_id').change(function() {
			set_element_id(true);
		});
		$('#field_is_module_top').change(function() {
			set_element_id(false);
		});
		
		$('#form_add').submit(function() {
			if($('#field_name').val()==''){
				$('#error').html('Не заполнено поле Наименование');
				return false;
			}
			url_this=$('#field_url_this option:selected').val();
			element_id=$('#field_element_id option:selected').val();
			if(url_this==-1&&element_id==-1){
				$('#error').html('Не выбрана ни специальная, ни конкретная страница');
				return false;
			}
			return true;
		});
	});
</script>

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