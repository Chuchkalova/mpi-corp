<style>
	.small input[type="text"]{
		width:98%;
	}
</style>
<br/>
<h2>Программа курса</h2>
<table class="item_table">
	<tr>
		<th>Наименование</th>
		<th>Порядок</th>
		<th>Действия</th>
	</tr>
<? 
	foreach($programs as $item_one){ 
?>
	<tr>
		<td class="small"><?= form_input("programs[{$item_one['id']}][name]",$item_one['name']); ?></td>
		<td class="small"><?= form_input("programs[{$item_one['id']}][order]",$item_one['order']); ?></td>
		<td style="text-align:center;">
			<a href="<?= site_url("programs/edit/{$item_one['id']}"); ?>">Редактировать</a><br>
			<a href="<?= site_url("programs/delete/{$item_one['id']}"); ?>" onclick='return confirm("Вы уверены?")'>Удалить</a>
		</td>
	</tr>
<? } ?>
</table>
<p>
	<a href="<?= site_url("programs/add/{$item_id}"); ?>"><b>Добавить элемент программы</b></a>
</p>