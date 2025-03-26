<div class="catalog_show_all_wrapper content_block">
	<h1><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
		
	<? if(count($items)){ ?>
		<div class="catalog_show_group_list clearfix">
			<? 
				$i=0;
				foreach($items as $item_one){ 
					++$i;
			?>
				<div class="catalog_show_group_element_group clearfix <? if($i%$config['in_string']==0) echo "last"; ?>">
					<p class="image">
						<a href="<?= site_url("/catalog/show_group/{$item_one['url']}"); ?>" title="<?= $item_one['name']; ?>">
							<img alt="<?= $item_one['name']; ?>" src="<?= get_image('catalog_group', 'file', $item_one['id']); ?>" />
						</a>
					</p>
					<div class="name">
						<a href="<?= site_url("/catalog/show_one/{$item_one['url']}"); ?>" class="catalog_group_element_name"><?= $item_one['name']; ?></a>
					</div>
				</div>
			<? 
					if($i%$config['in_string']==0) echo "<div class='clear'></div>";
				}
			?>
		</div>
	<? } ?>
			
	<?= $item['text']; ?>
</div>


