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
  <section class="contact-page">
    <div class="container">
      <?= $item['text'] ?>
	  <ul class='sitemap'>
		<?
			foreach($items as $item_one){
		?>
				<li>
					<a href='<?= $item_one['url'] ?>'><?= $item_one['name'] ?></a>
					<? if(!empty($item_one['subitems'])){ ?>
						<ul>
							<?
								foreach($item_one['subitems'] as $item_one2){
							?>
								<li>
									<a href='<?= $item_one2['url'] ?>'><?= $item_one2['name'] ?></a>
									<? if(!empty($item_one2['subitems'])){ ?>
										<ul>
											<?
												foreach($item_one2['subitems'] as $item_one3){
											?>
												<li>
													<a href='<?= $item_one3['url'] ?>'><?= $item_one3['name'] ?></a>
													<? if(!empty($item_one3['subitems'])){ ?>
														<ul>
															<?
																foreach($item_one3['subitems'] as $item_one4){
															?>
																<li>
																	<a href='<?= $item_one4['url'] ?>'><?= $item_one4['name'] ?></a>
																</li>
															<? } ?>
														</ul>
													<? } ?>
												</li>
											<? } ?>
										</ul>
									<? } ?>
								</li>
							<? } ?>
						</ul>
					<? } ?>
				</li>
		<?
			}
		?>
	  </ul>
    </div>
</section>