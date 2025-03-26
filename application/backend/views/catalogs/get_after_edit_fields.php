<? if(isset($settings['is_variants']['value'])&&$settings['is_variants']['value']){ ?>
	<style>
		.small input[type="text"]{
			width:98%;
		}
	</style>
	<br/>
	<h2>Варианты</h2>
	<table class="item_table">
		<tr>
			<th>Наименование</th>
			<th>Цена</th>
			<th>Кол-во</th>
			<th>Порядок</th>
			<th>Показ</th>
			<th>Действия</th>
		</tr>
	<? 
		foreach($subitems as $subitem){ 
	?>
		<tr>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][name]",$subitem['name']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][price]",$subitem['price']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][count]",$subitem['count']); ?></td>
			<td class="small"><?= form_input("subitems[{$subitem['id']}][order]",$subitem['order']); ?></td>
			<td class="small" style="text-align:center;"><?= form_checkbox("subitems[{$subitem['id']}][is_show]","",$subitem['is_show']); ?></td>
			<td style="text-align:center;">
				<a href="<?= site_url("catalogs/edit_subitem/{$subitem['id']}"); ?>">Редактировать</a><br>
				<a href="<?= site_url("catalogs/delete_subitem/{$subitem['id']}"); ?>" onclick='return confirm("Вы уверены?")'>Удалить</a>
			</td>
		</tr>
	<? } ?>
	</table>
	<p>
		<a href="<?= site_url("catalogs/add_subitem/{$item_id}"); ?>"><b>Добавить вариант товара</b></a>
	</p>
	<br/>
<? } ?>

<? if(isset($settings['is_extra']['value'])&&$settings['is_extra']['value']){ ?>
	<? if(isset($categories_new_set)){ ?>
		<br/>
		<h2>Дополнительные категории</h2>
		<? foreach($categories_set as $category){ ?>
			<p>
				<a href="<?= site_url("catalogs/edit_group/{$category['id']}"); ?>"><?= $category['name'] ?></a> - 
				<a href="<?= site_url("catalogs/delete_from_group/{$category['id']}/$item_id"); ?>">Удалить</a>
			</p>
		<? } ?>
		<p>
			<b>Добавить</b>
			<?= form_dropdown("add_catalog_group", $categories_new_set, 0, "id='add_catalog_group'"); ?>
		</p>
		<br/>
	<? } ?>
<? } ?>

<? 
	if(count($types_set)){ 
?>
		<br/>
		<h2>Параметры товара</h2>
<?
		foreach($types_set[0]['groups'] as $group_id=>$group){
?>
			<h3><?= $group['name']; ?></h3>
			<? 
				if(count($group['attributes'])){ 
					foreach($group['attributes'] as $attr_id=>$tr){
						if(count($tr)){
			?>
							<h4><?= $tr['name']; ?></h4>
							<? 
								if(count($tr['values'])){
									foreach($tr['values']['content'] as $value){
							?>
										<div class="attr">
											<?= $value['value']; ?>
											<? if(count($tr['values']['content'])>1){ ?><?= $value['name']; ?><? } ?>
										</div>
							<?
									}
								}
							?>
							<div class="clear"></div>
							<br/>
			<?
						}
					}
				}
			?>
			<br/>
<?  
		}
	}
?>

<? 
	if(!empty($products_types)){ 
?>
		<br/>
		<h2>Вид продукта</h2>
		<p>
		<? foreach($products_types as $type_id=>$name){ ?>
			<label style='width:100%;'><input type='checkbox' name='products_types[]' value='<?= $type_id ?>' <? if(isset($active_products_types[$type_id])) echo 'checked'; ?>> <?= $name ?></label><br>
		<? } ?>
		</p>
<?
	}
?>