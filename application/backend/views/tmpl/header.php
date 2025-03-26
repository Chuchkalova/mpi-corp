<? 
	if($this->session->userdata('super_mode')){
?>
		<div align="left" class="adm-left-nav-wrap">
			<div class="adm-left-nav-body">
				<div class="adm-opn-cls">
					<div class="adm-left-nav-name">
						<a href='<?= site_url("configurator"); ?>'>Конфигуратор</a>
					</div>
				</div>
			</div>
		</div>
<?		
	}
	foreach($top_refs as $modules){
		if(count($modules['level2'])){
?>
			<div align="left" class="adm-left-title"><?= $modules['name']; ?></div>
			<? foreach($modules['level2'] as $module_ref=>$module_name){ ?>
				<div align="left" class="adm-left-nav-wrap">
					<div class="adm-left-nav-body">
						<div class="adm-opn-cls">
							<div class="adm-left-nav-name">
								
									<a href="<?= site_url($module_ref); ?>"><?= $module_name; ?></a>
								
							</div>
						</div>
					</div>
				</div>
			<? } ?>
<?
		}
	}
?>
<div align="left" class="adm-left-nav-wrap">
	<div class="adm-left-nav-body">
		<div class="adm-opn-cls">
			<div class="adm-left-nav-name">
				<a href='<?= site_url("login/exit_admin"); ?>'>Выход</a>
			</div>
		</div>
	</div>
</div>