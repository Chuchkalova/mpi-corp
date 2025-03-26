<div class="clearfix text_model_search">
	<? if($config['is_image']){ ?>
		<p class="image">
			<a href="<?= site_url("text_group/show_one/{$item_one['url']}"); ?>">
				<img alt="<?= $item_one['name']; ?>" src="<?= get_image('text', 'file', $item_one['id']); ?>"/>
			</a>
		</p>
	<? } ?>

	<p class="name">
		<a href="<?= site_url("text_group/show_one/{$item_one['url']}"); ?>">
			<?= $item_one['name']; ?>
		</a>
	</p>
	
	<? if($config['is_date']){ ?>
		<p class="date">
			<?= format_date($config['date_format'], $item_one['date']); ?>
		</p>
	<? } ?>
			
	<? if($config['is_short_text']){ ?>
		<div class="short_text"><?= $item_one['short_text']; ?></div>
	<? } ?>
	
	<? if($config['is_parent']){ ?>
		<div class="full_link">
			Размещено в рубрике: 
			<a href="<?= site_url("text_group/show/{$item_one['parent']['url']}"); ?>">
				<?= $item_one['parent']['name']; ?>
			</a>
		</div>
	<? } ?>
</div>