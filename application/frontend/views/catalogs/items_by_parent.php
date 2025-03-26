<section class="featured items_by_parent_wrapper">
    <div class="container">
		<? if($parametrs->name){ ?>
			<h1 class="headingfull"><span><?= $parametrs->name; ?></span></h1>
		<? } ?>
      
		<? if(count($raw_items)){ ?>
			<ul class="thumbnails">
				<? 
					$i=0;
					foreach($raw_items as $item_one){ 
						++$i;
				?>
						<li class="span4">
						  <div class="thumbnail">
							<img alt="<?= $item_one['name']; ?>" src="<?= get_image('catalog', 'file', $item_one['id']); ?>">
							<div class="caption">
								<p class="prdocutname"><?= $item_one['name']; ?></p>
								<?= $item_one['text']; ?>
								<p><a href="#order_me" class="btn btn-success fancybox" data-rel="<?= $item_one['id']; ?>">Заказать</a></p>
							</div>
						  </div>
						</li>
				<? 
						if($i%$parametrs->in_string==0) echo "<div class='clear'></div>";
					}
				?>
			</ul>
		<? } ?>
    </div>
</section>