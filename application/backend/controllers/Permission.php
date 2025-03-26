<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permission extends MY_Table {
	protected $table='users';
	protected $table_top='users';
	protected $controller="users";	
	
	public function show($pid=0, $page_num=1){
		$this->generate_template_top();
		$this->template->write('content', '<p>Нет прав на данное действие</p><p><a href="javascript:history.go(-2)">Назад</a></p>');
		$this->template->render();
	}
	
}

?>