<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class configurator extends MY_Table {
	protected $table='users';
	protected $table_top='users';
	protected $controller="users";
	
	private $server_url="http://template.test1.ru";
	
	public function show($pid=0, $page_num=1){
		if(!$this->session->userdata('super')){
			redirect('permission/');
			return;
		}
		
		$this->generate_template_top();
		
		$modules=json_decode(@file_get_contents("{$this->server_url}/import/get_list"));
		$active=array();
		if(is_array($modules)){
			foreach($modules as $module){
				if ($this->db->table_exists($module)){
					$active[$module]=2;
				}
				else if(file_exists($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/{$module}.zip")){
					$active[$module]=1;
				}
				else{
					$active[$module]=0;
				}
			}
		}
		
		$templates=json_decode(@file_get_contents("{$this->server_url}/import/templates"));
		$active_templates=array();
		if(is_array($templates)){
			foreach($templates as $template){
				if(file_exists($_SERVER['DOCUMENT_ROOT']."/DESIGN/{$template}/{$template}.zip")){
					$active_templates[$template]=1;
				}
				else{
					$active_templates[$template]=0;
				}
			}
		}
		
		$this->load->helper('form');
		$this->template->write_view('content','tmpl/config',array(
			'active'=>$active,
			'active_templates'=>$active_templates,
		));
		$this->template->render();
	}
	
	public function load($module){
		if(!$this->session->userdata('super')){
			redirect('permission/');
			return;
		}
		
		file_get_contents("{$this->server_url}/import/get_module/$module/".$this->session->userdata('super_pwd'));
		
		redirect("configurator/show");
	}
	
	public function load_template($template){
		if(!$this->session->userdata('super')){
			redirect('permission/');
			return;
		}
		
		file_get_contents("{$this->server_url}/import/get_template/$template/".$this->session->userdata('super_pwd'));
		
		redirect("configurator/show");
	}
	
	public function install($module){
		$this->load->library('unzip');
		$file=$_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/{$module}.zip";
		if(file_exists($file)){
			$this->unzip->extract($file, $_SERVER['DOCUMENT_ROOT']);
			$this->users_model->run_sql_file($_SERVER['DOCUMENT_ROOT']."/application/sql.sql");
			@unlink($_SERVER['DOCUMENT_ROOT']."/application/sql.sql");
			@unlink($file);
			$this->init($module);
			$this->init($module."_group");
		}
		redirect("configurator/show");
	}
	
	public function install_template($template){
		$this->load->library('unzip');
		$file=$_SERVER['DOCUMENT_ROOT']."/DESIGN/{$template}/{$template}.zip";
		if(file_exists($file)){
			$this->unzip->extract($file);
			@unlink($file);
		}
		header("location: /DESIGN/{$template}");
	}
	
	public function init($module){
		$this->load->model('modules_model');
		$this->modules_model->init($module);
	}
	
	
}
?>