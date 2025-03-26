<h1 class='articles-h1'><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
<div class='articles-text'>
	<? foreach($items as $item_one){ ?>
		<div class='row'>
			<div class='col-sm-4'>
				<a href='<?= site_url("articles/show/{$item_one['url']}"); ?>'><img src='<?= get_image("articles","file",$item_one['id'],320,240); ?>' class='img-responsive'></a>
			</div>
			<div class='col-sm-8'>
				<p><a href='<?= site_url("articles/show/{$item_one['url']}"); ?>'><?= $item_one['name']; ?></a></p>
				<p class='fs13'><?= date("d.m.Y",strtotime($item_one['date'])); ?></p>
				<div class='articles-short-text'>
					<?= $item_one['short_text']; ?>
				</div>
			</div>
		</div>
	<? } ?>
</div>
	
<? if($pager){ ?>
	<div class="pager">
		<?= $pager; ?>
	</div>
<? } ?>

<? if($page_num==1){ ?>
	<?= $item['text']; ?>
<? } ?>