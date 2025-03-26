<section class="about-developer">
    <div class="container">
      <h2><?= $item['name'] ?></h2>
      <?= $item['text'] ?>
      <div class="wrap-about-developer-items">
		<? foreach($items as $item_one){ ?>
			<div class="about-developer-item">
				<? if($item_one['href']){ ?><a href='<?= $item_one['href'] ?>'><? } ?>
					<img src="<?= get_image('block_pages','file',$item_one['id']); ?>" alt="">
				<? if($item_one['href']){ ?></a><? } ?>
			</div>
		<? } ?>
      </div>
      <a href="<?= site_url($catalog['url']); ?>" class="go-link-btn">Перейти в Программное обеспечение</a>
    </div>
  </section>