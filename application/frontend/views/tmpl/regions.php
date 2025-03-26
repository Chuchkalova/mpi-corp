<div class="container">
	<div class='row'>
<?
	$letter="";
	$new_regions=array(array(),array(),array(),array());
	$count=ceil(count($regions)/4);
	$j=0;
	$i=0;
	foreach($regions as $region=>$rus){
		if(mb_substr($rus,0,1)!=$letter){
			if($i>=$count*($j+1)){
				++$j;
			}
			$letter=mb_substr($rus,0,1);
			$new_regions[$j][]=array(
				'ref'=>'',
				'rus'=>'',
				'letter'=>$letter,
			);
		}
		$new_regions[$j][]=array(
			'ref'=>$region,
			'rus'=>$rus,
			'letter'=>'',
		);
		++$i;
	}

	for($j=0;$j<4;++$j){
		echo '<div class="col-xs-3">';
		foreach($new_regions[$j] as $region_one){
			if(!$region_one['letter']){
?>
				<p class='mb0'><a href="/<?= $region_one['ref']; ?>"><?= $region_one['rus']; ?></a></p>
<?
			}
			else{
?>
				<p class='mb0 pt10'><b><?= $region_one['letter']; ?></b></p>
<?
			}
		}
		echo '</div>';
	}
?>
	</div>
</div>