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

  <section class="event-item">

    <div class="container">

      <div class="event-item-top">

        <div class="event-date-info">

          <div class="wrap-event-date-info">

            <div class="filter-product-info-top">

              <? if($parent['unit']){ ?><div class="filter-product-info-category"><span>#</span><?= $parent['unit']; ?></div><? } ?>

              <div class="filter-product-info-date"><?= format_date($item['date']); ?><? if($item['time']){ ?> | <?= $item['time']; ?><? } ?></div>

            </div>

            <? if($item['address']){ ?><div class="event-item-adress"><?= $item['address']; ?></div><? } ?>

          </div>

          <div class="register-btn" data-popup="application">Оставить заявку</div>

        </div>

        <div class="event-item-info">

          <?= $item['text2']; ?>

        </div>

      </div>

      <div class="event-item-text">

		<?= $item['text3']; ?>

      </div>

    </div>

  </section>

  <? if($item['text4']){ ?>

	  <section class="event-item-one">

		<div class="container">

		  <div class="event-item-one-side">

			<? if(get_image('articles','file2',$item['id'])!='/site_img/null.gif'){ ?>

				<img src="<?= get_image('articles','file2',$item['id']); ?>" alt="">

			<? } ?>

			<div class="event-item-one-side-info">

			  <?= $item['text4']; ?>

			</div>

			<a href="<?= $item['href']; ?>" class="filter-product-btn">Узнать подробнее</a>
      <!-- <a href="#" class="filter-product-btn" data-popup="edu-curs">Узнать подробнее</a> -->

		  </div>

		</div>

	  </section>

  <? } ?>

  <section class="drive">

    <div class="container">

      <?= $item['text']; ?>

      <a href="<?= site_url($parent['url']); ?>" class="go-back-btn">Вернуться назад</a>

    </div>

  </section>

  

  <div id="edu-curs" class="popup">

    <div class="popup-body">

      <div class="popup-content">

        <div class="popup-close">

          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">

            <path d="M9.66667 33.6667L7 31L17.6667 20.3333L7 9.66667L9.66667 7L20.3333 17.6667L31 7L33.6667 9.66667L23 20.3333L33.6667 31L31 33.6667L20.3333 23L9.66667 33.6667Z" fill="white" />

          </svg>

        </div>

        <h3>Записаться на курс</h3>

        <div class="wrap-edu-popup-name">

          <div class="edu-popup-name"><?= $item['name']; ?></div>

          <div class="edu-popup-time"><?= format_date($item['date']); ?><? if($item['time']){ ?> | <?= $item['time']; ?><? } ?></div>

           <? if($item['address']){ ?><div class="edu-popup-adress"><?= $item['address']; ?></div><? } ?>

        </div>

        <form action="#" method="POST" id="edu-curs-form" class='ajax-form'>

          <div class="wrap-input">

            <label>

              <input type="text" name="name" required>

              <span>Ваше имя</span>

            </label>

          </div>

          <div class="wrap-input">

            <input type="tel" name="phone" placeholder="+7 (9__) ___-__-__" required>

          </div>

          <div class="wrap-input">

            <label>

              <input type="email" name='email' required>

              <span>E-mail</span>

            </label>

          </div>

          <div class="wrap-input">

            <label>

              <input type="text" name='text'>

              <span>Напишите, что Вас интересует</span>

            </label>

          </div>

          <div class="wrap-check">

			<input type='hidden' name='articles_id' value='<?= $item['id']; ?>'>

            <button>Заказать звонок</button>

            <p>Нажимая на кнопку «Заказать звонок» Вы даете согласие на <a href="<?= site_url('politic'); ?>" target='_blank'>обработку персональных данных</a></p>

          </div>

        </form>

      </div>

    </div>

  </div>