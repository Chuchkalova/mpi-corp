<section class="developer-page third-template">

    <div class="container">

      <div class="second-side">

        <div class="second-side-left">

          <div class="breadcrumb">

            <?= $breads; ?>

          </div>

        </div>

        <div class="second-side-right">

          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>

        </div>

      </div>

    </div>

  </section>

<section class="developer-catalog-form tt1">

    <div class="container">

        <div class="wrap-developer-catalog-form">

            <div class="developer-catalog-form-top">

                <h2>Нужна помощь в подборе ПО или оборудования?</h2>

                <a href="#" data-popup="call">Оставить заявку</a>

            </div>

            <div class="developer-catalog-form-bottom">

                <p>Оставьте заявку, и наши специалисты помогут с выбором.</p>

            </div>



        </div>

    </div>

</section>

  <section class="developer-catalog">

    <div class="container">

      <div class="developer-tab-box">

        <div class="developer-tab" id="dev-1" style="display: block">

		  <? if(!empty($products_types)){ ?>

			  <div class="developer-tag">

				<a href="<?= site_url('types_all'); ?>">Все</span>

				<? foreach($products_types as $item_one){ ?>

					<a href="<?= site_url($item_one['url']); ?>" <? if($item['id']==$item_one['id']){ ?>class="active"<? } ?>><?= $item_one['name']; ?></a>

				<? } ?>

			  </div>

		  <? } ?>

          <div class="dev-side">

            <div class="dev-filter">

              <form action="#" class="filter-form">

                <div class="dev-filter-top">

                  <div class="wrap-title-filter">

                    <h4>Фильтры</h4>

                    <span id="form-status">0</span>

                  </div>

                  <button type="reset">Сбросить фильтр</button>

                </div>

                <div class="wrap-dev-filter-section">

					<? foreach($types as $types_group_id=>$types_group){ ?>

					  <div class="dev-filter-section">

						<h5><?= $types_group['name'] ?></h5>

						<div class="wrap-check-fields">

							<? foreach($types_group['items'] as $item_one){ ?>

							  <div class="wrap-check-input">

								<label>

								  <input type="checkbox" hidden name="filters[<?= $types_group_id ?>][]" value='<?= $item_one['id']; ?>' <? if(isset($filters['filters'][$types_group_id])&&in_array($item_one['id'], $filters['filters'][$types_group_id])) echo 'checked' ?>>

								  <span></span>

								  <p><?= $item_one['name']; ?></p>

								</label>

							  </div>

							<? } ?>

						</div>

					  </div>

					<? } ?>

					<? if($min_max['max']>0){ ?>

					  <div class="dev-filter-section">

						<h5>Цена</h5>

						<div class="wrap-range-input">

						  от

						  <input type="text" class="value-input value-input-lower" id="lower-value" value="<?= isset($filters['price_from'])?$filters['price_from']:$min_max['min']; ?>" name='price_from'>

						</div>

						<div class="wrap-range-input">

						  до

						  <input type="text" class="value-input value-input-upper" id="upper-value" value="<?= isset($filters['price_to'])?$filters['price_to']:$min_max['max']; ?>"name='price_to'>

						</div>

						<div class="slider" data-min="<?= $min_max['min']; ?>" data-max="<?= $min_max['max']; ?>"></div>

					  </div>

					<? } ?>

                </div>

				<input type='hidden' name='product_types_id' value='<?= $item['id'] ?>'>

              </form>

            </div>

            <div class="dev-content">

				<? foreach($items as $item_one){ ?>

				  <div class="dev-content-block">

					<h5><?= $item_one['name'] ?></h5>

					<div class="wrap-dev-content-item">

						<? 

						$i=0;

						foreach($item_one['items'] as $item_one2){

							++$i;

						?>

						  <div class="dev-content-item" <?= $i>3?"style='display:none;'":""; ?>>

                              <?if ($item_one2['pid'] == 357) {?>

                                  <img src="<?= get_image('catalogs','file1',54422) ?>" alt="">

                              <?} else {?>

                                  <img src="<?= get_image('catalogs','file1',$item_one2['id']) ?>" alt="">

                              <?}?>

							<div class="dev-content-item-info">

							  <a href="#" data-popup="po" data-catalogs_id='<?= $item_one2['id']; ?>' data-callback='openCatalogPopup'><?= $item_one2['name'] ?></a>

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

						if($i>3){

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

            </div>

          </div>

        </div>

      </div>



    </div>

  </section>

  <section class="about-po">

    <img src="/imgs/po-bg.png" alt="" class="about-po-img">

    <div class="container">

      <?= $item['text'] ?>

      <div class="wrap-about-po-item">

		<? 	foreach($texts['items'] as $item_one3){ ?>

			<div class="about-po-item">

			  <span><?= $item_one3['name']; ?></span>

			  <?= $item_one3['text']; ?>

			</div>

        <?

			}

		?>

      </div>

    </div>

  </section>

  

  <div id="po" class="popup">

    <div class="popup-body">

      <div class="popup-content">

        

      </div>

    </div>

  </div>

  