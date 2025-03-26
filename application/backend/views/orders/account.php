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
	table td,table th{
		padding:5px;
		border:1px solid #000;
	}
	table.noborder td,table .noborder td{
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
	<p class='text-center fs12'>
	Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате 
	обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту
	прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.</p>
	<br>
	<table>
		<tr>
			<td colspan='3' class='bb0'>________________________________</td>
			<td>БИК</td>
			<td>_____________</td>
		</tr>
		<tr>
			<td class='fs12' colspan='3'>Банк получателя</td>
			<td>к/с №</td>
			<td>________________________________</td>
		</tr>
		<tr>
			<td>ИНН</td>
			<td>667219745523</td>
			<td>КПП</td>
			<td rowspan='3'>р/с №</td>
			<td rowspan='3'>________________________________</td>
		</tr>
		<tr>
			<td colspan='3' class='bb0'>________________________________</td>
		</tr>
		<tr>
			<td class='fs12' colspan='3'>Получатель</td>
		</tr>
	</table>
	<br>
	<?
		$months=array(
			'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря',
		);
	?>
	<h2>Счет на оплату №<?= $item['id']; ?> от <?= date("d"); ?> <?= $months[(int)date("m")-1] ?> <?= date("Y"); ?> г.</h2>
	<hr>
	<table class='noborder'>
		<tr>
			<td>Поставщик:</td>
			<td><b>____________________________________________________________________________________</b></td>
		</tr>
		<tr>
			<td>Покупатель:</td>
			<td><?= $item['name']; ?>, г. <?= $item['city']; ?>, ул. <?= $item['street']; ?>, д. <?= $item['house']; ?>, кв. <?= $item['flat']; ?>, тел. <?= $item['phone']; ?></td>
		</tr>
	</table>
	<br>
	
	<table>
		<tr>
			<th>№</th>
			<th>Товар</th>
			<th>Кол-во</th>
			<th>Ед.</th>
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
					<td align='right'><?= $item_one['count']; ?></td>
					<td>шт</td>
					<td align='right'><?= number_format($item_one['price'],2,",",' '); ?></td>
					<td align='right'><?= number_format($item_one['count']*$item_one['price'],2,",",' '); ?></td>
				</tr>	
		<?
			}
		?>
		<tr class='noborder'>
			<td align='right' colspan='5'><b>Итого:</b></td>
			<td align='right'><b><?= number_format($summa,2,",",' '); ?></b></td>
		</tr>
		<tr class='noborder'>
			<td align='right' colspan='5'><b>Без налога (НДС):</b></td>
			<td align='right'><b>-</b></td>
		</tr>
	</table>
	
	<br>
	<p>Всего наименований <?= count($items); ?>, на сумму <?= number_format($summa,2,",",' '); ?> руб.</p>
	<p><b><?= mb_strtoupper(mb_substr($sum_prop, 0, 1)).mb_substr($sum_prop, 1); ?> рублей 00 копеек</b></p>
	
	<hr>
	<table class='noborder'>
		<tr>
			<td width=100>Руководитель</td>
			<td class='fs12 bb1' align='right'>Зобнин Г.С.</td>
			<td width=100>Бухгалтер</td>
			<td class='fs12 bb1' align='right'>Зобнин Г.С.</td>
		</tr>
	</table>
</div>