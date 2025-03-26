<h2>Модули</h2>
<ul class="plugins">
<? foreach($top_refs as $ref=>$ref_name){?>
		<li><img src="/css/images/marker.png"><a href='<?= site_url($ref); ?>'><?= $ref_name; ?></a></li>
<? } ?>
</ul>