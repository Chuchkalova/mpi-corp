<section class="developer-page third-template">
    <div class="container">
      <div class="second-side">
        <div class="second-side-left">
          <div class="breadcrumb">
            <?= $breads; ?>
          </div>
        </div>
        <div class="second-side-right">
          <h1><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
        </div>
      </div>
    </div>
  </section>
  <section class="corporate-life about-obj">
    <img src="/imgs/corp-obj-1.png" alt="" class="object-6">
    <img src="/imgs/corp-obj-2.png" alt="" class="object-5">
    <div class="container">
		<? 
			$i=0;
			foreach($items as $item_one){				
				++$i;
		?>
				<div class="wrap-corporate-item">
					<div class="corporate-item corporate-item-<?= $i; ?>">
					  <h2><?= $item_one['name'] ?></h2>
					  <?= $item_one['text'] ?>
					</div>
					<?						
						foreach($item_one['items'] as $item_one2){
							++$i;
					?>
							<div class="corporate-item corporate-item-<?= $i; ?>">
							  <img src="<?= get_image('gallerys', 'file', $item_one2['id']); ?>" alt="">
							</div>
					<?
						}
					?>
				</div>
		<?
			}
		?>      
    </div>
</section>