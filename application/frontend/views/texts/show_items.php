<h1 class='line'><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
<? if(trim(strip_tags($item['block_text']))){ ?>
	<div class='block'>
		<?= $item['block_text']; ?>
		<p><a href="#popup1" class="fancybox btn btn-brown fs13">Заказать звонок</a></p>
	</div>
<? } ?>
	
<?= $item['short_text']; ?>
<?= $item['gallery']; ?>
<?= $item['text']; ?>