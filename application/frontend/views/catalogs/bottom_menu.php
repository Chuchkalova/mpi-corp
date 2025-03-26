<?
	foreach($items as $item){
?>
	<li>
		<a href="<?= site_url("/catalog_group/show/{$item['url']}"); ?>"><?= $item['name']; ?></a>
	</li>
<?
	}
?>