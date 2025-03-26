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
  <section class="developer-catalog">
    <div class="container">
      <div class="developer-tab-list">
        <ul>
			<?
				$i=0;
				foreach($items as $item_one){
					++$i;
			?>
					<li <? if($i==1){ ?>class="curent"<? } ?>><a href="#dev-<?= $item_one['id']; ?>"><?= $item_one['name']; ?></a></li>
			<?
				}
			?>
        </ul>
      </div>
      <div class="developer-tab-box">
		<?
			$i=0;
			foreach($items as $item_one){
				++$i;
		?>
			<div class="developer-tab" id="dev-<?= $item_one['id']; ?>" style="display: <?= $i==1?"block":"none"; ?>">
			  <div class="wrap-developer-items">
				<? foreach($item_one['items'] as $item_one2){ ?>
					<div class="developer-item">
					  <img src="<?= get_image('educations','file',$item_one2['id']); ?>" alt="">
					  <div class="developer-item-info">
						<a href="<?= site_url($item_one2['url']); ?>"><?= $item_one2['name'] ?></a>
						<?= $item_one2['short_text'] ?>
						<div class="wrap-developer-item-price">
						  <div class="developer-item-price">от <span><?= number_format($item_one2['price'],0,'.',' '); ?></span> ₽</div>
						  <div class="developer-item-time">
							<? if($item_one2['hours']){ ?>
								<div class="left-time"><span><?= $item_one2['hours']; ?></span>ак.<?
									if($item_one2['hours']%10==1&&$item_one2['hours']%100!=11){
										echo 'час';
									}
									else if(($item_one2['hours']%10==2||$item_one2['hours']%10==3||$item_one2['hours']%10==4)&&$item_one2['hours']%100!=12&&$item_one2['hours']%100!=13&&$item_one2['hours']%100!=14){
										echo 'часа';
									}
									else{
										echo 'часов';
									}
								?></div>
								<div class="line-time"></div>
							<? } ?>
							<? if($item_one2['days']){ ?>
								<div class="right-time"><span><?= $item_one2['days']; ?></span><?
									if($item_one2['days']%10==1&&$item_one2['days']%100!=11){
										echo 'день';
									}
									else if(($item_one2['days']%10==2||$item_one2['days']%10==3||$item_one2['days']%10==4)&&$item_one2['days']%100!=12&&$item_one2['days']%100!=13&&$item_one2['days']%100!=14){
										echo 'дня';
									}
									else{
										echo 'дней';
									}
								?></div>
							<? } ?>
						  </div>
						</div>
					  </div>
					</div>
				<? } ?>
			  </div>			 
			</div>
		<? } ?>
      </div>
	  <div class="developer-curs">
		<h2><?= $item['h2']; ?></h2>
		<div class="developer-curs-side">
		  <div class="developer-curs-info">
			<?= $item['text']; ?>
		  </div>
		  <div class="developer-curs-img">
			<img src="<?= get_image('educations_group','file2',$item['id']); ?>" alt="">
		  </div>
		</div>
	  </div>
    </div>
  </section>