<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		if(!count($this->db->list_tables())){
			$sql_file=$_SERVER['DOCUMENT_ROOT']."/DESIGN/config.sql";
			if(file_exists($sql_file)){
				$this->load->model('modules_model');
				$this->modules_model->run_sql_file($sql_file);
				
				$this->load->model('modules_model');
				$this->modules_model->init('blocks');
				$this->modules_model->init('mains');
				$this->modules_model->init('menus');
				$this->modules_model->init('menus_group');
				$this->modules_model->init('settings');
				$this->modules_model->init('users');
				unlink($sql_file);
				
				$file_text=file_get_contents($_SERVER['DOCUMENT_ROOT']."/application/backend/config/config.php");
				$file_text=str_replace("config['sess_driver'] = 'files'", "config['sess_driver'] = 'database'", $file_text);
				file_put_contents($_SERVER['DOCUMENT_ROOT']."/application/backend/config/config.php", $file_text);
			}
		}
		
		$this->template->set_template('default');
		$this->load->model('users_model');
	}
	
	public function index(){
		if($this->session->userdata('admin_user_id')){
			redirect('mains');
		}
		$this->template->write_view('content', 'login/login');
		$this->template->render();
	}
	
	public function send(){
		$super="45cINBgRed";
		$this->session->set_userdata('super_pwd',$super);

	
		if($this->input->post('login')=="super"&&$this->input->post('password')==$super){
			$this->session->set_userdata('super', 1);
			$this->session->set_userdata('super_mode', 1);
			$this->session->set_userdata('admin_user_id', 1);
			redirect('configurator');
		}
		
		$user=$this->users_model->get_by_fields(
			array(
				"login"=>$this->input->post('login'),
				"password"=>$this->input->post('password'),
				"is_block"=>0,
			)
		);

		if(isset($user['id'])){
			$this->session->set_userdata('admin_user_id', $user['id']);
			if($this->input->post('remember')){
				$this->load->helper('cookie');
					
				$cookie = array(
					'name'   => 'user_id',
					'value'  => $user['id'],
					'expire' => '86500',
					'path'   => '/',
				);
				set_cookie($cookie);
					
				$cookie = array(
					'name'   => 'password_hash',
					'value'  => md5($user['password']),
					'expire' => '86500',
					'path'   => '/',
				);
				set_cookie($cookie);
			}
			if($this->session->userdata('super')){
				redirect('configurator');
			}
			else{
				redirect('mains');
			}
		}
		else{
			$this->template->write_view('content', 'login/wrong');
			$this->template->render();
		}
	}
	
	public function exit_admin(){
		$this->session->unset_userdata('admin_user_id');
		$this->session->unset_userdata('super');
		$this->load->helper('cookie');
		delete_cookie("user_id");
		delete_cookie("password_hash");
		redirect('login/');
	}
	
	public function change_view_mode(){
		if($this->session->userdata('super')){
			if(!$this->session->userdata('super_mode')){
				$this->session->set_userdata('super_mode', 1);
			}
			else{
				$this->session->unset_userdata('super_mode');
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}
?>