<h1>Поступил новый заказ</h1>
<p>
	<b>ФИО:</b> <?= $fio; ?>
</p>
<p>
	<b>Телефон:</b> <?= $phone; ?>
</p>
<p>
	<b>Адрес:</b> <?= $address; ?>
</p>
<p>
	<b>Дата доставки:</b> <?= $date_delivery; ?>
</p>

<? if($comment){ ?>
	<p>
		<b>Комментарий:</b> <?= $comment; ?>
	</p>
<? } ?>

<p>
	<b>Оплата:</b>
	<?
		switch($pay_variant){ 
			case '1': echo 'Оплата наличными'; break;
			case '2': echo 'Оплата безналичным расчётом'; break;
			case '3': echo 'Оплата банковской картой'; break;
		} 
	?>
</p>
	
<? if($pay){ ?>
	<p>
		<b>Реквизиты:</b>
	</p>
	<?= $pay; ?>
<? } ?>


<p><b>Товары:</b></p>
<?= $table_generated; ?>

<p>
	<b>Общая стоимость:</b>
	<?= $price_all; ?> руб.
</p>