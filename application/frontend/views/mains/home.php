<section class="eff-type-1" id="angle-bg">
  <canvas style="display: block;"></canvas>
  <div class="round-earth" id="round-earth">
    <div class="earth"></div>
  </div>
  <div class="round">
    <div class="menu-item menu-item-1 active" data-tab="tab-1">
      <div class="wrap-menu-item"> <span></span>
        <p>Анонсы</p>
      </div>
    </div>
    <div class="menu-item menu-item-2" data-tab="tab-2">
      <div class="wrap-menu-item"> <span></span>
        <p>
          <?= $catalogs2['name']; ?>
        </p>
      </div>
    </div>
    <div class="menu-item menu-item-3" data-tab="tab-3">
      <div class="wrap-menu-item"> <span></span>
        <p>
          <?= $catalogs1['name']; ?>
        </p>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="tab-box">
      <div class="tab" id="tab-1" style="display: block;">
      	<div class="desc-new-design">
            <?
            $i=0;
            foreach($articles as $item_one){

            ++$i;
            ?>

            <div class="chapter-article">
                <h3><?= $item_one['name']; ?></h3>
                <div class="wrap-chapter-content">
                    <div class="wrap-list-box-items">

                        <?
                        $m = 0;
                        foreach($item_one['items'] as $item_one2){
                            $m++;
                            if($m > 2) break;
                            ?>
                            <div class="list-box-items">
                                <span><?= format_date($item_one2['date']); ?></span>
                                <a href="<?= site_url("articles/".$item_one2['url']); ?>"><?= $item_one2['name']; ?></a>
                            </div>
                        <? } ?>

                    </div>
                    <a href="<?= site_url($item_one['url']); ?>" class="tab-btn">Смотреть все</a>
                </div>
            </div>
            <? } ?>
      	</div>
      	<div class="mobile-new-design">
        <div class="wrap-mob-title"> Анонсы
          <a href="#" class="mobile-btn"></a>
        </div>
        <ul class="wrap-tabs-list">
          <?

				$i=0;

				foreach($articles as $item_one){

					++$i;

			?>
            <li <? if($i==1){ ?>class="curent"
              <? } ?>>
                <a href="#tab-list-<?= $item_one['id']; ?>">
                  <?= $item_one['name']; ?>
                </a>
            </li>
            <?

				}

			?>
        </ul>
        <?

				$i=0;

				foreach($articles as $item_one){

					++$i;

			?>
          <div class="tabs-list-box" id="tab-list-<?= $item_one['id']; ?>" style="display: <?= $i==1?" block ":"none "; ?>;">
            <div class="wrap-list-box-items">
              <? foreach($item_one['items'] as $item_one2){ ?>
                <div class="list-box-items"> <span><?= format_date($item_one2['date']); ?></span>
                  <a href="<?= site_url("articles/".$item_one2['url']); ?>">
                    <?= $item_one2['name']; ?>
                  </a>
                  <?= $item_one2['short_text']; ?>
                </div>
                <? } ?>
            </div> <a href="<?= site_url($item_one['url']); ?>" class="tab-btn" >Смотреть все</a> </div>
          <?

				}

			?>
      </div>
      </div>
      <div class="tab" id="tab-2" style="display: none;">
        <div class="wrap-mob-title">
          <?= $catalogs2['name']; ?>
        </div>
        <h2><?= $catalogs2['name']; ?></h2>
        <div class="wrap-link-tab">
          <? foreach($catalogs2['items'] as $item_one){ ?> <a href="<?= site_url($item_one['url']); ?>" class="tab-link"><span>#</span><?= $item_one['name']; ?></a>
            <? } ?>
        </div> <a href="<?= site_url($catalogs2['url']); ?>" class="tab-btn">Подробнее</a> </div>
      <div class="tab" id="tab-3" style="display: none;">
        <div class="wrap-mob-title">
          <?= $catalogs1['name']; ?>
        </div>
        <h2><?= str_replace(' ','<br> ',$catalogs1['name']); ?></h2>
        <div class="wrap-link-tab">
          <? foreach($catalogs1['items'] as $item_one){ ?> <a href="<?= site_url($item_one['url']); ?>" class="tab-link"><span>#</span><?= $item_one['name']; ?></a>
            <? } ?>
        </div> <a href="<?= site_url($catalogs1['url']); ?>" class="tab-btn">Подробнее</a> </div>
    </div>
  </div>
</section>
<section class="main-about about-obj"> <img src="/imgs/object-1.png" alt="" class="object-1"> <img src="/imgs/object-2.png" alt="" class="object-2">
  <div class="container">
    <div class="title-block mission">
      <h4><?= $texts[0]['name'] ?></h4>
      <?= $texts[0]['text'] ?>
    </div>
    <div class="title-block number-title">
      <h4><?= $texts[1]['name'] ?></h4>
      <div class="wrap-number-items">
        <? 

				$i=0;

				foreach($texts[1]['items'] as $item_one){ 

					++$i;

			?>
          <? if($i>2){ ?>
            <div class="number-item"></div>
            <? } ?>
              <div class="number-item"> <span><?= $item_one['name']; ?></span>
                <?= $item_one['text']; ?>
              </div>
              <? } ?>
      </div>
    </div>
    <div class="title-block">
      <h4><?= $item['h1']; ?></h4>
      <div class="title-block-side">
        <div class="title-left">
          <?= $item['text']; ?>
            <div class="wrap-title-btn"> <a href="<?= site_url($page1['url']) ?>">Подробнее <br>о нас</a> </div>
        </div>
        <div class="title-right">
          <? foreach($texts[2]['items'] as $item_one){  ?>
            <div class="title-right-item">
              <?= strip_tags($item_one['text']); ?>
            </div>
            <? } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="et-hero-tabs">
  <h4>наши партнеры</h4>
  <div class="et-hero-tabs-container">
    <? foreach($catalogs1['items'] as $item_one){ ?>
      <a class="et-hero-tab" href="#tab-catalog-<?= $item_one['id']; ?>">
        <?= $item_one['name']; ?>
      </a>
      <? } ?> <span class="et-hero-tab-slider"></span> </div>
</section>
<main class="et-main">
  <? foreach($catalogs1['items'] as $item_one){ ?>
    <section class="et-slide" id="tab-catalog-<?= $item_one['id']; ?>">
      <div class="container">
        <div class="wrap-et-slide-side">
          <div class="et-slide-left">
            <?= $item_one['short_text']; ?> <a href="<?= site_url($item_one['url']); ?>">Узнать <br>подробнее</a> </div>
          <div class="et-slide-right">
            <? foreach($item_one['items'] as $item_one2){ ?> <a class="et-slide-item blob-item" href='<?= site_url($item_one2['url']); ?>'>

					  <img src="<?= get_image('catalogs_group','file',$item_one2['id']); ?>" alt="">

					  <?= $item_one2['short_text']; ?>

					  <div class="blob"></div>

					  <div class="fakeblob"></div>

					</a>
              <? } ?>
                <div id="follower"></div>
          </div>
        </div>
      </div>
    </section>
    <? } ?>
</main>
<section class="marque-side">
  <h4>наши заказчики</h4>
  <div class="marquee " id="marquee">
    <? foreach($gallerys1 as $item_one){ ?> <img src="<?= get_image('gallerys','file',$item_one['id']); ?>" alt="">
      <? } ?>
  </div>
  <div class="marquee" id="marquee-2">
    <? foreach($gallerys2 as $item_one){ ?> <img src="<?= get_image('gallerys','file',$item_one['id']); ?>" alt="">
      <? } ?>
  </div>
</section>