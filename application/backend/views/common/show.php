<h2><?= $title; ?></h2>

<? if($top_string){ ?>
	<?= $top_string; ?>
<? } ?>

<? if(count($refs)){ ?>
	<p>
		<? foreach($refs as $url=>$ref_name){ ?>
			<a href="<?= $url; ?>"><?= $ref_name; ?></a> /
		<? } ?>
	</p>
<? } ?>

<? if($add_buttons){ ?>
	<p><?= $add_buttons; ?></p>
<? } ?>

<? if(!count($th)&&$this->session->userdata('super_mode')){ ?>
		<p><a href='<?= site_url("/$controller/config/"); ?>'>Конфигурация</a></p>
<? } ?>

<? if($pager){ ?>
	<p class="pager">Страницы: <?= $pager; ?></p>
<? } ?>

<?
	if(count($th)){
?>
	<form action="<?= current_url(); ?>" method="post" accept-charset="utf-8" id="send_filter_tr" enctype="multipart/form-data">
		<table class='item_table'>
			<? 
				if(count($sort_trs)){ 
			?>
				<tr class='sort'>
					<? foreach($sort_trs as $td){ ?>
						<th align='center'>
							<? if(isset($td[0])&&$td[0]){ ?>
								<a href="<?= site_url("/$controller/set_order/{$td[0]}/{$td[2]}/$pid/"); ?>">
									<img src="/site_img/admin/sort_<?= $td[1]; ?>.jpg"/>
								</a>
							<? } ?>
						</th>
					<? } ?>
					<th id='search_full'>
						<? if($this->session->userdata('super_mode')){ ?>
							<a href='<?= site_url("/$controller/config/"); ?>'>Конфигурация</a>
						<? } ?>
					</th>
				</tr>
			<? } ?>
			
			<? 
				if(count($filter_table_trs)){ 
			?>
				<tr class='filter'>
					<? foreach($filter_table_trs as $td){ ?>
						<th align='center'>
							<?= $td; ?>
						</th>
					<? } ?>
					<th id='red_one'>
						<a href='<?= site_url("/$controller/clear_filters/$pid"); ?>'>Очистить</a>
					</th>
				</tr>
			<? } ?>
			
			<? 
				if(count($th)){ 
			?>
				<tr>
					<? foreach($th as $td){ ?>
						<th><?= $td; ?></th>
					<? } ?>
				</tr>
			<? } ?>
			
			<? 
				if(count($trs)){ 
					foreach($trs as $tr){ 
			?>
					<tr>
						<? 
							if(count($tr)){ 
								foreach($tr as $td){ 
									if(strpos($td,"<td")===false){
										
						?>
										<td><?= $td; ?></td>
						<? 
									}
									else{
						?>
										<?= $td; ?>
						<?
									}
								}
							}
						?>
					</tr>
			<? 	
					}
				} 
			?>
		</table>
		<p>
			<input type="submit" name="set_filter" value="Применить фильтры" style="height: 0px; width: 0px; border: none; padding: 0px;" hidefocus="true" id="filter_submit"  />
			<? if($submit_table){ ?>
				<?= form_submit(array('name'=>'update','id'=>'submit_update'), $submit_table); ?>
			<? } ?>
		</p>
	</form>
<? } ?>

<? if($pager){ ?>
	<p class="pager">Страницы: <?= $pager; ?></p>
<? } ?>