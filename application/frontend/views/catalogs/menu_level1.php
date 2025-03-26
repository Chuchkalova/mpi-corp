<ul class='list-unstyled'>
	<?
		$i=0;
		foreach($items as $item_one){
			++$i;
			$class=(current_url()==site_url("catalogs/show_group/{$item_one['url']}"))?"active":"";
	?>
			<li class='clearfix'><a href="<?= site_url("catalogs/show_group/{$item_one['url']}"); ?>" class="<?= $class; ?>"><?= $item_one['name']; ?><? if(isset($item_one['count'])){ ?> (<?= $item_one['count']; ?>)<? } ?></a></li>
	<?
		}
	?>
</ul>