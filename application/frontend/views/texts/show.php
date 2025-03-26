<div class='page'>
	<div class="right-content">
		<div class="menu2">
			<ul class="list-inline text-uppercase clearfix fs13">
				<? foreach($menu1 as $item_one){ ?>
					<li><a href='<?= site_url("texts/show/{$item_one['url']}"); ?>'><?= $item_one['name']; ?></a></li> 
				<? } ?>
			</ul>
		</div>
		<div class="mt15 content">
			<h1 class='line'><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
			<div class="text">
				<?= $item['text']; ?>
			</div>
		</div>
	</div>
</div>