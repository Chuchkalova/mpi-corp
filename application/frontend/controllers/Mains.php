<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mains extends MY_ControllerTmpl {
	var $table="mains";
	var $table_top="mains";
	
	public function show($url){
		$item=$this->mains_model->get_by_fields(array("url"=>$url,));
		if(!$item['id']){
			header('HTTP/1.0 404 Not Found');
			show_404('page_404');
			return;
		}
		$this->mains_model->load_meta($item);

		$this->template->write_view('content_main', 'mains/show', array(
			'item'=>$item,
			'breads'=>$this->mains_model->get_breads($item['id']),
		));
		
		$this->template->render();
	}
	
	public function submit_form(){
		$this->load->model('forms_model');
		$post=$this->input->post();
		$text="";
		$j=0;
		$fields=array(
			'type'=>'Форма',
			'name'=>'ФИО',
			'city'=>'Город',
			'email'=>'Email',
			'phone'=>'Телефон',
			'org'=>'Организация',
			'text'=>'Комментарий',
		);	
		foreach($fields as $field=>$name){ 
			if(isset($post[$field])){
				$text.="<p><b>{$name}:</b> {$post[$field]}</p>";
			}
		}
		
		if($this->input->post('educations_id')){
			$this->load->model('educations_model');
			$education=$this->educations_model->get_by_fields(array('is_block'=>0,'is_show'=>1,'id'=>$this->input->post('educations_id'),));
			if(!empty($education)){
				$text.="<p><b>Курс:</b> {$education['name']}</p>";
			}
		}
		
		if($text){
			$this->forms_model->insert(array(
				'name'=>$this->input->post('type') ?? 'Без имени',
				'text'=>$text,
			));
		}
		
		$this->forms_model->email('Заполнена форма на сайте '.$_SERVER['SERVER_NAME'], $this->settings[1], $text);
	}
	
}
?>