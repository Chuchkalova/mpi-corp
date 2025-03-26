<section class="developer-page third-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
            <ul>
              <li><a href="<?= site_url('/'); ?>">Главная</a></li>
              <li><a href="#">Корзина</a></li>
            </ul>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="cart">
    <div class="container">
      <form action="#" class="cart-form" method='post'>
        <div class="cart-side">
          <div class="cart-content">
			<? if(count($items_po)){ ?>
				<?
					$po_summa=0;
					$po_count=0;
				?>
				<div class="cart-content-block">
				  <h2>Программное обеспечение</h2>
				  <div class="cart-block-delete" data-pid='1'>Удалить весь список</div>
				  <div class="wrap-cart-block-item">
					<? foreach($items_po as $item_one){ ?>
						<?
							$po_summa+=$item_one['qty']*$item_one['price'];
							$po_count+=$item_one['qty'];
						?>
						<div class="cart-block-item">
						  <img src="<?= get_image('catalogs','file1',$item_one['id']) ?>" alt="">
						  <div class="cart-block-item-info">
							<a href="#" data-popup="po" data-catalogs_id='<?= $item_one['id']; ?>' data-callback='openCatalogPopup'><?= $item_one['name']; ?></a>
							<?= $item_one['short_text']; ?>
						  </div>
						  <div class="cart-price-counter">
							<div class="dev-content-item-price">
								<? if($item_one['price']){ ?>
									от <span><?= number_format($item_one['price'],0,'.',' '); ?></span> ₽
								<? }else{ ?>
									цена по запросу
								<? } ?>
							</div>
							<div class="dev-content-item-counter">
							  <div class="counter">
								<div class="counter-minus"></div>
								<div class="counter-input">
								  <input type="text" value="<?= $item_one['qty'] ?>" data-id="<?= $item_one['rowid']; ?>">
								</div>
								<div class="counter-plus"></div>
							  </div>
							</div>
						  </div>
						  <div class="cart-block-item-delete" data-id="<?= $item_one['rowid']; ?>"></div>
						</div>
					<? } ?>
				  </div>
				</div>				
			<? } ?>
			<? if(count($items_oborud)){ ?>
				<?
					$oborud_summa=0;
					$oborud_count=0;
				?>
				<div class="cart-content-block">
				  <h2>Оборудование</h2>
				  <div class="cart-block-delete" data-pid='5'>Удалить весь список</div>
				  <div class="wrap-cart-block-item">
					<? foreach($items_oborud as $item_one){ ?>
						<?
							$oborud_summa+=$item_one['qty']*$item_one['price'];
							$oborud_count+=$item_one['qty'];
						?>
					  
						<div class="cart-block-item">
						  <img src="<?= get_image('catalogs','file1',$item_one['id']) ?>" alt="">
						  <div class="cart-block-item-info">
							<a href="#" data-popup="po" data-catalogs_id='<?= $item_one['id']; ?>' data-callback='openCatalogPopup'><?= $item_one['name']; ?></a>
							<?= $item_one['short_text']; ?>
						  </div>
						  <div class="cart-price-counter">
							<div class="dev-content-item-price">
								<? if($item_one['price']){ ?>
									от <span><?= number_format($item_one['price'],0,'.',' '); ?></span> ₽
								<? }else{ ?>
									цена по запросу
								<? } ?>
							</div>
							<div class="dev-content-item-counter">
							  <div class="counter">
								<div class="counter-minus"></div>
								<div class="counter-input">
								  <input type="text" value="<?= $item_one['qty'] ?>" data-id="<?= $item_one['rowid']; ?>">
								</div>
								<div class="counter-plus"></div>
							  </div>
							</div>
						  </div>
						  <div class="cart-block-item-delete" data-id="<?= $item_one['rowid']; ?>"></div>
						</div>
					<? } ?>
				  </div>
				</div>
			<? } ?>
			<div class="form-order" id="section1">
			<h2>Оформление заказа</h2>
			<?= $item['text'] ?>
			<div class="wrap-form-input">
			  <div class="wrap-input">
				<label>
				  <input type="text" name="name" required>
				  <span>Ваше имя</span>
				</label>
			  </div>
			  <div class="wrap-input">
				<input type="tel" name="phone" placeholder="+7 (___) ___-__-__" required>
			  </div>
			  <div class="wrap-input">
				<label>
				  <input type="text" name='email' required>
				  <span>E-mail</span>
				</label>
			  </div>
			  <div class="wrap-input">
				<label>
				  <input type="text" name='org'>
				  <span>Организация</span>
				</label>
			  </div>
			  <div class="wrap-input">
				<label>
				  <input type="text" name='city'>
				  <span>Город</span>
				</label>
			  </div>
			  <div class="wrap-input">
				<label>
				  <input type="text" name='comment'>
				  <span>Напишите, что Вас интересует</span>
				</label>
			  </div>
			  <div class="wrap-check">
				<p>Нажимая на кнопку «Оформить заказ» Вы даете согласие на <a href="<?= site_url('politic') ?>" target='_blank'>обработку персональных данных</a></p>
				<button type="submit">Оформить заказ</button>
			  </div>
			</div>
			</div>
          </div>
          <div class="cart-right">
            <div class="cart-scroll-block">
              <h3>Ваш заказ</h3>
			  <? if(count($items_po)){ ?>
				  <div class="cart-price-block-item" data-pid='1'>
					<div class="cart-price-block-item-name">
					  ПО (<span class='count-po'><?= $po_count; ?></span>)
					</div>
					<div class="cart-price-block-item-tag">
					  от <span class='summa-po'><?= number_format($po_summa,0,'.',' '); ?></span> ₽
					</div>
				  </div>
			  <? } ?>
			  <? if(count($items_oborud)){ ?>
				  <div class="cart-price-block-item" data-pid='5'>
					<div class="cart-price-block-item-name">
					  Оборудование (<span class='count-oborud'><?= $oborud_count; ?></span>)
					</div>
					<div class="cart-price-block-item-tag">
					  от <span class='summa-oborud'><?= number_format($oborud_summa,0,'.',' '); ?></span> ₽
					</div>
				  </div>
			  <? } ?>
              <div class="cart-total-price">
                <div class="cart-total-price-left">Итого</div>
                <div class="cart-total-price-right">от <span class='cart-summa-formatted'><?= number_format($this->cart->total(),0,'.',' '); ?></span> ₽</div>
              </div>
              <div class="go-anchor" data-scroll-to="section1">Оформить заказ</div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
 

<div id="po" class="popup">
	<div class="popup-body">
	  <div class="popup-content">
		
	  </div>
	</div>
</div>
  
  <div id="cart-thx" class="popup">
    <div class="popup-body">
      <div class="popup-content">
        <div class="popup-close">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />
          </svg>
        </div>
        <h3>Заказ оформлен!</h3>
        <p><span>Спасибо! Ваш заказ успешно оформлен.</span></p>
        <p>В ближайшее время с Вами свяжется наш специалист для уточнения деталей и дальнейшего оформления заказа.</p>
        <p>Данные по заказу мы отправили на указанный Вами e-mail адрес</p>
        <a href="<?= site_url('/') ?>" class="popup-back-close-btn">Перейти на главную</a>
      </div>
    </div>
  </div>