<div class="hits_wrapper">
	<? if($parametrs->name){ ?>
		<h3><?= $parametrs->name; ?></h3>
	<? } ?>
	<div class="hits_list clearfix">
		<? 
			$i=0;
			foreach($items as $item_one){ 
				++$i;
		?>
			<div class="hits_element clearfix <? if($i%$parametrs->in_string==0) echo "last"; ?>">
				<?= $item_one; ?>
			</div>
		<? 
				if($i%$parametrs->in_string==0) echo "<div class='clear'></div>";
			}
		?>
	</div>
</div>