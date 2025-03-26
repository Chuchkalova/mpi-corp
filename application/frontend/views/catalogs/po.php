<section class="second-page second-template">

    <div class="container">

      <div class="second-side">

        <div class="second-side-left">

          <div class="breadcrumb">

			<?= $breads; ?>

          </div>

          <div class="second-tags">

			<? foreach($items as $item_one){ ?>

				<a href="<?= site_url($item_one['url']); ?>"><span>#</span> <?= $item_one['name'] ?></a>

			<? } ?>

          </div>

        </div>

        <div class="second-side-right">

          <h1><?= $item['h1']?$item['h1']:$item['name']; ?></h1>

          <?= $item['short_text']; ?>

        </div>

      </div>

    </div>

  </section>

  <section class="po">

    <div class="container">

	  <? foreach($items as $item_one){ ?>

		  <div class="po-block">

			<div class="po-block-title">

			  <h2><span>#</span><?= $item_one['name']; ?></h2>

			  <?= $item_one['short_text']; ?> 

			</div>

			<div class="wrap-po-item">

				<? foreach($item_one['items'] as $item_one2){ ?>
					<!--           <pre>
<?
print_r ($item_one['items']);
?>
</pre> -->
<!--<?
print_r ($item_one['id']);
?>
</pre> -->
<!--           <pre>
<?
print_r ($item_one2);
?>
</pre> -->
				   <a href="<?= site_url($item_one2['url']); ?>" class="po-item blob-item">

					<img src="<?= get_image('catalogs_group','file',$item_one2['id']); ?>" alt="">

					<?= $item_one2['short_text']; ?>

					<div class="blob"></div>

					<div class="fakeblob"></div>

				  </a>

				<? } ?>			  

			</div>

			<a href="<?= site_url($item_one['url']); ?>" class="po-link">Узнать подробнее</a>

		  </div>

	  <? } ?>      

    </div>

  </section>

  <section class="about-po">

    <img src="/imgs/po-bg.png" alt="" class="about-po-img">

    <div class="container">

      <?= $item['text'] ?>

      <div class="wrap-about-po-item">

		<? 	foreach($texts['items'] as $item_one3){ ?>

			<div class="about-po-item">

			  <span><?= $item_one3['name']; ?></span>

			  <?= $item_one3['text']; ?>

			</div>

        <?

			}

		?>

      </div>

    </div>

  </section>

  