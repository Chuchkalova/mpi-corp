<h1>Заказ №<?= $item['id']; ?></h1>
<?
	$fields=array(
		'name'=>'ФИО',
		'phone'=>'Телефон',
		'email'=>'Email',
		'city'=>'Город',
		'org'=>'Организация',
		'comment'=>'Комментарий',
	);
	
	foreach($fields as $field_id=>$field_name){
		if($item[$field_id]){
?>
			<p>
				<b><?= $field_name; ?>:</b> <?= $item[$field_id]; ?>
			</p>
<?
		}
	}
?>
<br>
<p><b>Товары заказа:</b></p>
<table cellpadding='5' border='1' cellspacing=0>
	<tr>
		<th>Наименование</th>
		<th>Цена</th>
		<th>Кол-во</th>
		<th>Сумма</th>
	</tr>
	<? foreach($items as $item_one){ ?>
		<tr>
			<td>
				<?= $item_one['name']; ?>
			</td>
			<td class='price fs16'>
				<span class='s1'><?= $item_one['price']; ?></span>&nbsp;<span>р.</span>
			</td>
			<td class='count'>
				<?= $item_one['qty']; ?>
			</td>
			<td class='summa fs16'>
				<span class='s1'><?= $item_one['price']*$item_one['qty']; ?></span>&nbsp;<span>р.</span>
			</td>
		</tr>
	<? } ?>
</table>

<p>
	<b>Общая стоимость:</b> <?= $this->cart->total(); ?> р.
</p>