<section class="second-page second-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
            <?= $breads; ?>
          </div>
          <div class="second-tags">
			<? foreach($items as $item_one){ ?>
				<a href="<?= site_url($item_one['url']); ?>"><span>#</span> <?= $item_one['menu_name']?$item_one['menu_name']:$item_one['name']; ?></a>
			<? } ?>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= $item['name'] ?></h1>
           <?= $item['short_text'] ?>
        </div>
      </div>
    </div>
  </section>
  <section class="edu-vector">
    <div class="container">
      <div class="wrap-edu-vector-item">
		<? 
			foreach($items as $item_one){
		?>
				<div class="edu-vector-item">
				  <img src="<?= get_image('educations_group','file',$item_one['id']); ?>" alt="">
				  <div class="wrap-edu-vector-item-info">
					<div class="edu-vector-item-info-left">
					  <h3><?= $item_one['name'] ?></h3>
					  <?= $item_one['short_text'] ?>
					</div>
					<div class="edu-vector-item-info-right">
					  <a href="<?= site_url($item_one['url']); ?>">Подробнее</a>
					</div>
				  </div>
				</div>
        <?
			}
		?>
      </div>
    </div>
  </section>
  <section class="edu-center">
    <div class="container">
      <h2><?= $item['h1'] ?></h2>
      <div class="wrap-edu-center-side">
        <div class="edu-center-left">
          <?= $item['text'] ?>
        </div>
        <div class="edu-center-right">
          <div class="edu-center-slider">
			<? foreach($gallerys as $item_one){ ?>
				<div class="edu-slide">
				  <img src="<?= get_image('gallerys','file',$item_one['id']); ?>" alt="">
				</div>
			<? } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="choice">
    <div class="container">
      <h4><?= $texts['name']; ?></h4>
      <div class="wrap-choice-item">
		<? foreach($texts['items'] as $item_one){ ?>
			<div class="choice-item">
			  <div class="choice-item-number"><?= $item_one['name'] ?></div>
			  <?= $item_one['text'] ?>
			</div>
        <? } ?>
      </div>
    </div>
  </section>
  