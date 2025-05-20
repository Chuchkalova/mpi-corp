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

			<? if(count($item_one['level2'])){ ?>

				<div class="wrap-po-filter">

				  <a href='<?= site_url($item_one['url']); ?>'>Все</a>

				  <? foreach($item_one['level1'] as $item_one2){ ?>

					<a href='<?= site_url($item_one2['url']); ?>'><?= $item_one2['name'] ?></a>

				  <? } ?>

				</div>

			<? } ?>

			<? $data=count($item_one['level2'])?$item_one['level2']:$item_one['level1']; ?>

			<div class="wrap-po-item ssq1">

				<? foreach($data as $item_one2){ ?>
<!-- 					<pre>
					<?
print_r ($item_one2);
?>
</pre> -->
					<? if($item_one2['id']!= 153 && $item_one2['id'] != 55 && $item_one2['id'] != 146 && $item_one2['id'] != 290 && $item_one2['id'] != 65 && $item_one2['id'] != 56 && $item_one2['id'] != 201 && $item_one2['id'] != 199){ ?>

						<!-- <a href="<?= site_url($item_one2['url']); ?>" class="po-item blob-item"> -->
							<a href="https://mpi.ru.com/promyshlennoe_oborudovanie" id="<? $item_one2['id'] ?>" class="po-item aaq blob-item">
					<? }
					else
					{ ?>
						<!-- <a href="https://mpi.ru.com/promyshlennoe_oborudovanie" class="po-item blob-item"> -->
							<a href="<?= site_url($item_one2['url']); ?>" class="po-item blob-item">
						<!-- <div class="po-item blob-item"> -->

					<? } ?>

						<img src="<?= get_image('catalogs_group','file',$item_one2['id']); ?>" alt="">

						<?= $item_one2['short_text']; ?>

						<div class="blob"></div>

						<div class="fakeblob"></div>

					<? if($item_one['id']!=151){ ?>

						</a>

					<? }else{ ?>
						</a>
						<!-- </div> -->

					<? } ?>

				<? } ?>			  

			</div>

			<a href="<?= site_url($item_one['url']); ?>" class="po-link">Узнать подробнее</a>

		  </div>

	  <? } ?>   



	  <?/*div class="po-block">

		<div class="po-block-title">

		  <h2><span>#</span>По видам оборудования</h2>

		</div>

		<? if(count($types)){ ?>

			<div class="wrap-po-filter">

			  <a href='<?= site_url('types_all'); ?>'>Все</a>

			  <? foreach($types as $item_one2){ ?>

				<a href='<?= site_url($item_one2['url']); ?>'><?= $item_one2['name'] ?></a>

			  <? } ?>

			</div>

		<? } ?>

		<div class="wrap-po-item">

			<? foreach($types_groups as $item_one2){ ?>

			   <a href="<?= site_url($item_one2['url']); ?>" class="po-item blob-item">

				<img src="<?= get_image('catalogs_group','file',$item_one2['id']); ?>" alt="">

				<?= $item_one2['short_text']; ?>

				<div class="blob"></div>

				<div class="fakeblob"></div>

			  </a>

			<? } ?>			  

		</div>

		<a href="<?= site_url('types_all'); ?>" class="po-link">Узнать подробнее</a>

	  </div>

    </div*/?>

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

  