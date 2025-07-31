<section class="second-page second-template">

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

  <section class="search">

    <div class="container">

      <div class="search-side">

        <div class="search-side-form">

          <form action="<?= site_url('types_all'); ?>" class="form-search" method='post'>

            <div class="wrap-input">

              <input type="text" placeholder="Поиск" name='search'>

            </div>

            <button type="submit"></button>
            <a class="reset" href='<?= site_url('types_all'); ?>'><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
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

			<div class="wrap-po-filter">

				<? foreach($groups as $item_one){ ?>

					<a href="<?= site_url($item_one['url']); ?>" <? if($item_one['id']==$item['id']){ ?>class='active'<? } ?>><?= $item_one['name']; ?></a>

				<? } ?>

			</div>

          <div class="wrap-search-items">

			<? foreach($items as $item_one){ ?>
        <!-- show1 -->
				<div class="search-item blob-item">

				  <a href="<?= site_url($item_one['url']); ?>">

					<img src="<?= get_image('catalogs_group','file',$item_one['id']); ?>" alt="">

					<span><?= $item_one['name']; ?></span>

					<?= $item_one['short_text']; ?>

					<div class="blob"></div>

					<div class="fakeblob"></div>

				  </a>

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

  <section class="ing-info">

    <div class="container">

      <div class="ing-info-side">

        <div class="ing-info-side-left">

          <?= $item['text'] ?>

        </div>

		<? if(get_image('catalogs_group','file',$item['id'])!='/site_img/null.gif'){ ?>

			<div class="ing-info-side-right">

			  <img src="<?= get_image('catalogs_group','file',$item['id']); ?>" alt="">

			</div>

		<? } ?>

      </div>

    </div>

  </section>