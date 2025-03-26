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
<section class="curs-top">
  <div class="container">
    <div class="curs-top-side">
      <div class="curs-top-img">
        <img src="<?= get_image('educations','file',$item['id']); ?>" alt="">
      </div>
      <div class="curs-top-info">
        <div class="wrap-curs-top-info">
          <div class="curs-top-info-price">
            от<span><?= number_format($item['price'],0,'.',' '); ?> </span>₽
          </div>
		  <? if($item['hours']){ ?>
			<div class="curs-top-info-time"><?= $item['hours']; ?> <?
					if($item['hours']%10==1&&$item['hours']%100!=11){
						echo 'академический час';
					}
					else if(($item['hours']%10==2||$item['hours']%10==3||$item['hours']%10==4)&&$item['hours']%100!=12&&$item['hours']%100!=13&&$item['hours']%100!=14){
						echo 'академических часа';
					}
					else{
						echo 'академических часов';
					}
				?>
				<? if($item['days']){ ?>
					| <?= $item['days']; ?> <?
						if($item['days']%10==1&&$item['days']%100!=11){
							echo 'день';
						}
						else if(($item['days']%10==2||$item['days']%10==3||$item['days']%10==4)&&$item['days']%100!=12&&$item['days']%100!=13&&$item['days']%100!=14){
							echo 'дня';
						}
						else{
							echo 'дней';
						}
					?>				
				<? } ?>
			</div>
		  <? } ?>
        </div>
        <div class="curs-top-info-table">
         <?= $item['text2'] ?>
        </div>
      </div>
      <div class="curs-top-btn">
        <div class="wrap-sign-btn">
          <a href="#" data-popup="edu-curs">Записаться на курс</a>
        </div>
		<? if(get_file('educations','file2',$item['id'])){ ?>
			<div class="wrap-download-btn">
			  <a href="<?= get_file('educations','file2',$item['id']); ?>" download>Скачать программу</a>
			</div>
		<? } ?>
      </div>
    </div>
  </div>
