<h4 class='line'><?=$name; ?></h4>
<ul class='list-unstyled'>
<? foreach($items as $item_one){ ?>
	<li>
		<a href='<?= $item_one['url']; ?>' class="<?= (current_url()==$item_one['url'])?"active":""; ?>"><?= $item_one['name']; ?></a>
		<? if(count($item_one['children'])){ ?>
			<div class='popup-menu'>
				<ul class="list-unstyled">
					<? foreach($item_one['children'] as $item_one2){ ?>
						<li>
							<a href='<?= $item_one2['url']; ?>' class="<?= (current_url()==$item_one2['url'])?"active":""; ?>"><?= $item_one2['name']; ?></a>
						</li>
					<? } ?>
				</ul>
			</div>
		<? } ?>
	</li>
<? } ?>