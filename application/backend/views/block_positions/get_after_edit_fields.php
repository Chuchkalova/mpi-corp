<h2>Парметры</h2>
<?
	foreach($parametrs as $name=>$data){
?>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?= $data['name']; ?></label>
			<div class="col-sm-10">
				<?
					if($data['type']=="checkbox"){
						$value=false;
						if(isset($item->$name)){
							$value=$item->$name;
						}
						echo form_checkbox("parametrs[{$name}]",'', $value);
					}
					else if($data['type']=="select"){
						$value=0;
						if(isset($item->$name)){
							$value=$item->$name;
						}
						echo form_dropdown("parametrs[{$name}]", $data['values'], $value, "class='form-control' ");
					}
					else{
						$value="";
						if(isset($item->$name)){
							$value=$item->$name;
						}
						
						echo form_input(array(
						   'name'        => "parametrs[{$name}]",
						   'maxlength'   => '100',
						   'class'		 => 'form-control',
						   'value' 		 => $value,
						));
					}
				?>
			</div>
		</div>
<? } ?>