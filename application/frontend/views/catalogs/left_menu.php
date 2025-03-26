<ul class="products_category_menu">
	<?
		$classes=array(
			242=>'home_flowers',
			18=>'flowers',
			21=>'balloons',
		);
		$i=0;
		foreach($items as $item){
			++$i;
	?>
		<li>
			<a href="<?= site_url("/catalog_group/show/{$item['url']}"); ?>" <? if(in_array($item['id'], $path_to_top)) echo "class='active'"; ?>>
				<span class="<? if(isset($classes[$item['id']])) echo "{$classes[$item['id']]}"; ?> span_<?= ($i%6==0)?6:$i%6; ?>"><?= $item['name'] ?></span>
			</a>
			<? if(isset($item['subitems'])&&count($item['subitems'])){ ?>
				<ul>
					<? foreach($item['subitems'] as $subitem){ ?>
						<li>
							<a href="<?= site_url("/catalog_group/show/{$subitem['url']}"); ?>" <? if(in_array($subitem['id'], $path_to_top)) echo "class='active'"; ?>>
								<?= $subitem['name'] ?>
							</a>
						</li>
					<? } ?>
				</ul>
			<? } ?>
		</li>
	<?
		}
	?>
</ul>