<div class="clearfix multy_gallery">
	<div class="item_table row" data-id="<?= $gallery_id; ?>">
		<?
		if(count($items)){
			foreach($items as $item_one){
				$del_url=site_url("gallerys/delete/{$item_one['id']}/".base64_encode($item_one['image']));
		?>
				<div class='text-center col-xs-2 pb10 pt10'>
					<div class='image-container'><div><img src='<?= $item_one['image'] ?>'></div></div>
					<p class='mb0'>
						<?= form_input(array(
							   'name'        => "image[{$item_one['id']}]",
							   'class'		 => 'form-control',
							   'value' 		 => $item_one['name'],
							   'style'		 => 'width:100%',
							));
						?>
					</p>
					<p><a class='delete_image' href='<?= $del_url; ?>'>Удалить</a></p>
				</div>
		<?
			}
		}
		?>
	</div>
</div>
		
<span class="btn btn-success fileinput-button">
	<i class="glyphicon glyphicon-plus"></i>
	<span>Выбрать файлы...</span>
	<input class="fileupload" type="file" name="files[]" multiple data-id="<?= $gallery_id; ?>">
</span>
<br/><br/>
<div class="progress progress_<?= $gallery_id; ?>">
	<div class="progress-bar progress-bar-success"></div>
</div>

<div id="files" class="files"></div>