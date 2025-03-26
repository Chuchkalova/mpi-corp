<h1 class='gallerys-h1'><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
<? 
	$i=0;
	foreach($items as $item_one){ 
		if($i%4==0) echo "<div class='row'>";
		++$i;
?>
		<div class='col-sm-3'>
			<p>
				<a href="<?= site_url("gallerys/show_group/{$item_one['url']}"); ?>">
					<img alt="<?= $item_one['name']; ?>" src="<?= get_image('gallerys_group', 'file', $item_one['id'],320,240); ?>" class='img-responsive'/>
				</a>
			</p>
		</div>
<?
		if($i%4==0) echo "</div>";
	}
	if($i%4!=0) echo "</div>";
?>
<?= $item['text']; ?>