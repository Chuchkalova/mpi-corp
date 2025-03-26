<h2>Права</h2>
<?
	$i=0;
	foreach($permission_set as $block){
		if($i%2==0) echo "<div class='row'>";
		++$i;
?>	
		<div class='col-sm-6'>
			<h3><b><?= $block['name']; ?></b></h3>
			<? foreach($block['trs'] as $tr){ ?>
				
				<div class='clearfix'>
					<label class='control-label2'><?= $tr['name']; ?></label>
					<? foreach($tr['fields'] as $td){ ?>
						<label class="radio-inline">
							<?= $td['value']; ?>
							<?= $td['name']; ?>
						</label>
					<? } ?>
				</div>
			<? } ?>
			<br/>
		</div>
<? 
		if($i%2==0) echo "</div>";
	}
	if($i%2!=0) echo "</div>";
?>

<script>
	$(document).ready(function() {	
		if(window.location.href.indexOf("/add") > -1){
			$('#form_add').submit(function() {
				if($('#password').val()==''){
					$('#error').html('Не заполнено поле Пароль');
					return false;
				}
				if($('#password').val()!=$('#password2').val()){
					$('#error').html('Поля с паролями не совпадают');
					return false;
				}
				return true;
			});
		}
	});
</script>