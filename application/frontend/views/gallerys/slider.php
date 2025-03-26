<ul class='bxslider_<?= $parent['id'] ?>'>
	<? 
		$i=0;
		foreach($items as $item_one){ 
			++$i;
	?>
			<li>
				<a href="<?= $item_one['href']; ?>">
					<img alt="<?= $item_one['name']; ?>" src="<?= get_image('gallerys', 'file', $item_one['id']); ?>" class='img-responsive'/>
				</a>
			</li>
	<?
		}
	?>
</ul>
<script>
	$(document).ready(function(){
		$('.bxslider_<?= $parent['id'] ?>').bxSlider({
		});
	});
</script>