<ul>
	<li><a href="<?= site_url('/'); ?>">Главная</a></li>
	<? 
		foreach($items as $ref=>$name){ 
			if($ref!='#'){
	?>
				<li><a href="<?= $ref; ?>"><?= $name; ?></a>
	<? 	
			}
			else{
	?>
				<li><a href="#"><?= $name; ?></a></li>
	<?
			}
		}
	?>
</ul>