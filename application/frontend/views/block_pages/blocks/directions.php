<section class="about-direction about-obj">
    <img src="/imgs/obj-1.png" alt="" class="object-3">
    <img src="/imgs/obj-2.png" alt="" class="object-4">
    <div class="container">
      <div class="about-direction-top">
        <div class="about-direction-left">
           <h2><?= $item['name']; ?></h2>
			<?= $item['text']; ?>
        </div>
        <div class="about-direction-right">
          <div class="wrap-about-direction-item">
			<? 
				foreach($items as $item_one){
					if($item_one['is_bg']){
			?>
						<div class="about-direction-item"><?= $item_one['name'] ?></div>
			<?
					}
				}
			?>
          </div>
          <div class="wrap-about-info-item">
			<? 
				$i=0;
				foreach($items as $item_one){
					if(!$item_one['is_bg']){
						++$i;
			?>
						<? if($i>3){ ?>
							<div class="about-info-item">
							  <div class="about-info-item-number"></div>
							  <p></p>
							</div>
						<? } ?>
						<div class="about-info-item">
						  <div class="about-info-item-number"><?= $item_one['name'] ?></div>
						  <?= $item_one['text'] ?>
						</div>
			<?
					}
				}
			?>
          </div>
        </div>
      </div>
    </div>
</section>