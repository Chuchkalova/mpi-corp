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
      <div class="support">
        <h2>Техническая поддержка</h2>
        <div class="wrap-support-contact-item">
          <div class="support-contact-item support-contact-item-1">
            <p>По вопросам технической поддержки</p>
            <a href="mailto:<?= trim(strip_tags($block['text'])); ?>"><?= trim(strip_tags($block['text'])); ?></a>
          </div>
		  <? if($this->settings[5]){ ?>
			  <div class="support-contact-item support-contact-item-2">
				<p>Чат технической поддержки</p>
				<a href="<?= $this->settings[5]; ?>">Общие вопросы</a>
			  </div>
		  <? } ?>
		  <? if($this->settings[6]){ ?>
			  <div class="support-contact-item support-contact-item-3">
				<p>Чат технической поддержки</p>
				<a href="<?= $this->settings[6]; ?>">GIPRO</a>
			  </div>
		  <? } ?>
        </div>
      </div>
      <div class="developer-tab-list">
        <ul>
			<?
				$i=0;
				foreach($contacts as $item_one){
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
			foreach($contacts as $item_one){
				++$i;
		?>
			<div class="developer-tab" id="dev-<?= $item_one['id']; ?>" style="display: <?= $i==1?"block":"none"; ?>">
			  <div class="city-contact">
				<div class="city-contact-left">
					<? if($item_one['address']){ ?>
					  <div class="city-contact-item">
						<h4>адрес</h4>
						<p><?= $item_one['address']; ?></p>
					  </div>
					<? } ?>
					<? if($item_one['email']){ ?>
					  <div class="city-contact-item">
						<h4>e-mail</h4>
						<a href="mailto:<?= $item_one['email']; ?>"><?= $item_one['email']; ?></a>
					  </div>
					<? } ?>
					<? if($item_one['phone1']||$item_one['phone2']){ ?>
					  <div class="city-contact-item">
						<h4>телефон</h4>
						<? if($item_one['phone1']){ ?><a href="tel:<?= str_replace(array('-',' ','(',')',),'',$item_one['phone1']); ?>"><?= $item_one['phone1']; ?></a><? } ?>
						<? if($item_one['phone2']){ ?><a href="tel:<?= str_replace(array('-',' ','(',')',),'',$item_one['phone2']); ?>"><?= $item_one['phone2']; ?></a><? } ?>
					  </div>
					<? } ?>
					<div class="btn-tel" data-popup="call">Заказать звонок</div>
				</div>
				<? $parts=explode(",",$item_one['coords']); ?>
				<? if(!empty($parts[1])){ ?>
					<div class="city-contact-right">
					  <div class="map" data-lat="<?= $parts[0]; ?>" data-lon="<?= $parts[1]; ?>" data-hint="<?= $item_one['address']; ?>"></div>
					</div>
				<? } ?>
			  </div>
			</div>
        <? } ?>
      </div>
    </div>
</section>