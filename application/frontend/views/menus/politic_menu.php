<?

	foreach($items[0]['children'] as $item_one){

		$class=(current_url()==$item_one['url'])?"active":"";

?>

		<a href="<?= $item_one['url']; ?>" class="<?= $class; ?>"><?= $item_one['name']; ?></a>

<?

	}

?>