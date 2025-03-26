<?

class modules_model extends MY_Model{
	protected $table = 'modules';
	private $actions=array(
		'add'=>'Добавление',
		'edit'=>'Редактирование',
		'delete'=>'Удаление',
		'show'=>'Просмотр',
	);
	private $variants=array(
		'0'=>'Запрещено',
		'1'=>'Разрешено',
		'2'=>'Наследуется',
	);	
	
	public function get_permission(){
		$user_id=$this->session->userdata('admin_user_id');
		
		$top_menu=array();
		
		$level1=$this->get_page(array('top_menu'=>0,),null,null,"id");
		foreach($level1 as $item_one){
			$top_menu_level1=array('name'=>$item_one['rus_name'],'level2'=>array(),);
			$select_values=$this->get_page(array('top_menu'=>$item_one['id'],),null,null,"rus_name");
			foreach($select_values as $item_one2){
				if($item_one2['top_menu']){
					$permission=$this->check_permission($user_id, $item_one2['id']);
					if($permission['show']){
						if(file_exists($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/".$item_one2['name']."/config.xml")){
							$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/".$item_one2['name']."/config.xml");
							if(isset($xml->name)&&((string)$xml->user_rools['show']!="false"||$this->session->userdata('super_mode'))){
								$top_menu_level1['level2'][$item_one2['name']]=$xml->name;
							}
						}
						else{
							$top_menu_level1['level2'][$item_one2['name']]=$item_one2['rus_name'];
						}
					}
				}
			}
			$top_menu[]=$top_menu_level1;
		}
		return $top_menu;
	}
	
	public function set_permission($user_id, $module_id, $permission, $is_group=0){
		$this->load->model("permissions_model");
		if($item=$this->permissions_model->get_by_fields(array("user_id"=>$user_id,"module_id"=>$module_id,"is_group"=>$is_group))){
			$this->permissions_model->update($item['id'], $permission);
		}
		else{
			$this->permissions_model->insert(array("user_id"=>$user_id,"module_id"=>$module_id, "is_group"=>$is_group,
				"add"=>$permission['add'],"edit"=>$permission['edit'],"show"=>$permission['show'],"delete"=>$permission['delete']
			));
		}
	}
	
	public function check_permission($user_id, $module_id){
		if($this->session->userdata('super')){
			return array('show'=>1,'add'=>1,'edit'=>1,'delete'=>1);
		}
	
		$this->load->model("permissions_model");
		$this->load->model("users_model");
		$this->load->model("users_group_model");
		$permission=array(
			'show'=>-1,
			'add'=>-1,
			'edit'=>-1,
			'delete'=>-1,
		);
		
		if($item=$this->permissions_model->get_by_fields(array("user_id"=>$user_id,"module_id"=>$module_id,"is_group"=>0))){
			foreach($permission as $p_one=>$current){
				if($item[$p_one]!="2"&&$current==-1) $permission[$p_one]=$item[$p_one];
			}
		}
		
		$user=$this->users_model->get_by_fields(array("id"=>$user_id));
		$pid=$user['pid'];
		while($pid!=0){
			if($item=$this->permissions_model->get_by_fields(array("user_id"=>$pid,"module_id"=>$module_id,"is_group"=>1))){
				foreach($permission as $p_one=>$current){
					if($item[$p_one]!="2"&&$current==-1) $permission[$p_one]=$item[$p_one];
				}
			}
			$group=$this->users_group_model->get_by_fields(array("id"=>$pid));
			$pid=$group['pid'];
		}
		
		foreach($permission as $p_one=>$current){
			if($current==-1) $permission[$p_one]=0;
		}
		return $permission;
	}
	
	public function get_id_by_name($name){
		$item=$this->get_by_fields(array('name'=>$name));
		return $item['id'];
	}
	
	public function get_full_set($user_id=0, $group_id=0){
		$this->load->model("permissions_model");
		$this->load->model("extra_permissions_model");
		$this->load->model("extra_permissions_variants_model");
		
		$modules=$this->get_page(array());
		
		$xml_permissions=array();
		foreach($modules as $module){
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/".$module['name']."/config.xml")){
				$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/".$module['name']."/config.xml");
				if(isset($xml->user_rools)){
					$xml_permissions[$module['id']]=$xml->user_rools;
				}
			}
		}
		
		
		$values=array();
		$extra_variants=array();
		$extra_values=array();
		$variant_module=array();
		
		$extra_variants_values=$this->extra_permissions_variants_model->get_page(array());
		foreach($extra_variants_values as $extra_variants_value){
			$extra_variants[$extra_variants_value['module_id']][$extra_variants_value['id']]=$extra_variants_value['rus_name'];
			$values[$extra_variants_value['module_id']][$extra_variants_value['id']]=2;
			$variant_module[$extra_variants_value['id']]=$extra_variants_value['module_id'];
		}
		
		if($user_id){
			foreach($modules as $module){
				$permission=$this->permissions_model->get_by_fields(array("user_id"=>$user_id, "module_id"=>$module['id'], "is_group"=>"0",));
				$values[$module['id']]["add"]=isset($permission['add'])?$permission['add']:2;
				$values[$module['id']]["edit"]=isset($permission['edit'])?$permission['edit']:2;
				$values[$module['id']]["show"]=isset($permission['show'])?$permission['show']:2;
				$values[$module['id']]["delete"]=isset($permission['delete'])?$permission['delete']:2;
			}

			
			$extra_values=$this->extra_permissions_model->get_page(array("user_id"=>$user_id, "is_group"=>"0",));
			if(count($extra_values)){
				foreach($extra_values as $extra_value){
					$values[$variant_module[$extra_value['variant_id']]][$extra_value['variant_id']]=$extra_value['value'];
				}
			}
		}
		else if($group_id){
			foreach($modules as $module){
				$permission=$this->permissions_model->get_by_fields(array("user_id"=>$group_id, "module_id"=>$module['id'], "is_group"=>"1",));
				$values[$module['id']]["add"]=isset($permission['add'])?$permission['add']:2;
				$values[$module['id']]["edit"]=isset($permission['edit'])?$permission['edit']:2;
				$values[$module['id']]["show"]=isset($permission['show'])?$permission['show']:2;
				$values[$module['id']]["delete"]=isset($permission['delete'])?$permission['delete']:2;
			}
			
			$extra_values=$this->extra_permissions_model->get_page(array("user_id"=>$group_id, "is_group"=>1,));
			if(count($extra_values)){
				foreach($extra_values as $extra_value){
					$values[$variant_module[$extra_value['variant_id']]][$extra_value['variant_id']]=$extra_value['value'];
				}
			}
		}
		else{
			foreach($modules as $module){
				$values[$module['id']]["add"]=2;
				$values[$module['id']]["edit"]=2;
				$values[$module['id']]["show"]=2;
				$values[$module['id']]["delete"]=2;
			}
		}
		
		$blocks=array();
		foreach($modules as $module){
			if(!isset($xml_permissions[$module['id']])||$xml_permissions[$module['id']]['access']=="true"||$this->session->userdata('super_mode')){
				$block=array(
					'name'=>$module['rus_name'],
					'trs'=>array(),
				);
					
				foreach($values[$module['id']] as $action_name=>$value){
					if(isset($this->actions[$action_name])){
						$rus_name=$this->actions[$action_name];
						$current_value=$values[$module['id']][$action_name];
					}
					else if(isset($extra_variants[$module['id']][$action_name])){
						$rus_name=$extra_variants[$module['id']][$action_name];
						$current_value=isset($values[$module['id']][$action_name])?$values[$module['id']][$action_name]:2;
					}
					else{
						$rus_name="";
						$current_value=2;
					}
					
					$td=array(
						'name'=>$rus_name,
						'fields'=>array(),
					);
					foreach($this->variants as $variant_id=>$variant_name){
						$is_selected=($variant_id==$current_value)?true:false;
						$td['fields'][]=array(
							'name'=>$variant_name,
							'value'=>form_radio("module[".$module['id']."][".$action_name."]", $variant_id, $is_selected),
						);
					}
					$block['trs'][]=$td;
				}
				$blocks[]=$block;
			}
		}
		
		return $blocks;
	}
	