</section>
<? if($item['text']){ ?>
	<section class="about-curs">
	  <div class="container">
		<h2>О курсе</h2>
		<?= $item['text']; ?>
	  </div>
	</section>
<? } ?>
<? if(count($programs)){ ?>
	<section class="program-curs">
	  <div class="container">
		<h2>Программа курса</h2>
		<? foreach($programs as $item_one){ ?>
			<div class="service-accordion-item">
			  <p class="service-accordion-item-title"><?= $item_one['name'] ?></p>
			  <div class="service-accordion-content">
				<div class="service-accordion-item-content">
				  <?= $item_one['text'] ?>
				  <div class="acc-time">
					<?= $item_one['hours'] ?>
				  </div>
				</div>
			  </div>
			</div>
		<? } ?>
	  </div>
	</section>
<? } ?>
<? if(count($gallerys)){ ?>
	<section class="gallery-curs">
	  <div class="container">
		<h2>Галерея курса</h2>
		  <div class="wrap-gallery-curs-item">
			<? foreach($gallerys as $item_one){ ?>
				<a class="fancybox" href="" data-fancybox="gal" data-src="<?= get_image('gallerys','file',$item_one['id']); ?>">
				  <img src="<?= get_image('gallerys','file',$item_one['id'],360,250,'crop'); ?>" alt="">
				</a>
			<? } ?>
		  </div>
		</div>
	</section>
<? } ?>
<? if(count($similars)){ ?>
	<section class="similar">
	  <div class="container">
		<h2>Похожие курсы</h2>
		<div class="similar-slider">
			<? foreach($similars as $item_one){ ?>
			  <div class="similar-slide">
				<img src="<?= get_image('educations','file',$item_one['id']); ?>" alt="">
				<a href="<?= site_url($item_one['url']); ?>"><?= $item_one['name'] ?></a>
				<?= $item_one['short_text'] ?>
				<div class="wrap-developer-item-price">
				  <div class="developer-item-price">от <span><?= number_format($item_one['price'],0,'.',' '); ?></span> ₽</div>
				  <div class="developer-item-time">
					<? if($item_one['hours']){ ?>
						<div class="left-time"><span><?= $item_one['hours']; ?></span>ак.<?
							if($item_one['hours']%10==1&&$item_one['hours']%100!=11){
								echo 'час';
							}
							else if(($item_one['hours']%10==2||$item_one['hours']%10==3||$item_one['hours']%10==4)&&$item_one['hours']%100!=12&&$item_one['hours']%100!=13&&$item_one['hours']%100!=14){
								echo 'часа';
							}
							else{
								echo 'часов';
							}
						?></div>
						<div class="line-time"></div>
					<? } ?>
					<? if($item_one['days']){ ?>
						<div class="right-time"><span><?= $item_one['days']; ?></span><?
							if($item_one['days']%10==1&&$item_one['days']%100!=11){
								echo 'день';
							}
							else if(($item_one['days']%10==2||$item_one['days']%10==3||$item_one['days']%10==4)&&$item_one['days']%100!=12&&$item_one['days']%100!=13&&$item_one['days']%100!=14){
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
			<? } ?>
		</div>
	  </div>
	</section>
<? } ?>
  
  <div id="edu-curs" class="popup">
    <div class="popup-body">
      <div class="popup-content">
        <div class="popup-close">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />
          </svg>
        </div>
        <h3>Записаться на курс</h3>
        
        <form action="#" method="POST" id="edu-curs-form" class='form-ajax'>
		  <div class="wrap-edu-popup-name">
			  <div class="edu-popup-name"><?= $item['name']; ?></div>
			  <div class="edu-popup-price">от <?= number_format($item['price'],0,'.',' '); ?> ₽</div>
			  <? if($item['hours']){ ?>
				<div class="edu-popup-time"><?= $item['hours']; ?> <?
						if($item['hours']%10==1&&$item['hours']%100!=11){
							echo 'академический час';
						}
						else if(($item['hours']%10==2||$item['hours']%10==3||$item['hours']%10==4)&&$item['hours']%100!=12&&$item['hours']%100!=13&&$item['hours']%100!=14){
							echo 'академических часа';
						}
						else{
							echo 'академических часов';
						}
					?>
					<? if($item['days']){ ?>
						| <?= $item['days']; ?> <?
							if($item['days']%10==1&&$item['days']%100!=11){
								echo 'день';
							}
							else if(($item['days']%10==2||$item['days']%10==3||$item['days']%10==4)&&$item['days']%100!=12&&$item['days']%100!=13&&$item['days']%100!=14){
								echo 'дня';
							}
							else{
								echo 'дней';
							}
						?>				
					<? } ?>
			    </div>
			  <? } ?>
			  <input type='hidden' name='educations_id' value='<?= $item['id'] ?>'>
			  <input type='hidden' name='type' value='Запись на курс'>
			  
		  </div>
          <div class="wrap-input">
            <label>
              <input type="text" name="name">
              <span>Ваше имя</span>
            </label>
          </div>
          <div class="wrap-input">
            <input type="tel" name="phone" placeholder="+7 (9__) ___-__-__" required>
          </div>
          <div class="wrap-input">
            <label>
              <input type="email" name='email'>
              <span>example@site.ru</span>
            </label>
          </div>
          <div class="wrap-input">
            <label>
              <input type="text" name='text'>
              <span>Напишите, что Вас интересует</span>
            </label>
          </div>
          <div class="wrap-check">
            <button>Заказать звонок</button>
            <p>Нажимая на кнопку «Заказать звонок» Вы даете согласие на <a href="<?= site_url('politic'); ?>" target='_blank'>обработку персональных данных</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="edu-thx" class="popup">
    <div class="popup-body">
      <div class="popup-content">
        <div class="popup-close">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />
          </svg>
        </div>
        <h3>Спасибо!</h3>
        <p><span>Спасибо! Ваш заказ успешно оформлен.</span></p>
        <p>В ближайшее время с Вами свяжется наш специалист для уточнения деталей и дальнейшего оформления заказа.</p>
        <p>Данные по заказу мы отправили на указанный Вами e-mail адрес</p>
        <a href="<?= site_url('/'); ?>" class="popup-back-close-btn">Перейти на главную</a>
      </div>
    </div>
  </div>