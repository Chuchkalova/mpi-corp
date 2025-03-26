<?php

class  MY_Table  extends  MY_ControllerAuth  {
	protected $model, $top_model, $variant_model, $controller, $table, $table_top;
	
	var $regions=array();
	
	//конструктор - загрузка модели предков и модели потомков
	public function __construct(){
		parent::__construct();
		
		$this->load->model('regions_model');
		$this->regions=$this->regions_model->get_regions();
		
		$this->load->helper('cookie');
		$this->load->helper("form");
		$this->template->set_template('default');
		$this->load->model($this->table."_model");
		$this->load->model($this->table_top."_model");
		
		$this->model=$this->table."_model";
		$this->top_model=$this->table_top."_model";
    }

	
	//внутренняя функция генерирования страницы
	protected function generate_template_top(){	
		$this->template->write_view('footer', 'tmpl/footer');
		$this->template->write_view('header', 'tmpl/header', array(
			'top_refs' => $this->get_top_menu(),
			'active'=>$this->uri->segment(1),
		));	
	}
	
	//вывод главной
	public function index(){	
		$this->show(0,1);
	}
	
	//вывод сртаницы с группами или элементами
	public function show($pid=0, $page_num=1){
		$this->variant_model=null;
		if($this->{$this->top_model}->check_variant($pid)){
			$this->variant_model=$this->top_model;
		}
		else if($this->{$this->model}->check_variant($pid)){
			$this->variant_model=$this->model;
		}
		
		if(!$this->check_permissions('show')){
			redirect('permission/');
			return;
		}
		
		$this->set_filtres($pid);
		$this->generate_template_top();
		$this->show_table_main($pid, $page_num);
		$this->template->render();
	}
	
	protected function check_permissions($permission){
		if($this->variant_model){
			return $this->{$this->variant_model}->check_permissions($permission, $this->current_permissions, $this->extra_permissions);
		}
		return true;
	}
	
	protected function set_filtres($pid){
		if($this->variant_model===null) return;
		$this->{$this->variant_model}->check_filtres_post($pid, $this->input->post());
	}
	
	protected function change_table($pid){
		if($this->variant_model===null) return;
		$this->{$this->variant_model}->change_table($pid, $this->input->post());
	}
	
	protected function get_top_string($pid){
		return "";
	}
	
	protected function show_table_main($pid=0, $page_num=1){
		$add_buttons=$this->get_add_buttons($pid);
		
		if($this->variant_model){
			$condition=$this->{$this->variant_model}->get_show_conditions($pid);
			$condition.=$this->{$this->variant_model}->get_show_filters_conditions($pid);
		
			$filtres_top=$this->{$this->variant_model}->get_top_filters($pid);
			$sort_trs=$this->{$this->variant_model}->sort_table_tr($pid);
			$filter_table_trs=$this->{$this->variant_model}->filter_table_tr($pid);			
			$th=$this->{$this->variant_model}->get_th_array();
			$trs=$this->{$this->variant_model}->generate_table($pid, $condition, $page_num, $this->current_permissions, $this->extra_permissions);
			$count_pages=$this->{$this->variant_model}->get_count_table($condition);
		}
		else{
			$count_pages=1;
			$filtres_top=$sort_trs=$filter_table_trs=$th=$trs=array();
			$this->variant_model=$this->top_model;
		}
		
		if(file_exists(APPPATH.'views/'.$this->table."/show.php")){
			$view_name=$this->table."/show";
		}
		else{
			$view_name='common/show';
		}
		
		$top_string=$this->get_top_string($pid);
		$refs=$this->{$this->variant_model}->get_ref($pid);
		$title=$this->{$this->variant_model}->get_title('');
		$pager=$this->{$this->variant_model}->get_pager(site_url("{$this->controller}/show/$pid/"), $count_pages, 4);
		$submit_table=$this->{$this->variant_model}->submit_table($pid);
		
		$this->template->write_view('content', $view_name, array(
			'add_buttons'=>$add_buttons,
			'filtres_top'=>$filtres_top,
			'sort_trs'=>$sort_trs,
			'filter_table_trs'=>$filter_table_trs,
			'th'=>$th,
			'trs'=>$trs,
			'refs'=>$refs,
			'top_string'=>$top_string,
			'title'=>$title,
			'pager'=>$pager,
			'pid'=>$pid,
			'page_num'=>$page_num,
			'submit_table'=>$submit_table,
			'controller'=>$this->controller,
		));
		
	}
	
