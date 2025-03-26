<? foreach($tags as $types_id=>$types_data){ ?>
	<div class='types-block'>
		<div class="form-group row">
			<label class="col-sm-2 control-label">Характеристика</label>
			<div class="col-sm-10">
				<select name="types_id[<?= $types_id; ?>]" class="form-control types_id_select" data-index='<?= $types_id; ?>'>
					<? foreach($types as $type_id=>$type_name){ ?>
						<option value='<?= $type_id; ?>' <? if($type_id==$types_id) echo 'selected' ?>><?= $type_name; ?></option>
					<? } ?>
				</select>
			</div>
		</div>
		<? foreach($types_data['types_values'] as $item_one){ ?>
			<div class="form-group row types_value_select">
				<label class="col-sm-2 control-label">Значение хар-ки</label>
				<div class="col-sm-10">
					<select name="types_value[<?= $types_id; ?>][]" class="form-control">
						<option value='-1'>Не выбрано</option>
						<? foreach($types_data['types'] as $item_one2){ ?>
							<option value='<?= $item_one2['value']; ?>' <? if($item_one2['value']==$item_one) echo 'selected' ?>><?= $item_one2['value']; ?></option>
						<? } ?>
					</select>
				</div>
			</div>
		<? } ?>
		<p><a href='#' class='add-types_value'>Добавить значение</a></p><br>
	</div>	
<? } ?>

<? if($action=='edit'){ ?>
	<p><a href='#' class='add-types_id'>Добавить характеристику</a></p>	
<? } ?>

<script>
	$(document).ready(function(){
		var index=0;
		$(document).on('click','.add-types_id',function(){
			var html=
			"<div class='types-block'>"+
				"<div class='form-group row'>"+
					"<label class='col-sm-2 control-label'>Характеристика</label>"+
					"<div class='col-sm-10'>"+
						"<select name='new_types_id["+index+"]' class='form-control data-new types_id_select' data-index='"+index+"' >"+
							<? foreach($types as $type_id=>$type_name){ ?>"<option value='<?= $type_id; ?>'><?= $type_name; ?></option>"+<? } ?>
						"</select>"+
					"</div>"+
				"</div>"+
				"<div class='form-group row types_value_select d-none'>"+
					"<label class='col-sm-2 control-label'>Значение хар-ки</label>"+
					"<div class='col-sm-10'></div>"+
				"</div>"+
				"<p><a href='#' class='add-types_value'>Добавить значение</a></p>"+				
			"</div>";
			++index;
			$(html).insertBefore($(this).parent());
			return false;
		});
		
		$(document).on('click','.add-types_value',function(){
			var html="";
			if($(this).closest('.types-block').find('.types_value_select select').length){
				html="<div class='form-group row types_value_select'>"+
					"<label class='col-sm-2 control-label'>Значение хар-ки</label>"+
					"<div class='col-sm-10'>"+$(this).closest('.types-block').find('.types_value_select .col-sm-10').html()+"</div>"+
				"</div>";
				$(html).insertBefore($(this).parent());
			}		
			
			
			return false;
		});
		
		$(document).on('change','.types_id_select', function(){
			var $block=$(this).closest('.types-block');
			var dindex=$(this).attr('data-index');
			var is_new=$(this).hasClass('data-new');
			$.ajax({
				url: "/admin/catalogs_group/get_types_list",
				type:   'POST',
				data: {
					id: $(this).val()
				},
				success: function(result){
					var obj = JSON.parse(result);
					var cclass=is_new?"new_types_value":"types_value";
					var str="<select name='"+cclass+"["+dindex+"][]' id=field_types_value class=form-control><option value='-1'>---</option>";

					for (var key in obj) {
						str+="<option value='"+key+"'>"+obj[key]+"</option>";
					}
					str+="</select>";
					
					$block.find('.types_value_select').removeClass('d-none');
					$block.find('.types_value_select .col-sm-10').html(str);					
				}
			});
		});
	});
</script>
	



<?if ($settings){?>
	<style>
		.small input[type="text"]{
			width:98%;
		}
	</style>
	<br/>
	<h2>Страницы тегирования</h2>
	<table class="item_table">
		<tr>
			<th>Наименование</th>
			<th>h1</th>
			<th>meta-title</th>
			<th>meta-description</th>
			<th>meta-keywords</th>
			<th>Порядок</th>
			<th>Показ тега</th>
			<th>Популярный</th>
			<th>Действия</th>
		</tr>
	<? 
		foreach($subitems as $subitem){ 
	?>
		<tr>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][name]",$subitem['name']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][h1]",$subitem['h1']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][meta_title]",$subitem['meta_title']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][meta_description]",$subitem['meta_description']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][meta_keywords]",$subitem['meta_keywords']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][order]",$subitem['order']); ?></td>
			<td class="small" style="text-align:center;"><?= form_checkbox("subitems[{$subitem['id']}][is_show_tag]","",$subitem['is_show_tag']); ?></td>
			<td class="small" style="text-align:center;"><?= form_checkbox("subitems[{$subitem['id']}][is_popular_tag]","",$subitem['is_popular_tag']); ?></td>
			<td style="text-align:center;">
				<a href="<?= site_url("catalogs_group/edit_subgroup/{$subitem['id']}"); ?>">Редактировать</a><br>
				<a href="<?= site_url("catalogs_group/delete_subgroup/{$subitem['id']}"); ?>" onclick='return confirm("Вы уверены?")'>Удалить</a>
			</td>
		</tr>
	<? } ?>
	</table>
	<p>
		<a href="<?= site_url("catalogs_group/add_subgroup/{$item_id}"); ?>"><b>Добавить страницу тегирования</b></a>
	</p>
<?}?>

<script>
/*$(document).ready(function(){
	var attr=$('#field_types_id');
	var vals=$('#field_types_value').parent('.col-xs-10');
	var label1=$('#field_types_value').closest('.form-group').find('label');
	var vals2=$('#field_types_value2').closest('.form-group');
	var values=$('#field_types_value').val();
	var values2=$('#field_types_value2').val();

	attr.change(function(){
		$.ajax({
			url: "/admin/catalogs_group/get_types_list",
			type:   'POST',
			data: {id: $(this).val()},
			success: function(result){
				var obj = JSON.parse(result);
				var sel;
				var str="<select name=types_value id=field_types_value class=form-control><option value='-1'>---</option>";
				label1.html('Значение характеристики');
				vals2.hide();
				$('#field_types_value2').val('');
				for (var key in obj) {
					sel=''
					if (key==values){
						sel=' selected'
					}
					str+="<option value='"+key+"'"+sel+">"+obj[key]+"</option>";
				}
				str+="</select>";
				$('#field_types_value').parent().html(str);
				
			}
		});

	});
	attr.change();
});*/
</script>