<?
	$i=0;
	foreach($items[0]['children'] as $item_one){ 
		++$i;
?>
		<div class="<?= $i==1?"resolution":"education"; ?>-col fade-block">
			<h5><?= $item_one['name']; ?></h5>
			<? if(!empty($item_one['children'])){ ?>
				<div class="wrap-fade-block">
					<? foreach($item_one['children'] as $item_one2){  ?>						
						<? if(!empty($item_one2['children'])){ ?>
							<p><a href="<?= $item_one2['url']; ?>"><?= $item_one2['name']; ?></a></p>
							<? foreach($item_one2['children'] as $item_one3){  ?>
								<a href="<?= $item_one3['url']; ?>"><?= $item_one3['name']; ?></a>
							<? } ?>
						<? }else{ ?>
							<a href="<?= $item_one2['url']; ?>"><?= $item_one2['name']; ?></a>
						<? } ?>
					<? } ?>
				</div>
			<? } ?>
		</div>
<?
	}
?>