	public function get_add_buttons($pid){
		$return="";
		if($this->check_permissions('add')){
			if($this->variant_model===null||$this->variant_model==$this->table."_model"){
				$add_url=site_url("{$this->controller}/add/$pid/");
				$return.="<a href='$add_url' title='Добавить'><img src='/site_img/admin/add.png'></a>&nbsp;";
			}
			
			if($this->table_top!=$this->table&&($this->variant_model===null||$this->variant_model==$this->table_top."_model")){
				$model_config=$this->{$this->table."_model"}->config();
				if(!isset($model_config['settings']['module']['data']['is_groups']['value'])||$model_config['settings']['module']['data']['is_groups']['value']){
					$add_url=site_url("{$this->controller}/add_group/$pid/");
					$return.="<a href='$add_url' title='Добавить подкатегорию'><img src='/site_img/admin/add_folder.png'></a>&nbsp;";
				}
			}
		}
		return $return;
	}
	
	protected function add_abstract($pid, $action){
		if(!$this->check_permissions('add')){
			redirect('login/');
			return;
		}
		if($action=="add_group"){
			$this->variant_model=$this->top_model;
			$title='- добавить категорию';
		}
		else{
			$this->variant_model=$this->model;
			$title='- добавить элемент';
		}
		$title=$this->{$this->variant_model}->get_title($title);
		$refs=$this->{$this->variant_model}->get_ref($pid);
		
		$fields=$this->{$this->variant_model}->get_add_fields($pid);
		$after_content=$this->{$this->variant_model}->get_after_add_fields($pid);
		
		if(file_exists(APPPATH.'views/'.$this->controller."/".$action.".php")){
			$view_name=$this->controller."/$action";
		}
		else{
			$view_name="common/$action";
		}

		$this->template->write_view('content', $view_name, array(
			'title'			=>$title,
			'refs'			=>$refs,
			'fields'		=>$fields,			
			'after_content'	=>$after_content,
			'pid'			=>$pid,
			'controller'	=>$this->controller,
			'action'		=>$action,
		));
		
		$this->generate_template_top();
		$this->template->render();
	}
	
	public function add_group($pid=0){
		$this->add_abstract($pid, "add_group");
	}
	
	public function add($pid=0){
		$this->add_abstract($pid, "add");
	}
	
	protected function add_abstract_do($action){
		if($action=="add_group"){
			$this->variant_model=$this->top_model;
		}
		else{
			$this->variant_model=$this->model;
		}
		
		if(!$this->check_permissions('add')){
			redirect('login/');
			return;
		}
		
		$post=$this->{$this->variant_model}->before_insert_item($this->input->post());
		$this->{$this->variant_model}->insert_item($post);
		$this->{$this->variant_model}->after_insert_item();
		$this->{$this->variant_model}->after_insert_redirect($post);
	}	
	
	public function add_group_do(){
		$this->add_abstract_do("add_group");
	}
	
	public function add_do(){
		$this->add_abstract_do("add");
	}
	
	protected function edit_abstract($edit_id, $action){
		if($action=="edit_group"){
			$this->variant_model=$this->top_model;
			$title='- редактировать категорию';
		}
		else{
			$this->variant_model=$this->model;
			$title='- редактировать элемент';
		}
		
		if(!$this->check_permissions('edit')){
			redirect('permission/');
			return;
		}
		
		$title=$this->{$this->variant_model}->get_title($title);
		$refs=$this->{$this->variant_model}->get_ref($edit_id);
		
		$fields=$this->{$this->variant_model}->get_edit_fields($edit_id);
		$after_content=$this->{$this->variant_model}->get_after_edit_fields($edit_id);
		
		$item=$this->{$this->variant_model}->get_by_id($edit_id);
		
		if(file_exists(APPPATH.'views/'.$this->controller."/".$action.".php")){
			$view_name=$this->controller."/$action";
		}
		else{
			$view_name="common/$action";
		}

		$this->template->write_view('content', $view_name, array(
			'title'			=>$title,
			'refs'			=>$refs,
			'fields'		=>$fields,			
			'after_content'	=>$after_content,
			'pid'			=>$edit_id,
			'controller'	=>$this->controller,
			'action'		=>$action,
			'item'			=>$item,
		));
		
		$this->generate_template_top();
		$this->template->render();
	}
	
	public function edit_group($pid=0){
		$this->edit_abstract($pid, "edit_group");
	}
	
	public function edit($pid=0){
		$this->edit_abstract($pid, "edit");
	}
	
