<div class='text-center col-xs-2 pb10 pt10'>
	<div class='image-container'><div><img src='<?= $image['image'] ?>'></div></div>
	<p class='mb0'>
		<?= form_input(array(
		   'name'        => "image[{$image['id']}]",
		   'class'		 => 'form-control',
		   'value' 		 => $image['name'],
		   'style'		 => 'width:100%',
		));
		?>
	</p>
	<p><a class='delete_image' href='<?= $del_url; ?>'>Удалить</a></p>
</div>