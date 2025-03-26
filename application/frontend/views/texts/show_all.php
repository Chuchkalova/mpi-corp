<h1><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>

<div class="list text_group">
	<? 
		$i=0;
		foreach($items as $item_one){ 
			++$i;
	?>
			<? if($config['is_image']){ ?>
				<p>
					<a href="<?= site_url("text_group/show/{$item_one['url']}"); ?>">
						<img alt="<?= $item_one['name']; ?>" src="<?= get_image('text_group', 'file', $item_one['id']); ?>"/>
					</a>
				</p>
			<? } ?>
			
			<? if($config['is_date']){ ?>
				<p class="date">
					<?= date("d.m.Y", strtotime($item_one['date'])); ?>
				</p>
			<? } ?>
			
			<p class="name">
				<a href="<?= site_url("text_group/show/{$item_one['url']}"); ?>">
					<?= $item_one['name']; ?>
				</a>
			</p>
			
			<? if($config['is_short_text']){ ?>
				<div class="short_text"><?= $item_one['short_text']; ?></div>
			<? } ?>
	<? 
			if($i%$config['count_in_string']==0){
	?>
				<div class="clear"></div>
	<?
			}
		}
	?>
	
	<? if($pager){ ?>
		<div class="pager">
			<?= $pager; ?>
		</div>
	<? } ?>
	
	<?= $item['text']; ?>
</div>