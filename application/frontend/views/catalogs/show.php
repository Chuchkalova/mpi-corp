<div class="popup-close">
  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
	<path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />
  </svg>
</div>
<div class="popup-po-item">
  <img src="<?= get_image('catalogs','file1',$item['id']) ?>" alt="">
  <div class="wrap-popup-po-item-info">
	<h6><?= $item['name'] ?></h6>
	<?= $item['short_text'] ?>
  </div>
</div>
<div class="popup-po-info">
  <?= $item['text'] ?>
</div>
<form action="#" method="POST" class="form-popup-price">
  <div class="wrap-popup-price">
	<div class="dev-content-item-price">
	 <? if($item['price']){ ?>
		от <span><?= number_format($item['price'],0,'.',' '); ?></span> ₽
	<? }else{ ?>
		цена по запросу
	<? } ?>
	</div>
	<div class="dev-content-item-counter">
	  <div class="counter">
		<div class="counter-minus"></div>
		<div class="counter-input">
		  <input type="text" value="1">
		</div>
		<div class="counter-plus"></div>
	  </div>
	</div>
	<div class="dev-content-item-cart-btn add-cart <? if($this->cart->has_id($item['id'])) echo 'add-in'; ?>" data-id='<?= $item['id'] ?>'></div>
  </div>
</form>