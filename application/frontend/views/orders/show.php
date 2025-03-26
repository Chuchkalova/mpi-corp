<div class='clearfix breads fs14 mt20 mb50'>
	<div class='pull-left home' style='z-index:4;'><a href='<?= site_url('/'); ?>'><img src='/site_img/home.png'></a></div>
	<div class='pull-left' style='z-index:1;'><span>Корзина</span></div>
</div>

<h1 class='fs36 pb20'>Товары в корзине</h1>

<div class='scroll'>
	<table class='table cart-table'>
		<? foreach($items as $item_one){ ?>
			<tr>
				<td class='hidden-xs'>
					<? if(!$item_one['is_matras']){ ?>
						<a href='<?= site_url("content/{$item_one['url']}") ?>'><img src='<?= get_image("catalog","file",$item_one['id']); ?>' class='img-responsive'></a>
					<? }else{ ?>
						<a href='<?= site_url("matras/show_one/{$item_one['url']}") ?>'><img src='<?= get_image_matras("catalog","file",$item_one['image_id']); ?>' class='img-responsive'></a>
					<? } ?>
				</td>
				<td class='w1'>
					<? if(!$item_one['is_matras']){ ?>
						<p class='fs17 bold'><a href='<?= site_url("content/{$item_one['url']}") ?>'><?= $item_one['name']; ?></a></p>
					<? }else{ ?>
						<p class='fs17 bold'><a href="<?= site_url("matras/show_one/{$item_one['url']}") ?>"><?= $item_one['name']; ?></a></p>
					<? } ?>
				</td>
				<td class='nowrap price'>
					<p class='fs19 mb0'><span class='s1'><?= $item_one['price']; ?></span> <span class='fs17'>&#8381;</span></p>
				</td>
				<td class='w2 count'>
					<a href='#' class='minus pull-left'></a>
					<input type='text' class='counter pull-left cart_order_count' data-product-id="<?= $item_one['rowid']; ?>" value="<?= $item_one['qty']; ?>">
					<a href='#' class='plus pull-left'></a>
				</td>
				<td class='nowrap summa'>
					<p class='fs19 mb0'><span class='s1'><?= $item_one['price']*$item_one['qty']; ?></span> <span class='fs17'>&#8381;</span></p>
				</td>
				<td class='text-center delete'>
					<a href="/orders/del/<?= $item_one['id']; ?>" class="delete_order x" data-product-id="<?= $item_one['id']; ?>"></a>
				</td>
			</tr>
		<? } ?>
	</table>
</div>
<div class='result-cart text-center fs17'>
	Всего товаров на сумму: <span class='fs21 color-red bold'><span id="cart_summa"><?= $this->cart->total(); ?></span> <span class='fs19'>&#8381;</span></span>
</div>

<div class='row'>
	<div class='col-sm-6 col-lg-5 form-cart'>
		<div class='line fs24 mt40 mb30'>
			Оформление заказа
		</div>
		
		<form method="post" action="<?= site_url("orders/send_order"); ?>">
			<p class='pb10'>
				<label>Имя</label><br>
				<input type='text' name='fio' placeholder='Ваши ФИО' required>
			</p>
			<p class='pb10'>
				<label>Телефон</label><br>
				<input type='text' name='phone' class='form_phone' placeholder='+7(___)___-__-__' required>
			</p>
				
			<p class='pb10 pt10'>
				<a class='full-cart-info' href='#'><span>Заполнить подробную информацию</span></a>
			</p>
			<div class='full-cart hidden'>
				<p class='pb10'>
					<label>Город</label><br>
					<input type='text' name='city' placeholder='Ваш город'>
				</p>
				<p class='pb10'>
					<label>Адрес</label><br>
					<input type='text' name='address' placeholder='Ваш адрес'>
				</p>
				<p class='pb10'>
					<label>Email</label><br>
					<input type='email' name='email' placeholder='Ваш Email'>
				</p>
				<p class='pb10'>
					<label>Цвет</label><br>
					<input type='text' name='color' placeholder='Цвет изделия'>
				</p>
				<p class='pb10'>
					<select name='payment_type' class='selectpicker'>
						<option value='nal'>Оплата наличными при получении товара</option>
						<option value='nal_office'>Оплата наличными в офисе компании</option>
						<option value='beznal'>Безналичный расчет</option>
						<option value='dogovor'>Оплата по договору на расчетный счет</option>
					</select>
				</p>
				<p class='pb10'>
					<textarea cols="80" id="comment" name="comment" rows="4" rel="" placeholder="Комментарий"></textarea>
				</p>
			</div>
			
			<p class='pb10 pt10'><input type='submit' class='btn btn-red fs14 bold' value='оформить заказ'></p>				
		</div>
		<div class='col-sm-6 col-lg-offset-1 color-gray3 mt3 fs15'>
			<?= $item['text']; ?>
		</div>
	</form>
</div>