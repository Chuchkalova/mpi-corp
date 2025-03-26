<?
	$data=array(
		'id'=>5,
		'name'=>"Меню",
		'fields'=>array(
			'name'=>array(
				'russian_name'=>'Наименование',
				'is_active'=>true,
				'is_always'=>true,
			),
			'pid'=>array(
				'russian_name'=>'Предок',
				'is_active'=>true,
				'is_always'=>true,
			),
			'url_this'=>array(
				'russian_name'=>'URL(фикс.)',
				'is_active'=>true,
				'is_always'=>true,
			),
			'module_id'=>array(
				'russian_name'=>'Модуль',
				'is_active'=>true,
				'is_always'=>true,
			),
			'is_module_top'=>array(
				'russian_name'=>'Группа/элемент',
				'is_active'=>true,
				'is_always'=>true,
			),
			'element_id'=>array(
				'russian_name'=>'Элемент',
				'is_active'=>true,
				'is_always'=>true,
			),
			'is_show'=>array(
				'russian_name'=>'Показать',
				'is_active'=>true,
				'is_always'=>true,
			),
			'order'=>array(
				'russian_name'=>'Порядок',
				'is_active'=>true,
				'is_always'=>true,
			),
			'class'=>array(
				'russian_name'=>'Класс',
				'is_active'=>false,
				'is_always'=>false,
			),
		),
		'rools'=>array(
			'access'=>true,
			'add'=>true,
			'edit'=>true,
			'delete'=>true,
			'show'=>true,
		),
		'functions'=>array(
			'level1'=>array(
				'name'=>'Вывод простого одноуровневого меню',
				'params'=>array(
					'menu_id'=>array(
						'name'=>'ИД меню',
						'type'=>'text',
					),
				),
			),
			'level1_inline'=>array(
				'name'=>'Вывод простого одноуровневого меню в строку',
				'params'=>array(
					'menu_id'=>array(
						'name'=>'ИД меню',
						'type'=>'text',
					),
				),
			),
			'level2'=>array(
				'name'=>'Вывод двухуровневого меню',
				'params'=>array(
					'menu_id'=>array(
						'name'=>'ИД меню',
						'type'=>'text',
					),
				),
			),
			'level3'=>array(
				'name'=>'Вывод трехуровневого меню',
				'params'=>array(
					'menu_id'=>array(
						'name'=>'ИД меню',
						'type'=>'text',
					),
				),
			),
			'footer_menu'=>array(
				'name'=>'Вывод меню футера',
				'params'=>array(
					'menu_id'=>array(
						'name'=>'ИД меню',
						'type'=>'text',
					),
				),
			),
			'politic_menu'=>array(
				'name'=>'Вывод меню политик',
				'params'=>array(
					'menu_id'=>array(
						'name'=>'ИД меню',
						'type'=>'text',
					),
				),
			),
		),
	);
?>