<section class="second-page second-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
			<?= $breads; ?>
          </div>
          <div class="second-tags">
			<? foreach($items as $item_one){ ?>
				<a href="<?= site_url($item_one['url']); ?>"><span>#</span> <?= $item_one['name'] ?></a>
			<? } ?>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>
          <?= $item['short_text']; ?>
        </div>
      </div>
    </div>
  </section>
  <section class="about-po">
    <img src="/imgs/po-bg.png" alt="" class="about-po-img">
    <div class="container">
      <?= $item['text'] ?>
    </div>
  </section>
  