<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class catalogs extends MY_ControllerTmpl {
    var $table="catalogs";
    var $table_top="catalogs_group";
    var $pages=20;

    public function show(){
        $item=$this->catalogs_model->get_by_fields(array('id'=>$this->input->post('catalogs_id'),'is_block'=>0,'is_show'=>1,));
        if(!empty($item)){
            echo $this->load->view('catalogs/show',array(
                'item'=>$item,
            ),true);
        }
    }

    public function set_filters(){
        $filters=array(
            'pid'=>$this->input->post('pid')??0,
            'product_types_id'=>$this->input->post('product_types_id')??0,
            'price_from'=>intval(preg_replace("/[^0-9.]/", "",$this->input->post('price_from'))),
            'price_to'=>intval(preg_replace("/[^0-9.]/", "",$this->input->post('price_to'))),
            'filters'=>$this->input->post('filters'),
        );
        $this->session->set_userdata('catalogs_filters',serialize($filters));

        $sql="";
        if(isset($filters['price_from'])){
            $sql.=" and c.price>=".intval($filters['price_from']);
        }
        if(isset($filters['price_to'])){
            $sql.=" and c.price<=".intval($filters['price_to']);
        }
        if(!empty($filters['filters'])){
            foreach($filters['filters'] as $types_group_id=>$values){
                $real_values=array();
                foreach($values as $value){
                    if(intval($value)>0){
                        $real_values[]=intval($value);
                    }
                }
                if(count($real_values)){
                    $sql.=" and exists(select 1 from catalog_types where item_id=c.id and type_id IN(".implode(',',$real_values)."))";
                }
            }
        }

        $data['one_page']=0;

        if(!empty($filters['pid'])){
            $item=$this->catalogs_group_model->get_by_id($filters['pid']);
            $level1_data=$this->catalogs_group_model->get_page(array("pid"=>$filters['pid']??0, 'is_block'=>0, 'is_show'=>1,),null,null,'order');
            $level1=array();
            foreach($level1_data as $group_one){
                $level1[]=$group_one['id'];
            }

            $on_page=5;
            $catalogs_count=$this->catalogs_model->sql_query_one("
				select count(distinct(cg.id)) as counter
				from catalogs c
				inner join catalogs_group cg on c.pid=cg.id
				where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".implode(',',$level1).") $sql
			");
            $limit = "limit 0, $on_page";
            if($catalogs_count['counter']==1){
                $limit = "";
                $on_page = 10;
                $data['one_page']=1;
            }
            $items=$this->catalogs_group_model->sql_query_array("
				select cg.* 
				from catalogs c 
				inner join catalogs_group cg on c.pid=cg.id
				where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".implode(',',$level1).") $sql
				group by cg.id
				order by cg.`order`
				$limit
			");
            foreach($items as &$item_one){
                if($catalogs_count['counter']==1){
                    $new_counter=$this->catalogs_model->sql_query_one("
						select count(*) as counter
						from catalogs c
						where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
					");
                    $item_one['items']=$this->catalogs_model->sql_query_array("
						select c.*
						from catalogs c
						where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
						order by c.price, c.order
						limit 0, $on_page
					");
                }
                else{
                    $item_one['items']=$this->catalogs_model->sql_query_array("
						select c.*
						from catalogs c
						where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
						order by c.price, c.order
					");
                }
            }
        }
        else{
            $this->load->model('products_types_model');
            $item=$this->products_types_model->get_by_id($filters['product_types_id']);

            $on_page=5;
            $catalogs_count=$this->catalogs_model->sql_query_one("
				select count(distinct(cg.id)) as counter
				from catalogs c
				inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
				inner join catalogs_group cg on c.pid=cg.id
				where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 $sql
			");
            $limit = "limit 0, $on_page";
            if($catalogs_count['counter']==1){
                $limit = "";
                $on_page = 10;
                $data['one_page']=1;
            }
            $items=$this->catalogs_group_model->sql_query_array("
				select cg.* 
				from catalogs c 
				inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
				inner join catalogs_group cg on c.pid=cg.id
				where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 $sql
				group by cg.id
				order by cg.`order`
				$limit
			");
            foreach($items as &$item_one){
                if($catalogs_count['counter']==1){
                    $new_counter=$this->catalogs_model->sql_query_one("
						select count(*) as counter
						from catalogs c
						where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
					");
                    $item_one['items']=$this->catalogs_model->sql_query_array("
						select c.*
						from catalogs c
						where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
						order by c.price, c.order
						limit 0, $on_page
					");
                }
                else{
                    $item_one['items']=$this->catalogs_model->sql_query_array("
						select c.*
						from catalogs c
						inner join catalogs_products_types cpt on cpt.catalogs_id = c.id and cpt.products_types_id = '{$item['id']}'
						where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
						order by c.price, c.order
					");
                }
            }
        }

        $pager=$this->catalogs_group_model->get_pager(site_url($item['url']), isset($new_counter['counter'])?$new_counter['counter']:$catalogs_count['counter'], 2, $on_page);
        $html= $this->load->view('catalogs/catalog_page',array(
            'pager'=>$pager,
            'items'=>$items,
            'one_page'=>$data['one_page'],
        ),true);

        $item['meta_title'] = $item['meta_title']?$item['meta_title']:$item['name'];
        $item['h1'] = $item['h1']?$item['h1']:$item['name'];
        if($this->input->post('filters')&&count($this->input->post('filters'))==1){
            $filters_old=$this->input->post('filters');
            $filters_old = reset($filters_old);
            if(is_array($filters_old)&&count($filters_old)==1){
                $this->load->model('seos_model');
                $seo=$this->seos_model->get_by_fields(array("types_id"=>$filters_old[0], 'is_block'=>0,'catalogs_group_id'=>$filters['pid'],));
                if(!empty($seo)){
                    $item['meta_title']= $seo['meta_title']?$seo['meta_title']:$seo['name'];
                    $item['text3']= $seo['text'];
                    $item['h1']= $seo['h1']?$seo['h1']:$seo['name'];
                }
            }
        }

        echo json_encode((object)array(
            'html'=>$html,
            'title'=>$item['meta_title'],
            'text'=>$item['text3'],
            'h1'=>$item['h1'],
        ));
    }

    public function show_group($url="",$page_num=1, $seo_url=""){
        $item=$this->catalogs_group_model->get_by_fields(array("url"=>$url, 'is_block'=>0, 'is_show'=>1,));

        if(!$item['id']){
            header('HTTP/1.0 404 Not Found');
            show_404('page_404');
            return;
        }

        if($seo_url){
            $this->load->model('seos_model');
            $seo=$this->seos_model->get_by_fields(array("url"=>$seo_url, 'is_block'=>0,));
            if(!empty($seo)){
                $item['name']=$seo['name'];
                $item['h1']=$seo['h1'];
                $item['meta_title']=$seo['meta_title'];
                $item['meta_description']=$seo['meta_description'];
                $item['meta_keywords']=$seo['meta_keywords'];
                $item['text3']=$seo['text'];

                $this->load->model('types_model');
                $type=$this->types_model->get_by_id($seo['types_id']);

                $filters=array(
                    'pid'=>$item['id'],
                    'product_types_id'=>0,
                    'filters'=>array(
                        $type['pid']=>array($seo['types_id'],),
                    ),
                );
                $this->session->set_userdata('catalogs_filters',serialize($filters));
            }
        }

        $this->catalogs_group_model->load_meta($item);

        $data=array(
            'item'=>$item,
            'breads'=>$this->catalogs_group_model->get_breads($item['id']),
        );

        if($item['id']==1){
            $template='po';
            $data['items']=$this->catalogs_group_model->get_page(array("pid"=>$item['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
            foreach($data['items'] as &$group_one){
                $group_one['items']=$this->catalogs_group_model->get_page(array("pid"=>$group_one['id'], 'is_block'=>0, 'is_show'=>1,),0,9,'order');
            }

            $this->load->model('texts_model');
            $this->load->model('texts_group_model');
            $texts=$this->texts_group_model->get_by_id(2);
            $texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>2,),null,null,'order');
            $data['texts']=$texts;
        }
        else if($item['pid']==1){
            $template='po_type';
            $on_page=9;
            $sql=$search="";
            if($this->input->post('search')!==null){
                $search=trim($this->input->post('search'));
                $this->session->set_userdata('po_type_search',$search);
            }
            /*else if($this->session->userdata('po_type_search')){
                $search=trim($this->session->userdata('po_type_search'));
            }*/

            if($search){
                $sql.=" and (name like ".$this->db->escape('%'.$search.'%')." or search_tags like ".$this->db->escape('%'.$search.'%').") ";
            }

            $count=$this->catalogs_group_model->sql_query_one("select count(*) as counter from catalogs_group where is_show=1 and is_block=0 and pid='{$item['id']}' $sql");
            $start=($page_num-1)*$on_page;
            $data['items']=$this->catalogs_group_model->sql_query_array("
				select * 
				from catalogs_group 
				where is_show=1 and is_block=0 and pid='{$item['id']}' $sql
				order by `order`
				limit $start, $on_page
			");

            if($page_num!=1&&!count($data['items'])){
                header('HTTP/1.0 404 Not Found');
                show_404('page_404');
                return;
            }
            //	if($page_num>ceil($count/$on_page)){
            //		header('HTTP/1.0 404 Not Found');
            //		show_404('page_404');
            //		return;
            //	}

            $data['pager']=$this->catalogs_group_model->get_pager(site_url($url), $count['counter'], 2, $on_page);
            $data['search']=$search;
        }
        else if($item['id']==5){
            $template='oborudovanie';
            $pids_level2=array();
            $data['items']=$this->catalogs_group_model->get_page(array("pid"=>$item['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
            foreach($data['items'] as &$group_one){
                $group_one['level1']=$this->catalogs_group_model->get_page(array("pid"=>$group_one['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
                $pids=array();
                foreach($group_one['level1'] as $item_one){
                    $pids[]=$item_one['id'];
                }
                $group_one['level2']=array();
                if(count($pids)&&!$group_one['is_level2']){
                    $group_one['level2']=$this->catalogs_group_model->sql_query_array("
						select * 
						from catalogs_group 
						where is_show=1 and is_block=0 and pid IN (".implode(',',$pids).")
						order by `order`
						limit 9
					");
                    foreach($group_one['level2'] as $item_one2){
                        $pids_level2[]=$item_one2['id'];
                    }
                }
            }

            $data['types_groups']=array();
            if(count($pids_level2)){
                $data['types_groups']=$this->catalogs_group_model->sql_query_array("
					select * 
					from catalogs_group 
					where is_show=1 and is_block=0 and id IN (".implode(',',$pids_level2).")
					order by `order`
					limit 9
				");
            }

            $pids_all=$this->catalogs_group_model->get_recoursive_children(5);
            $data['types']=$this->catalogs_group_model->sql_query_array("
				select pt.* 
				from catalogs c
				inner join catalogs_products_types cpt on cpt.catalogs_id=c.id
				inner join products_types pt on pt.id=cpt.products_types_id 
				where c.is_show=1 and c.is_block=0 and pt.is_show=1 and pt.is_block=0 and c.pid IN (".implode(',',$pids_all).")
				group by pt.id
				order by pt.`order`
			");

            $this->load->model('texts_model');
            $this->load->model('texts_group_model');
            $texts=$this->texts_group_model->get_by_id(2);
            $texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>2,),null,null,'order');
            $data['texts']=$texts;
        }
        else if ($item['id'] == 42) {
            $template = 'astralinux';
            $data['items']=$this->catalogs_group_model->get_page(array("pid"=>$item['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
            foreach($data['items'] as &$group_one){
                $group_one['items']=$this->catalogs_group_model->get_page(array("pid"=>$group_one['id'], 'is_block'=>0, 'is_show'=>1,),0,9,'order');
            }

            $this->load->model('texts_model');
            $this->load->model('texts_group_model');
            $texts=$this->texts_group_model->get_by_id(2);
            $texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>42,),null,null,'order');
            $data['texts']=$texts;
        }
        else if ($item['pid'] == 42) {
            $data['items']=$this->catalogs_model->get_page(array("pid"=>$item['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
            $template = 'filter_items';
            $this->load->model('texts_model');
            $this->load->model('texts_group_model');
            $texts=$this->texts_group_model->get_by_id(2);
            $texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>2,),null,null,'order');
            $data['texts']=$texts;

            $this->load->model('gallerys_model');
            $data['gallerys']=$this->gallerys_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item['gallerys_id'],),null,null,'order');

            $data['products_types']=$this->catalogs_model->sql_query_array("
					select pt.*
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					inner join catalogs_products_types cpt on cpt.catalogs_id=c.id
					inner join products_types pt on cpt.products_types_id = pt.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].")
					group by pt.id
					order by pt.order
				");

            $data['types']=array();

            $types=$this->catalogs_model->sql_query_array("
					select t.name, t.id, tg.name as group_name, tg.id as group_id
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					inner join catalog_types ct on ct.item_id=c.id
					inner join types t on t.id=ct.type_id
					inner join types_group tg on tg.id=t.pid
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].") and tg.is_block=0 and t.is_block=0
					group by t.id
					order by tg.order, tg.id,t.order, t.name					
				");
            $prev_type_id=0;
            $this->load->model('seos_model');
            foreach($types as $item_one){
                if($prev_type_id!=$item_one['group_id']){
                    $prev_type_id=$item_one['group_id'];
                    $data['types'][$item_one['group_id']]=array(
                        'name'=>$item_one['group_name'],
                        'items'=>array(),
                    );
                }

                $seo=$this->seos_model->get_by_fields(array(
                    'catalogs_group_id'=>$item['id'],
                    'types_id'=>$item_one['id'],
                    'is_block'=>0,
                ));

                $data['types'][$item_one['group_id']]['items'][]=array(
                    'name'=>$item_one['name'],
                    'id'=>$item_one['id'],
                    'seo'=>!empty($seo['url'])?$seo['url']:'',
                );
            }

            $data['min_max']=$this->catalogs_model->sql_query_one("
					select min(c.price) as min, max(c.price) as max
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].")
				");


            $filters=array();
            if($this->session->userdata('catalogs_filters')){
                $filters=unserialize($this->session->userdata('catalogs_filters'));
                if(empty($filters)||!isset($filters['pid'])||$filters['pid']!=$item['id']){
                    $filters=array();
                }
            }
            $this->session->set_userdata('catalogs_filters',serialize($filters));
            $data['filters']=$filters;

            $sql="";
            if(isset($filters['price_from'])){
                $sql.=" and c.price>=".intval($filters['price_from']);
            }
            if(isset($filters['price_to'])){
                $sql.=" and c.price<=".intval($filters['price_to']);
            }
            if(!empty($filters['filters'])){
                foreach($filters['filters'] as $types_group_id=>$values){
                    $real_values=array();
                    foreach($values as $value){
                        if(intval($value)>0){
                            $real_values[]=intval($value);
                        }
                    }
                    if(count($real_values)){
                        $sql.=" and exists(select 1 from catalog_types where item_id=c.id and type_id IN(".implode(',',$real_values)."))";
                    }
                }
            }

            $on_page=5;
            $catalogs_count=$this->catalogs_model->sql_query_one("
					select count(distinct(cg.id)) as counter
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].") $sql
				");
            $start=($page_num-1)*$on_page;
            $limit = "limit $start, $on_page";
            if($catalogs_count['counter']==1){
                $limit = "";
                $on_page = 10;
                $start=($page_num-1)*$on_page;
                $data['one_page']=1;
            }

            $data['items']=$this->catalogs_group_model->sql_query_array("
					select cg.* 
					from catalogs c 
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].") $sql
					group by cg.id
					order by cg.`order`
					$limit
				");
            foreach($data['items'] as &$item_one){
                if($catalogs_count['counter']==1){
                    $new_counter=$this->catalogs_model->sql_query_one("
							select count(*) as counter
							from catalogs c
							where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
						");
                    $item_one['items']=$this->catalogs_model->sql_query_array("
							select c.*
							from catalogs c
							where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
							order by c.price, c.order
							limit $start, $on_page
						");
                }
                else{
                    $item_one['items']=$this->catalogs_model->sql_query_array("
							select c.*
							from catalogs c
							where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
							order by c.price, c.order
						");
                }
            }

            if(isset($new_counter)){
                if($page_num>ceil($new_counter['counter']/$on_page)){
                    header('HTTP/1.0 404 Not Found');
                    show_404('page_404');
                    return;
                }
                $counter=$new_counter['counter'];
                $data['pager']=$this->catalogs_group_model->get_pager(site_url($item['url']), $new_counter['counter'], 2, $on_page);
            }
            else{
                if($page_num>ceil($catalogs_count['counter']/$on_page)){
                    header('HTTP/1.0 404 Not Found');
                    show_404('page_404');
                    return;
                }
                $data['pager']=$this->catalogs_group_model->get_pager(site_url($item['url']), $catalogs_count['counter'], 2, $on_page);
            }

            $this->template->write('js','<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script><script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>');
            $this->template->write('css','<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css"><link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>');
        }
        else{
            $count_items=$this->catalogs_model->get_count(array("pid"=>$item['id'], 'is_block'=>0, 'is_show'=>1,));

            if($count_items>0 ){
                header('HTTP/1.0 404 Not Found');
                show_404('page_404');
                return;
            }

            $data['items']=$this->catalogs_group_model->get_page(array("pid"=>$item['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
            $level1=array();
            foreach($data['items'] as $group_one){
                $level1[]=$group_one['id'];
            }
            $counter=0;
            if(count($level1)){
                $catalogs_count=$this->catalogs_model->sql_query_one("
					select count(*) as counter
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].")
				");
                $counter=$catalogs_count['counter'];
            }

            if($counter>0){
                $template='filter_items';

                $this->load->model('texts_model');
                $this->load->model('texts_group_model');
                $texts=$this->texts_group_model->get_by_id(2);
                $texts['items']=$this->texts_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>2,),null,null,'order');
                $data['texts']=$texts;

                $this->load->model('gallerys_model');
                $data['gallerys']=$this->gallerys_model->get_page(array('is_show'=>1,'is_block'=>0,'pid'=>$item['gallerys_id'],),null,null,'order');

                $data['products_types']=$this->catalogs_model->sql_query_array("
					select pt.*
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					inner join catalogs_products_types cpt on cpt.catalogs_id=c.id
					inner join products_types pt on cpt.products_types_id = pt.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].")
					group by pt.id
					order by pt.order
				");

                $data['types']=array();

                $types=$this->catalogs_model->sql_query_array("
					select t.name, t.id, tg.name as group_name, tg.id as group_id
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					inner join catalog_types ct on ct.item_id=c.id
					inner join types t on t.id=ct.type_id
					inner join types_group tg on tg.id=t.pid
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].") and tg.is_block=0 and t.is_block=0
					group by t.id
					order by tg.order, tg.id,t.order, t.name					
				");
                $prev_type_id=0;
                $this->load->model('seos_model');
                foreach($types as $item_one){
                    if($prev_type_id!=$item_one['group_id']){
                        $prev_type_id=$item_one['group_id'];
                        $data['types'][$item_one['group_id']]=array(
                            'name'=>$item_one['group_name'],
                            'items'=>array(),
                        );
                    }

                    $seo=$this->seos_model->get_by_fields(array(
                        'catalogs_group_id'=>$item['id'],
                        'types_id'=>$item_one['id'],
                        'is_block'=>0,
                    ));

                    $data['types'][$item_one['group_id']]['items'][]=array(
                        'name'=>$item_one['name'],
                        'id'=>$item_one['id'],
                        'seo'=>!empty($seo['url'])?$seo['url']:'',
                    );
                }

                $data['min_max']=$this->catalogs_model->sql_query_one("
					select min(c.price) as min, max(c.price) as max
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].")
				");


                $filters=array();
                if($this->session->userdata('catalogs_filters')){
                    $filters=unserialize($this->session->userdata('catalogs_filters'));
                    if(empty($filters)||!isset($filters['pid'])||$filters['pid']!=$item['id']){
                        $filters=array();
                    }
                }
                $this->session->set_userdata('catalogs_filters',serialize($filters));
                $data['filters']=$filters;

                $sql="";
                if(isset($filters['price_from'])){
                    $sql.=" and c.price>=".intval($filters['price_from']);
                }
                if(isset($filters['price_to'])){
                    $sql.=" and c.price<=".intval($filters['price_to']);
                }
                if(!empty($filters['filters'])){
                    foreach($filters['filters'] as $types_group_id=>$values){
                        $real_values=array();
                        foreach($values as $value){
                            if(intval($value)>0){
                                $real_values[]=intval($value);
                            }
                        }
                        if(count($real_values)){
                            $sql.=" and exists(select 1 from catalog_types where item_id=c.id and type_id IN(".implode(',',$real_values)."))";
                        }
                    }
                }

                $on_page=5;
                $catalogs_count=$this->catalogs_model->sql_query_one("
					select count(distinct(cg.id)) as counter
					from catalogs c
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].") $sql
				");
                $start=($page_num-1)*$on_page;
                $limit = "limit $start, $on_page";
                if($catalogs_count['counter']==1){
                    $limit = "";
                    $on_page = 10;
                    $start=($page_num-1)*$on_page;
                    $data['one_page']=1;
                }

                $data['items']=$this->catalogs_group_model->sql_query_array("
					select cg.* 
					from catalogs c 
					inner join catalogs_group cg on c.pid=cg.id
					where cg.is_block=0 and cg.is_show=1 and c.is_block=0 and c.is_show=1 and c.pid IN(".$item['id'].") $sql
					group by cg.id
					order by cg.`order`
					$limit
				");
                foreach($data['items'] as &$item_one){
                    if($catalogs_count['counter']==1){
                        $new_counter=$this->catalogs_model->sql_query_one("
							select count(*) as counter
							from catalogs c
							where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
						");
                        $item_one['items']=$this->catalogs_model->sql_query_array("
							select c.*
							from catalogs c
							where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
							order by c.price, c.order
							limit $start, $on_page
						");
                    }
                    else{
                        $item_one['items']=$this->catalogs_model->sql_query_array("
							select c.*
							from catalogs c
							where is_block=0 and is_show=1 and pid='{$item_one['id']}' $sql
							order by c.price, c.order
						");
                    }
                }

                if(isset($new_counter)){
                    if($page_num>ceil($new_counter['counter']/$on_page)){
                        header('HTTP/1.0 404 Not Found');
                        show_404('page_404');
                        return;
                    }
                    $data['pager']=$this->catalogs_group_model->get_pager(site_url($item['url']), $new_counter['counter'], 2, $on_page);
                }
                else{
                    if($page_num>ceil($catalogs_count['counter']/$on_page)){
                        header('HTTP/1.0 404 Not Found');
                        show_404('page_404');
                        return;
                    }
                    $data['pager']=$this->catalogs_group_model->get_pager(site_url($item['url']), $catalogs_count['counter'], 2, $on_page);
                }

                $this->template->write('js','<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script><script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>');
                $this->template->write('css','<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css"><link  rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>');
            }
            else{

                $parent=$this->catalogs_group_model->get_by_id($item['pid']);
                $i=0;
                while($parent['pid']!=0&&$i<10){
                    ++$i;
                    $parent=$this->catalogs_group_model->get_by_id($parent['pid']);
                }

                if($parent['id']==5){
                    $template='oborudovanie_groups';
                    $on_page=9;
                    $sql=$search="";
                    if($this->input->post('search')!==null){
                        $search=trim($this->input->post('search'));
                        $this->session->set_userdata('oborudovanie_groups_search',$search);
                    }
                    /*else if($this->session->userdata('oborudovanie_groups_search')){
                        $search=trim($this->session->userdata('oborudovanie_groups_search'));
                    }*/

                    if($search){
                        $sql.=" and (name like ".$this->db->escape('%'.$search.'%')." OR search_tags like ".$this->db->escape('%'.$search.'%').")";
                    }

                    $pids2=array($item['id']);
                    $parent=$this->catalogs_group_model->get_by_id($item['pid']);
                    if($parent['id']==5&&!$item['is_level2']){
                        $data['parent']=$item;
                        $groups=$this->catalogs_group_model->get_page(array("pid"=>$data['parent']['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');
                        $pids2=array();
                        foreach($groups as $group){
                            $pids2[]=$group['id'];
                        }
                        if(!count($pids2)){
                            $pids2=array($item['id']);
                        }
                    }
                    else{
                        $data['parent']=$parent;
                    }
                    $data['groups']=$this->catalogs_group_model->get_page(array("pid"=>$data['parent']['id'], 'is_block'=>0, 'is_show'=>1,),null,null,'order');


                    $data['items']=array();
                    if(count($pids2)){
                        $count=$this->catalogs_group_model->sql_query_one("select count(*) as counter from catalogs_group where is_show=1 and is_block=0 and pid IN(".implode(',',$pids2).") $sql");
                        $start=($page_num-1)*$on_page;
                        $data['items']=$this->catalogs_group_model->sql_query_array("
							select * 
							from catalogs_group 
							where is_show=1 and is_block=0 and pid IN(".implode(',',$pids2).") $sql
							order by `order`
							limit $start, $on_page
						");
                    }
                    if($page_num!=1&&!count($data['items'])){
                        header('HTTP/1.0 404 Not Found');
                        show_404('page_404');
                        return;
                    }

                    //	if($page_num>ceil($count/$on_page)){
                    //		header('HTTP/1.0 404 Not Found');
                    //		show_404('page_404');
                    //		return;
                    //	}

                    $data['pager']=$this->catalogs_group_model->get_pager(site_url($url), $count['counter'], 2, $on_page);
                    $data['search']=$search;

                }
            }
        }

        if(!isset($template)){
            $template='empty';
        }
        if(isset($counter)){
            $data['count'] = $counter;
        }

        $this->template->write_view('content_main', 'catalogs/'.$template, $data);

        $this->template->render();
    }

}
?>