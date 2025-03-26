<br>
<h2>Товары заказа</h2>

<!--p>
	<label>Добавить по артикулу</label>
	<?= form_input(array(
		'name' => "new_item",
		'style' => "width:200px;",
	)); ?>
</p--> 
<br>
<table class="item_table" id="variants">
	<tr>
		<th>Наименование</th>
		<th>Цена</th>
		<th>Кол-во</th>
		<th>Сумма, руб.</th>
		<th>Удалить</th>
	</tr>
	<? 
		$summa=0;
		foreach($items as $item_one){ 
			$summa+=$item_one['count']*$item_one['price'];
	?>
		<tr>
			<td><a href="<?=  site_url("catalogs/{$item_one['item']['url_part']}/{$item_one['catalogs_id']}"); ?>"><?= $item_one['item']['name']; ?></a></td>
			<td class="small" style="text-align:center;">
				<?= form_input(array(
					'name' => "prices[{$item_one['id']}]",
					'value' => $item_one['price'],
					'style' => "width:100px;",
				)); ?>
			</td>
			<td class="small" style="text-align:center;">
				<?= form_input(array(
					'name' => "counts[{$item_one['id']}]",
					'value' => $item_one['count'],
					'style' => "width:100px;",
				)); ?>
			</td>
			<td class="small" style="text-align:center;"><?= $item_one['count']*$item_one['price']; ?> руб.</td>
			<td class="small" style="text-align:center;"><a href='<?= site_url("/orders/delete/{$item_one['id']}/1"); ?>' onclick="return confirm('Вы уверены?')">Удалить</a></td>
		</tr>
	<? } ?>
	<tr>
		<td colspan="4" style="text-align:right;">
			Итого:
		</td>
		<td style="text-align:center;">
			<?= $summa; ?> руб.
		</td>
	</tr>
</table>
<br>

<script>
	$(document).ready(function() {	
		$(document).on('click', ".deleteme", function(e) {
			if(confirm('Вы уверены?')){
				$(this).parent().parent().remove();
			}
			return false;
		});
	});
</script>
