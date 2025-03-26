<?

	foreach($items[0]['children'] as $item_one){

?>

		<div class="gamb-col-item">

			<h5><a href="<?= $item_one['url']; ?>"><?= $item_one['name']; ?></a></h5>

			<? if(count($item_one['children'])){ ?>

				<div class="wrap-gamb-col-link">

					<? 

						foreach($item_one['children'] as $item_one2){ 

					?>

						<a href="<?= $item_one2['url']; ?>"><?= $item_one2['name']; ?></a>

					<? } ?>

				 </div>

			<? } ?>

		 </div>

<?

	}

?>