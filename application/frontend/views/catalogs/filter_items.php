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

		<? if(get_image('catalogs_group','file',$item['id'])!='/site_img/null.gif'){ ?>

			<div class="third-side-right">

			  <img src="<?= get_image('catalogs_group','file',$item['id']); ?>" alt="">

			</div>

		<? } ?>

      </div>

    </div>

  </section>
<section class="developer-catalog-form">
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
  <section class="developer-catalog test">

    <div class="container">

      <div class="developer-tab-list aaq1">

        <ul>
        <? if($count == 1){?>
            <li class="curent"><a href="#dev-2">Описание</a></li>
            <li ><a href="#dev-1">Продукты</a></li>
        <?}else{?>
            <li class="curent"><a href="#dev-1">Продукты</a></li>
            <li><a href="#dev-2">Описание</a></li>
        <?}?>
        <? if(!empty($gallerys)){ ?>
            <li><a href="#dev-3">Сертификаты</a></li>
        <?}?>
        <? if(!empty($item['text4'])){ ?>
            <li><a href="#dev-4">Дистрибутивы</a></li>
        <?}?>
        
         
        </ul>

      </div>

      <div class="developer-tab-box">
        <div class="developer-tab" id="dev-1" style="<? if($count != 1){ echo 'display: block';}else{echo 'display: none';};?>">
		  <? if(!empty($products_types)){ ?>

			  <div class="developer-tag">

				<a href="<?= site_url($item['url']); ?>" class="active">Все</span>

				<? foreach($products_types as $item_one){ ?>

					<a href="<?= site_url($item_one['url']); ?>" ><?= $item_one['name']; ?></a>

				<? } ?>

			  </div>

		  <? } ?>

          <div class="dev-side">

            <div class="dev-filter">
				<? if($item['type_id']>0){ ?>
				  <form action="#" class="filter-form"  data-base='<?= $item['url'] ?>'>

					<div class="dev-filter-top">

					  <div class="wrap-title-filter">

						<h4>Фильтры</h4>

						<span id="form-status">0</span>

					  </div>

					  <button type="reset">Сбросить фильтр</button>

					</div>

					<div class="wrap-dev-filter-section">
						<div class="wrap-filter-head">
									<a href="/" class="filter-logo">
										<img src="./../../imgs/filter-logo.png" alt="">
									</a>
									<div class="filter-head-gamb">
										<img src="./../../imgs/filter-close.png" alt="">
									</div>
								</div>
						<? foreach($types as $types_group_id=>$types_group){ ?>

						  <div class="dev-filter-section open">
						  	
							<h5><?= $types_group['name'] ?></h5>

							<div class="wrap-check-fields open">
								
								
								<? foreach($types_group['items'] as $item_one){ ?>

								  <div class="wrap-check-input">

									<label>

									  <input type="checkbox" hidden name="filters[<?= $types_group_id ?>][]" value='<?= $item_one['id']; ?>' <? if(isset($filters['filters'][$types_group_id])&&in_array($item_one['id'], $filters['filters'][$types_group_id])) echo 'checked' ?> <?
										if(!empty($item_one['seo'])){
											echo 'data-seo = "'.$item_one['seo'].'"';
										}
									  ?>>

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
						<div class="wrap-filter-mob-btn">
							<div class="filter-btn-mob-close">Закрыть фильтр</div>
							<button type="reset">Сбросить фильтр</button>
						</div>
					</div>

					<input type='hidden' name='pid' value='<?= $item['id'] ?>'>

				  </form>
				<? } ?>
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

						  <div class="dev-content-item" <?= !isset($one_page)&&$i>3?"style='display:none;'":""; ?>>

							<img src="<?= get_image('catalogs','file1',$item_one2['id']) ?>" alt="">

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

						if(!isset($one_page)&&$i>3){

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

        <div class="developer-tab" id="dev-2" style="<? if($count == 1){ echo 'display: block';}else{echo 'display: none';};?>">

          <div class="overview-block">

            <div class="overview-left">

              <img src="<?= get_image('catalogs_group','file',$item['id']); ?>" alt="">

            </div>

            <div class="overview-right">

              <?= $item['text']; ?>

            </div>

          </div>

		  <? if($item['text2_name']||$item['text2']){ ?>

			  <div class="overview-block">

				<div class="overview-left">

				   <? if($item['text2_name']){ ?><h3><?= $item['text2_name']; ?></h3><? } ?>

				</div>

				<div class="overview-right">

					<?= $item['text2']; ?>

				</div>

			  </div>

		  <? } ?>



        </div>
          <? if(!empty($gallerys)){ ?>
          <div class="developer-tab" id="dev-3" style="display: none">
              <div class="overview-block">

                  <div class="overview-left">



                  </div>

                  <div class="overview-right">
                      <h3>Наши сертификаты</h3>
                      <div class="over-gallery">

                          <? foreach($gallerys as $item_one_g){ ?>

                              <a class="fancybox" href="" data-fancybox="gal" data-src="<?= get_image('gallerys','file',$item_one_g['id']); ?>">

                                  <img src="<?= get_image('gallerys','file',$item_one_g['id'],490,693); ?>" alt="">

                              </a>

                          <? } ?>

                      </div>

                  </div>

              </div>
          </div>
          <? } ?>
          
          
         <? if($item['text4']){ ?>
          <div class="developer-tab" id="dev-4" style="display: none">
              <div class="overview-block">

                  <div class="overview-left">



                  </div>

                  <div class="overview-right">
                     
                        <div><?= $item['text4'];?></div>
                        
                  </div>

                </div>

              </div>
          <? } ?>
          
          
         
          
          
        
      </div>



    </div>

  </section>

  <section class="about-po">

    <img src="/imgs/po-bg.png" alt="" class="about-po-img">

    <div class="container">
		<div class='text3'>
			<?= $item['text3'] ?>
		</div>

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

  