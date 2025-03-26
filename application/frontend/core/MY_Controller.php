<?php

//контроллер авторизации
class  MY_ControllerTmpl  extends  CI_Controller  {
	public function __construct(){
		parent::__construct();
		$this->load->model('regions_model');
		
		$regions=$this->regions_model->get_regions();
		$urls=explode("/",base_url());
		$city=isset($urls[count($urls)-2])?$urls[count($urls)-2]:"";
		if(isset($regions[$city])){
			$this->session->set_userdata('region',$city);
			$this->session->set_userdata('region_city',$regions[$city]);
		}
		else{
			$this->session->set_userdata('region','');
			$this->session->set_userdata('region_city','Екатеринбург');
		}
		
		$this->load->model($this->table."_model");
		$this->load->model($this->table_top."_model");
		
		$this->template_preload('default');
    }
	
	public $settings, $user_id;
	function template_preload($template_name){
		$this->template->set_template($template_name);

		$this->load->model("settings_model");
		$this->load->model("block_positions_model");
		
		$this->load->helper("image");
		$this->load->helper("url_name");
		$this->load->helper("date_format");	
		$this->load->library('cart');
		
		$this->settings=$this->settings_model->get_settings();
		
		$this->block_positions_model->init($template_name);
		$this->regions_model->init($template_name);
		
		$this->template->write('counters',$this->settings[2]);
		$this->template->write('verification',$this->settings[4]);
	}
	
	//записать блок в шаблон
	function write_block($block_position,$block_id){
		$this->load->model("blocks_model");
		$block=$this->blocks_model->get_by_fields(array("id"=>$block_id));
		$this->template->write($block_position, $block['text']);
	}	
	
	function write_refs($refs){
		return $this->load->view('refs',array(
			'refs'=>$refs,
		),true);
	}
}
	 
?>