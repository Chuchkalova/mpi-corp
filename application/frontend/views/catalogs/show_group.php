<div class='page'>
	<div class="right-content" style='margin-top:3px;'>
		<div class="mt30 content">
			<h1 class='line'><?= (isset($item['h1'])&&$item['h1'])?$item['h1']:$item['name']; ?></h1>
			<div class="text">
				<? if(count($items)){ ?>
					<div class="catalog_show_group_list clearfix">
						<? 
							$i=0;
							foreach($items as $item_one){ 
								++$i;
								echo $item_one;
							}
						?>
					</div>
				<? } ?>
				
				<? if($pager){ ?>
					<div class="pager">
						<?= $pager; ?>
					</div>
				<? } ?>
				
				<div class='pt10'>
					<?= $item['text']; ?>
				</div>
			</div>
		</div>
	</div>
</div>

