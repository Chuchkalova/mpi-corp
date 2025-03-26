<div class='row'>
	<div class='col-xs-6'>
		<? if(count($this->regions)>1){ ?>
			<form action="<?= site_url("settings/set_region") ?>" method="post" class='form-horizontal'>
				<select name="regions" class='form-control pull-left'>
					<? foreach($this->regions as $region_id=>$region_name){ ?>
						<option value="<?= $region_id; ?>" <? if($this->session->userdata('region')==$region_id) echo "selected='selected'"; ?>><?= $region_name; ?></option>
					<? } ?>
				</select>
				<input type="submit" value="Ок" class='pull-left'>
			</form>
		<? } ?>
	</div>
	<div class='col-xs-6'>
		<p class='text-right'>&copy;2012-<?= date('Y'); ?></p>
	</div>
</div>