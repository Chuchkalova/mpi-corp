<h1 class='articles-h1'><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
<div class='articles-text'>
	<? foreach($groups as $item_one){ ?>
		<div class='row'>
			<div class='col-sm-4'>
				<a href='<?= site_url("articles/show_group/{$item_one['url']}"); ?>'><img src='<?= get_image("articles_group","file",$item_one['id'],320,240); ?>' class='img-responsive'></a>
			</div>
			<div class='col-sm-8'>
				<p><a href='<?= site_url("articles/show_group/{$item_one['url']}"); ?>'><?= $item_one['name']; ?></a></p>
				<div class='articles-short-text'>
					<?= $item_one['short_text']; ?>
				</div>
			</div>
		</div>
	<? } ?>
</div>