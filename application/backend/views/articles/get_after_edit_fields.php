<? if(isset($groups_new_set)){ ?>
	<br/>
	<h2>Дополнительные категории</h2>
	<? foreach($groups_set as $group_one){ ?>
		<p>
			<a href="<?= site_url("{$controller}/edit_group/{$group_one['id']}"); ?>"><?= $group_one['name'] ?></a> - 
			<a href="<?= site_url("{$controller}/delete_extra/{$group_one['id']}/$item_id"); ?>">Удалить</a>
		</p>
	<? } ?>
	<p>
		<b>Добавить</b>
		<?= form_dropdown("add_extra", $groups_new_set, 0, "id='add_group'"); ?>
	</p>
<? } ?>