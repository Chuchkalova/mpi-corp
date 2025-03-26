<div class='cart pt10'>
	<div class='cart-empty <?= ($this->cart->total_items_qty()==0)?'':'hidden'; ?>'>
		<div class='relative cart-block fs13 pb15'>
			Корзина пуста
		</div>
	</div>
	<div class='cart-full <?= ($this->cart->total_items_qty()==0)?'hidden':''; ?>'>
		<div class='relative cart-block fs18 pb5'>
			<span class='cart-summa'><?= $this->cart->total(); ?></span> р.
			<span class='cart-count'><?= $this->cart->total_items_qty(); ?></span>
		</div>
		<p class='text-center fs13 pb5'><a href='<?= site_url("orders/cart") ?>' class='color-gray underline'>Оформить заказ</a></p>
	</div>
</div>