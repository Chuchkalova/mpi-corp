<h1><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
<? 
	$i=0;
	foreach($items as $item_one){ 
		++$i;
?>			
		<?= $item_one; ?>
<? 
	}
	
	if(!count($items)){
?>
		<p>По вашему запросу ничего не найдено</p>
<?
	}
?>
<?= $item['text']; ?>
