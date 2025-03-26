<div class="cart_empty <? if($this->cart->total_items_qty()>0) echo "hidden"; ?>">
	<p class='fs18 bold mb0'>Корзина</p>
	<p>Пуста</p>
</div>
<div class="cart_text <? if($this->cart->total_items_qty()==0) echo "hidden"; ?>">
	<span class='count fs10 color-white' id="total_count"><?= $this->cart->total_items_qty(); ?></span>
	<p class='fs18 bold mb0'>Корзина</p>
	<p class='fs18 color-red mb0'><span id="total_sum"><?= $this->cart->total(); ?></span> <span class='fs14'>&#8381;</span></p>
	<a href='<?= site_url("orders/cart"); ?>'></a>
</div>

