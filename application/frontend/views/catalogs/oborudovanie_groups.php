<section class="second-page second-template ">

    <div class="container">

      <div class="second-side">

        <div class="second-side-left">

          <div class="breadcrumb">

            <?= $breads; ?>

          </div>

        </div>

        <div class="second-side-right">

          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>

          <?= $item['short_text']; ?>

        </div>

      </div>

    </div>

  </section>

  <section class="search <? if($item['id'] == 153){ ?>structure<? } ?>">

    <div class="container">

      <div class="search-side">

        <div class="search-side-form">

          <form action="<?= site_url($item['url']); ?>" class="form-search" method='post'>

            <div class="wrap-input">

              <input type="text" placeholder="Поиск по названию" name='search' value="">

            </div>

            <button type="submit"></button>
			<a class="reset" href='<?= site_url($item['url']); ?>'><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="Close" clip-path="url(#clip0_942_25607)">
            <rect id="Rectangle 456" y="28.2843" width="40" height="5" rx="2.5" transform="rotate(-45 0 28.2843)" fill="url(#paint0_linear_942_25607)"/>
            <rect id="Rectangle 457" x="3.53516" y="0.284271" width="40" height="5" rx="2.5" transform="rotate(45 3.53516 0.284271)" fill="url(#paint1_linear_942_25607)"/>
            </g>
            <defs>
            <linearGradient id="paint0_linear_942_25607" x1="0" y1="28.2843" x2="25.3093" y2="50.2281" gradientUnits="userSpaceOnUse">
            <stop stop-color="#666"/>
            <stop offset="1" stop-color="#666"/>
            </linearGradient>
            <linearGradient id="paint1_linear_942_25607" x1="3.53516" y1="0.284271" x2="28.8445" y2="22.2281" gradientUnits="userSpaceOnUse">
            <stop stop-color="#666"/>
            <stop offset="1" stop-color="#666"/>
            </linearGradient>
            <clipPath id="clip0_942_25607">
            <rect width="32" height="32" fill="#666"/>
            </clipPath>
            </defs>
            </svg>
            </a>

          </form>

        </div>

        <div class="search-side-content">

		  <? if(!$item['is_level2']){ ?>

			<div class="wrap-po-filter">

				<a href="<?= site_url($parent['url']) ?>" <? if($parent['id']==$item['id']){ ?>class='active'<? } ?>>Все</a>

				<? foreach($groups as $item_one){ ?>

					<a href="<?= site_url($item_one['url']); ?>" <? if($item_one['id']==$item['id']){ ?>class='active'<? } ?>><?= $item_one['name']; ?></a>

				<? } ?>

			</div>

		  <? } ?>

          <div class="wrap-search-items">

			<? foreach($items as $item_one){ ?>

				<div class="search-item blob-item">
          <!-- пром оборудование -->
<!--           <pre>
<?
print_r ($item_one);
?>
</pre> -->
				  <? if($item_one['id']!= 153 && $item_one['id'] != 55 && $item_one['id'] != 146  && $item_one['id'] != 290 && $item_one['id'] != 65 && $item_one['id'] != 56 && $item_one['id'] != 201 && $item_one['id'] != 199 && $item_one['id'] != 373 ){ ?>
           <a href="https://mpi.ru.com/promyshlennoe_oborudovanie">
              <!--<a href="<?= site_url($item_one['url']); ?>"> -->
            <? }
            else
              { ?>
                 <!-- <a href="https://mpi.ru.com/promyshlennoe_oborudovanie"> -->
                   <a href="<?= site_url($item_one['url']); ?>">
                
                <!-- <div class='like-a'> -->
                <? } ?>

					<img src="<?= get_image('catalogs_group','file',$item_one['id']); ?>" alt="">

					<span><?= $item_one['name']; ?></span>

					<?= $item_one['short_text']; ?>

					<div class="blob"></div>

					<div class="fakeblob"></div>

				   <? if($item['id']!=151){ ?>
            </a>
          <? }else{ ?>
            </a>
            <!-- </div> -->
          <? } ?>

				</div>

			<? } ?>

          </div>

		  <? if($pager){ ?>

			  <div class="pagination">

				<?= $pager; ?>

			  </div>

		  <? } ?>

        </div>

      </div>

    </div>

  </section>

<? $urlImg = get_image('catalogs_group','file',$item['id'])?>
<?if (strpos($urlImg, 'null.png') === false && strpos($urlImg, 'catalogs_group_file_8_l.png') === false) { ?>
  <section class="ing-info test1">
        <pre style="display: none;">
            <?print_r($urlImg)?>
        </pre>
    <div class="container">

      <img src="<?= $urlImg ?>" alt="" class="detail-logo-img">
      <div class="wrap-text-detail-company">
        <?= $item['text'] ?>
      </div>
        <!--<div class="ing-info-side">

        <div class="ing-info-side-left">

          <?= $item['text'] ?>

        </div>

		<? if(get_image('catalogs_group','file',$item['id'])!='/site_img/null.gif'){ ?>

			<div class="ing-info-side-right">

			  <img src="<?= get_image('catalogs_group','file',$item['id']); ?>" alt="">

			</div>

		<? } ?>

      </div> -->

    </div>

  </section>
<?}?>