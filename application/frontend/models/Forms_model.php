<?
class forms_model extends MY_Model{
	protected $table = 'forms';
	
	public function email($subject, $to, $text){
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$this->email->initialize($config);				
		$this->email->from('sales@mpi.ru.com','sales@mpi.ru.com');
		$this->email->to($to); 	
		
		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT']."/user_upload";
		$config['allowed_types'] = "*";
		$config['max_size'] = '10000';
		$config['max_width'] = '10000';
		$config['max_height'] = '10000';
		$config['overwrite'] = true;	
		$this->load->library('upload');	
		$this->upload->initialize($config);
		
		for($i=1;$i<=4;++$i){
			if($this->upload->do_upload('file'.$i)){
				$file_data = $this->upload->data();
				$source = $config['upload_path']."/".$file_data['file_name'];
				$this->email->attach($source); 	
			}
		}

		$this->email->subject($subject);
		$this->email->message($text); 
		$this->email->send();				
	}
}
?>