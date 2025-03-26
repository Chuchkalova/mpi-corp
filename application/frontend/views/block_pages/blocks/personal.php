<section class="about-developer-slider">

    <div class="container">

      <h2><?= $item['name'] ?></h2>

      <div class="about-slider about-slider-desctop">

		<? foreach($items as $item_one){ ?>

			<div class="about-slide">

			  <img src="<?= get_image('block_pages','file',$item_one['id']); ?>" alt="">

				<h6><?= $item_one['name'] ?></h6>

				<?= $item_one['text'] ?>

			</div>

		<? } ?>

      </div>
      <div class="about-slider about-slider-mobile">

		<? foreach($items as $item_one){ ?>

			<div class="about-slide">

			  <img src="<?= get_image('block_pages','file',$item_one['id']); ?>" alt="">

				<h6><?= $item_one['name'] ?></h6>

				<?= $item_one['text'] ?>

			</div>

		<? } ?>

      </div>
    </div>

  </section>