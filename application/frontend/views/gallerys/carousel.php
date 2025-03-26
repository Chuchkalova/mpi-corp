<ul class='bxslider_<?= $parent['id'] ?>'>
	<? 
		$i=0;
		foreach($items as $item_one){ 
			++$i;
	?>
			<li>
				<a href="<?= get_image('gallerys', 'file', $item_one['id']); ?>" class="zoom" rel="g<?= $parent['id']; ?>">
					<img alt="<?= $item_one['name']; ?>" src="<?= get_image('gallerys', 'file', $item_one['id'],320,240); ?>" class='img-responsive'/>
				</a>
			</li>
	<?
		}
	?>
</ul>
<script>
	$(document).ready(function(){
		$('.bxslider_<?= $parent['id'] ?>').bxSlider({
			minSlides: <?= $count ?>,
			maxSlides: <?= $count ?>,
			moveSlides: 1,
			slideMargin: 30,
			pager: false
		});
	});
</script>