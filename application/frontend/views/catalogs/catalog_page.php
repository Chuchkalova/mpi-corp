<? foreach($items as $item_one){ ?>

  <div class="dev-content-block">

	<h5><?= $item_one['name'] ?></h5>

	<div class="wrap-dev-content-item">

		<? 

		$i=0;

		foreach($item_one['items'] as $item_one2){

			++$i;

		?>

		  <div class="dev-content-item" <?= empty($one_page)&&$i>3?"style='display:none;'":""; ?>>

              <?if ($item_one2['pid'] == 357) {?>
                  <img src="<?= get_image('catalogs','file1',54422) ?>" alt="">
              <?} else {?>
                  <img src="<?= get_image('catalogs','file1',$item_one2['id']) ?>" alt="">
              <?}?>

			<div class="dev-content-item-info">

			  <a href="#" data-popup="po"  data-catalogs_id='<?= $item_one2['id']; ?>' data-callback='openCatalogPopup'><?= $item_one2['name'] ?></a>

			  <?= $item_one2['short_text'] ?>

			</div>

			<div class="dev-content-item-cart">

			  <form action="#" class="form-dev-content-item-cart">

				<div class="dev-content-item-cart-left">

				  <div class="dev-content-item-price">

					<? if($item_one2['price']){ ?>

						от <span><?= number_format($item_one2['price'],0,'.',' '); ?></span> ₽

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

				</div>

				<div class="dev-content-item-cart-btn add-cart <? if($this->cart->has_id($item_one2['id'])) echo 'add-in'; ?>" data-id='<?= $item_one2['id'] ?>'></div>

			  </form>

			</div>

		  </div>

		<?

		}

		if(empty($one_page)&&$i>3){

		?>

			<div class="see-more">Показать ещё <?= count($item_one['items'])-3; ?></div>

		<? } ?>

	</div>

  </div>

<? } ?>

<? if($pager){ ?>

  <div class="pagination">

	<?= $pager; ?>

  </div>

<? } ?>