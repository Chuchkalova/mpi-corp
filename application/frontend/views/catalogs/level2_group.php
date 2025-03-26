<div class="block level2_group_wrapper">
	<? if($parametrs->name){ ?>
		<h3><?= $parametrs->name; ?></h3>
	<? } ?>
	<?
		$j=0;
		foreach($items as $item_one){
			$class=(current_url()==site_url("catalog/show_group/{$item_one['url']}"))?"active":"";
	?>	
			<div class="list level2_level1_group_wrapper">
				<h4><a href="<?= site_url("catalog/show_group/{$item_one['url']}"); ?>" class="<?= $class; ?>"><?= $item_one['name']; ?></a></h4>
				<? if(isset($item_one['subitems'])&&is_array($item_one['subitems'])){ ?>
					<ul class="<?= $class; ?>">
					<?
						$i=0;
						foreach($item_one['subitems'] as $item_one2){
							++$i;
							$class=(current_url()==site_url("catalog/show_group/{$item_one2['url']}"))?"active":"";
					?>
							<li><a href="<?= site_url("catalog/show_group/{$item_one2['url']}"); ?>" class="<?= $class; ?>"><?= $item_one2['name']; ?></a></li>
					<?
						}
					?>
					</ul>
				<? } ?>
			</div>
	<?
		}
	?>
</div>