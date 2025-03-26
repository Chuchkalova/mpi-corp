<div class="articles-short">
	<h3>Статьи</h3>
	<? foreach($items as $item_one){ ?>
		<div class="row">
			<? if($parametrs->is_image){ ?>
				<div class="col-sm-4">
					<a href="<?= site_url("articles/show/{$item_one['url']}"); ?>"><img src="<?= get_image("articles","file",$item_one['id']); ?>" class='img-responsive'></a>
				</div>
			<? } ?>
			<div class="col-sm-8">
				<p><a href="<?= site_url("articles/show/{$item_one['url']}"); ?>" class="title"><?= $item_one['name']; ?></a></p>
				<? if($parametrs->is_date){ ?>
					<p class="date"><?= date("d.m.Y", strtotime($item_one['date'])); ?></p>
				<? } ?>
				<?= $item_one['short_text']; ?>
			</div>
		</div>
	<? } ?>
	
	<? if($parametrs->is_all){ ?>
		<div class="articles-short-all">
			<p><a href="<?= site_url("articles/show_all"); ?>" class="title">Все новости</a></p>
		</div>
	<? } ?>
</div>