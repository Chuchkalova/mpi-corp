<nav>

  <ul>

	<?

		foreach($items[0]['children'] as $item_one){ 

	?>

		<li <?= count($item_one['children'])?'class="parent"':''; ?>>

		  <a href="<?= $item_one['url']; ?>"><?= $item_one['name']; ?></a>

		  <? if(count($item_one['children'])){ ?>

			<div class="wrap-parent-list">

				<ul>

					<? foreach($item_one['children'] as $item_one2){  ?>

						<li><a href="<?= $item_one2['url']; ?>"><?= $item_one2['name']; ?></a></li>

					<? } ?>

				</ul>

			</div>

		  <? } ?>

		</li>

	<?

		}

	?>

  </ul>

</nav>