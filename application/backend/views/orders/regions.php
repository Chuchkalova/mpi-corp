<div class="regions clearfix">
	<h2>Распространить по регионам:</h2>
	<p><a href="#" class="invert">Инвертировать выбор</a></p>

	<?
	foreach($regions as $region_id=>$region_name){
		if($this->session->userdata('region')==$region_id) continue;
	?>
		<div><label><input type="checkbox" name="regions[<?= $region_id; ?>]"> <?= $region_name; ?></label></div>
	<? } ?>
</div>
<br>