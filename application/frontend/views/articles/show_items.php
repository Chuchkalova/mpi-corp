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
  <section class="filter-events">
    <div class="container">
      <div class="filter-tabs">
		<a href='<?= site_url('events'); ?>' class="filter-tab <?= $pid==0?"active":""; ?>">Все</a>
		<? foreach($groups as $item_one){ ?>
			<a href='<?= site_url($item_one['url']); ?>' class="filter-tab <?= $pid==$item_one['id']?"active":""; ?>"><?= $item_one['name'] ?></a>
		<? } ?>
      </div>
      <div class="filter-products">
		<? foreach($items as $item_one){ ?>
			<div class="filter-product">
			  <div class="filter-product-body">
				<img src="<?= get_image('articles','file',$item_one['id']); ?>" alt="">
				<div class="filter-product-info">
				  <div class="filter-product-info-top">
					<div class="filter-product-info-category"><span>#</span><?= $item_one['unit']; ?></div>
					<div class="filter-product-info-date"><?= format_date($item_one['date']); ?></div>
				  </div>
				  <a href="<?= site_url('articles/'.$item_one['url']) ?>"><?= $item_one['name']; ?></a>
				  <?= $item_one['short_text']; ?>
				  <p><span><?= $item_one['address']; ?></span></p>
				</div>
				<a href="<?= site_url('articles/'.$item_one['url']) ?>" class="filter-product-btn" data-popup="edu-curs">Подробнее</a>
			  </div>			 
			</div>
		<? } ?>
      </div>
	  <? if($pager){ ?>
		  <div class="pagination">
			<?= $pager; ?>
		  </div>
		<? } ?>
    </div>
</section>
 