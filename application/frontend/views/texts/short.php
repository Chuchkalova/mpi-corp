<div class="list text_short">
	<? if(isset($item['name'])){ ?>
		<h3><?= $item['name']; ?></h3>
	<? } ?>
	<? foreach($items as $item_one){ ?>
		<div class="list_one clearfix">
			<? if($parametrs->is_image){ ?>
				<div class="image ileft">
					<a href="<?= site_url("text_group/show_one/{$item_one['url']}"); ?>"><img src="<?= get_image("news","file",$item_one['id']); ?>"></a>
				</div>
			<? } ?>
			<div class="text ileft">
				<p><a href="<?= site_url("text_group/show_one//{$item_one['url']}"); ?>" class="title"><?= $item_one['name']; ?></a></p>
				<? if($parametrs->is_date){ ?>
					<p class="date"><?= format_date($parametrs->date_format, $item_one['date']); ?></p>
				<? } ?>
				<?= $item_one['short_text']; ?>
				<? if($parametrs->full_link){ ?>
					<div class="full_link">
						<a href="<?= site_url("text_group/show_one/{$item_one['url']}"); ?>"><?= $parametrs->full_link; ?></a>
					</div>
				<? } ?>
			</div>
		</div>
	<? } ?>
</div>