<div class='pt10 pb10 bb-white'>
						<div class='row'>
							<div class='col-sm-3'>
								<a href='<?= site_url("catalogs/show/{$item['url']}"); ?>'><img src='<?= get_image("catalogs","file1",$item['id'],184,138); ?>' class='img-responsive'></a>
							</div>
							<div class='col-sm-9'>
								<p><a href='<?= site_url("catalogs/show/{$item['url']}"); ?>' class='color-white fs16 text-uppercase'><?= $item['name']; ?></a></p>
								<div class='fs12'>
									<?= $item['short_text']; ?>
								</div>
							</div>
						</div>
					</div>