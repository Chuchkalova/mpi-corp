<h1 class="page_name"><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
<div id="search_product">
	<form accept-charset="UTF-8" action="<?= site_url("/catalog_group/search/"); ?>" method="post">
		<input name="article" placeholder="артикул товара" required="required" size="15" title="Введите артикул" type="text" value="<?= $find; ?>" />
		<input type="image" src="/site_img/search_button.png" />
	</form>
</div>

<div class="products">
	<? if(count($items)){ ?>
		<section>
			<ul class="products_list">
			<? foreach($items as $item){ ?><li>
					<article>
						<a href="<?= site_url("/catalog/show/{$item['url']}"); ?>" class="product_title"><?= $item['name']; ?></a>
						<a href="<?= site_url("/catalog/show/{$item['url']}"); ?>" title="<?= $item['name']; ?>">
							<img alt="<?= $item['name']; ?>" src="<?= get_image('catalog', 'file', $item['id']); ?>" />
						</a>
						<span class="price"><?= $item['price']; ?> РУБ.</span>
						<div class="product_order_button" id="product_<?= $item['id']; ?>">
							<?
								if($this->cart->has_id($item['id'])==false){
							?>
									<a href="/cart/add/<?= $item['id']; ?>/1" class="btn_order" data-product-id="<?= $item['id']; ?>">добавить в корзину</a>
							<?
								}
								else{
							?>
									<a href="/cart/show/" class="btn_order_exist">оформить заказ</a>
							<?
								}
							?>
						</div>	
					</article>
			</li><? } ?>
			</ul>
		</section>	
	<? }else{ ?>
		<p>По вашему запросу ничего не найдено</p>
	<? } ?>
</div>

<? if($pager){ ?>
	<div class="pagination">
		<?= $pager; ?>
	</div>
<? } ?>