	public function update_rools($user_id, $is_group, $rools){
		$this->load->model("permissions_model");
		$this->load->model("extra_permissions_model");
		$permissions_set=array();
		foreach($rools as $module_id=>$variant){
			foreach($variant as $variant_name=>$variant_value){
				if(isset($this->actions[$variant_name])){
					$permissions_set[$module_id][$variant_name]=$variant_value;
				}
				else{
					$this->extra_permissions_model->insert_or_update(
						array('user_id'=>$user_id,'is_group'=>$is_group,'variant_id'=>$variant_name,), 
						array('value'=>$variant_value,'user_id'=>$user_id,'is_group'=>$is_group,'variant_id'=>$variant_name,)
					);
				}
			}
		}
		
		foreach($permissions_set as $module_id=>$set_value){
			$this->permissions_model->insert_or_update(array(
				'user_id'=>$user_id,'is_group'=>$is_group, 'module_id'=>$module_id,), 
				array(
					'edit'=>$set_value['edit'],
					'add'=>$set_value['add'],
					'show'=>$set_value['show'],
					'delete'=>$set_value['delete'],
					'user_id'=>$user_id,
					'is_group'=>$is_group,
					'module_id'=>$module_id,
				)
			);
		}
	}
	
	public function init($module){
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/{$module}.php")){
			include($_SERVER['DOCUMENT_ROOT']."/application/backend/modules_config/{$module}.php");
			$module_id=$data['id'];
			$this->load->model('modules_config_model');
			$config=$this->modules_config_model->get_by_fields(array('id'=>$module_id,'module'=>$module,));
			if(isset($config['id'])){
				$old_data=unserialize($config['data']);
				$data['fields']=$old_data['fields'];
				
				$this->modules_config_model->update_where(array('id'=>$module_id,'module'=>$module,), array(
					'data'=>serialize($data),
				));
			}
			else{
				$this->modules_config_model->insert(array(
					'id'=>$module_id,
					'module'=>$module,
					'data'=>serialize($data),
				));
			}
		}
	}
	
}

?>