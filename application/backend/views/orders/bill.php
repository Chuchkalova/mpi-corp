<style>
	.account{
		width:1000px;
		margin:0 auto;
	}
	.text-center{
		text-align:center;
	}
	.fs12{
		font-size:13px;
	}
	.fs15{
		font-size:15px;
	}
	table td,table th{
		vertical-align:top;
		padding:5px;
		border:1px solid #000;
	}
	table.noborder td,table .noborder td,table td.noborder{
		border:1px solid #fff;
	}
	table td.bb0{
		border-bottom:1px solid #fff;
	}
	table.noborder td.bb1{
		border-bottom:1px solid #000;
	}
	table {
		border-collapse: collapse;
		width:100%;
	}
</style>
<div class='account'>
	<p class='fs15'><b><i>________________________________</i></b></p>
	<p class='fs15'><b><i>________________________________</i></b></p>
	<br>
	<?
		$months=array(
			'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря',
		);
	?>
	<h2>Товарный чек №<?= $item['id']; ?> от <?= date("d"); ?> <?= $months[(int)date("m")-1] ?> <?= date("Y"); ?> г.</h2>
	<hr>
	<p>
		Поставщик: <b>________________________________</b><br>
		Адрес: ________________________________________________________________
	</p>
	<p>
		Покупатель: <b><?= $item['name']; ?>, <?= $item['phone']; ?></b><br>
		Адрес: <b>г. <?= $item['city']; ?>, ул. <?= $item['street']; ?>, д. <?= $item['house']; ?>, кв. <?= $item['flat']; ?></b>
	</p>
	<br>
	
	<table>
		<tr>
			<th>№</th>
			<th>Товар</th>
			<th>Кол-во</th>
			<th>Цена</th>
			<th>Сумма</th>
		</tr>
		<?
			$i=0;
			$summa=0;
			foreach($items as $item_one){
				++$i;
				$summa+=$item_one['count']*$item_one['price'];
		?>
				<tr>
					<td align='center'><?= $i; ?></td>
					<td><?= $item_one['item']['name']; ?></td>
					<td align='center'><?= $item_one['count']; ?></td>
					<td><?= number_format($item_one['price'],2,",",' '); ?></td>
					<td><?= number_format($item_one['count']*$item_one['price'],2,",",' '); ?></td>
				</tr>	
		<?
			}
		?>
		<tr>
			<td align='right' colspan='2' class='noborder'>&nbsp;</td>
			<td align='right' style='border-bottom:1px solid #fff;'>&nbsp;</td>
			<td align='right'><b>Итого:</b></td>
			<td><b><?= number_format($summa,2,",",' '); ?></b></td>
		</tr>
	</table>
	
	<br>
	<p>Всего наименований <?= count($items); ?>, на сумму</p>
	<p><b><?= mb_strtoupper(mb_substr($sum_prop, 0, 1)).mb_substr($sum_prop, 1); ?> рублей 00 копеек</b></p>
	
	<br>
	<table class='noborder'>
		<tr>
			<td width=100>Отпустил</td>
			<td class='fs12 bb1' align='right'>&nbsp;</td>
			<td width=100>Получил</td>
			<td class='fs12 bb1' align='right'>&nbsp;</td>
		</tr>
	</table>
</div>