	protected function edit_abstract_do($action){
		if($action=="edit_group"){
			$this->variant_model=$this->top_model;
		}
		else{
			$this->variant_model=$this->model;
		}
		
		if(!$this->check_permissions('edit')){
			redirect('permission/');
			return;
		}
		
		$post=$this->{$this->variant_model}->before_update_item($this->input->post());
		$this->{$this->variant_model}->update_item($post);
		$this->{$this->variant_model}->after_update_item();
		$this->{$this->variant_model}->after_update_redirect($post);
	}
	
	public function edit_group_do(){
		$this->edit_abstract_do("edit_group");
	}
	
	public function edit_do(){
		$this->edit_abstract_do("edit");
	}
	
	public function set_order($field, $order, $pid){
		$table=$this->table_top;
		if($this->{$this->model}->check_variant($pid)){
			$table=$this->table;
		}
		
		$this->{"{$table}_model"}->set_cookie("filter_{$table}_order_type", $order);
		$this->{"{$table}_model"}->set_cookie("filter_{$table}_order", $field);
		redirect("{$this->controller}/show/$pid");
	}
	
	public function clear_filters($pid){
		$table=$this->table_top;
		if($this->{$this->model}->check_variant($pid)){
			$table=$this->table;
		}
		
		$this->{"{$table}_model"}->clear_filters();
		
		redirect("{$this->controller}/show/$pid");
	}
	
	public function delete_file($item_id, $file){
		if(!$this->check_permissions('edit')){
			redirect('login/');
			return;
		}
		$file=base64_decode($file);
		$file=str_replace("/dir_images/","",$file);
		$files=$this->rsearch($_SERVER['DOCUMENT_ROOT']."/dir_images/",$file);
		foreach($files as $item_one){
			@unlink($item_one);
		}
		
		if(strpos($file, "group")!==false){
			$module="edit_group";
		}
		else{
			$module="edit";
		}
		
		redirect($this->controller."/$module/$item_id/");
	}
	
	private function rsearch($folder, $pattern) {
		$directory = new RecursiveDirectoryIterator(
			$folder,
			RecursiveDirectoryIterator::KEY_AS_FILENAME | 
			RecursiveDirectoryIterator::CURRENT_AS_FILEINFO
		);
		$files = new RegexIterator(
			new RecursiveIteratorIterator($directory),
			"#^{$pattern}$#",
			RegexIterator::MATCH,
			RegexIterator::USE_KEY
		);
		$fileList=array();
		foreach($files as $file) {
			$fileList[]=$file->getPathname();
		}
		return $fileList;
	}
	
	public function delete_extra($group_id, $item_id){
		$this->load->model($this->table_top."_extra_model");
		$this->{$this->table_top."_extra_model"}->delete_where(array('group_id'=>$group_id,'item_id'=>$item_id,));
		redirect($this->table."/edit/$item_id");
	}
	
	public function set_one_filter($pid, $field_name, $value){
		$table=$this->table_top;
		if($this->{$this->model}->check_variant($pid)){
			$table=$this->table;
		}
		$this->{"{$table}_model"}->set_one_filter($pid, $field_name, $value);
	}
	
	public function delete($item_id, $is_referer=0){
		$this->variant_model=$this->model;
		if(!$this->check_permissions('delete')){
			redirect("/permission/");
			return;
		}
		
		$item=$this->{$this->model}->get_by_fields(array('id' => $item_id));
		$this->{$this->model}->block($item_id);
		if(!$is_referer){
			redirect($this->controller."/show/{$item['pid']}/");
		}
		else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	
	public function delete_group($item_id){
		$this->variant_model=$this->top_model;
		if(!$this->check_permissions('delete')){
			redirect("/permission/");
			return;
		}
		$item=$this->{$this->top_model}->get_by_fields(array('id' => $item_id));
		
		$this->{$this->top_model}->block_recoursive($item_id);
		redirect($this->controller."/show/{$item['pid']}/");
	}
	
	//вывод страницы с группами или элементами
	public function config(){
		if(!$this->session->userdata('super')){
			redirect('permission/');
			return;
		}
		
		$this->load->helper('form');
		$this->generate_template_top();	
		$title=$this->{$this->model}->get_title(" - конфигурация");		
		$content=$this->{$this->model}->get_config();
		
		if($this->top_model!=$this->model){
			$content.=$this->{$this->top_model}->get_config();
		}
		
		$this->template->write('content', $content);
		
		$this->template->render();
	}
	
	//вывод сртаницы с группами или элементами
	public function config_do(){
		if(!$this->session->userdata('super')){
			redirect('permission/');
			return;
		}
		
		$model=$this->input->post("model")."_model";
		if($model){
			$this->{$model}->set_config($this->input->post());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
} 
?>