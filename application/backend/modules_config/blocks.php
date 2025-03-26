<?
	$data=array(
		'id'=>6,
		'name'=>"Блоки",
		'fields'=>array(
			'name'=>array(
				'russian_name'=>'Наименование',
				'is_active'=>true,
				'is_always'=>true,
			),
			'text'=>array(
				'russian_name'=>'Текст',
				'is_active'=>true,
				'is_always'=>true,
			),
		),
		'rools'=>array(
			'access'=>true,
			'add'=>false,
			'edit'=>true,
			'delete'=>false,
			'show'=>true,
		),
		'functions'=>array(
			'show_text'=>array(
				'name'=>'Вывод текста блока',
				'params'=>array(
					'block_id'=>array(
						'name'=>'ИД блока',
						'type'=>'text',
					),
				),
			),
			'show_strip_text'=>array(
				'name'=>'Вывод экранированного текста блока',
				'params'=>array(
					'block_id'=>array(
						'name'=>'ИД блока',
						'type'=>'text',
					),
					'tags'=>array(
						'name'=>'Набор тегов',
						'type'=>'text',
					),
				),
			),
		),
	);
?>