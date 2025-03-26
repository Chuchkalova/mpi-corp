<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends MY_ControllerTmpl {
	var $table="mains";
	var $table_top="mains";
	
	public function index(){
		$item=$this->mains_model->get_by_id(1);
		$this->mains_model->load_meta($item);
		
		$this->load->model('articles_group_model');
		$this->load->model('articles_model');
		$articles=$this->articles_group_model->get_page(array('is_block'=>0,'is_show'=>1,),0,3,'order');
		foreach($articles as &$article_one){
			$article_one['items']=$this->articles_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$article_one['id'],),0,3,'date desc');
		}
		
		$this->load->model('catalogs_group_model');
		$catalogs1=$this->catalogs_group_model->get_by_id(1);
		$catalogs1['items']=$this->catalogs_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>1,),null,null,'order');
		foreach($catalogs1['items'] as &$catalogs1_one){
			$catalogs1_one['items']=$this->catalogs_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$catalogs1_one['id'],),null,null,'order');
		}
		
		$catalogs2=$this->catalogs_group_model->get_by_id(5);
		$catalogs2['items']=$this->catalogs_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>5,),null,null,'order');
		
		$this->load->model('block_pages_group_model');
		$page1=$this->block_pages_group_model->get_by_id(1);
		
		$this->load->model('texts_group_model');
		$this->load->model('texts_model');
		$texts=$this->texts_group_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>0,),null,null,'id');
		foreach($texts as &$text_one){
			$text_one['items']=$this->texts_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>$text_one['id'],),null,null,'order');
		}		
		
		$this->load->model('gallerys_model');
		$gallerys1=$this->gallerys_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>1,),null,null,'order');
		$gallerys2=$this->gallerys_model->get_page(array('is_block'=>0,'is_show'=>1,'pid'=>2,),null,null,'order');
        $schema = '
        <script type="application/ld+json">
        {
         "@context": "https://schema.org";,
         "@type": "Organization",
         "name": "ООО «МЕНЕДЖМЕНТ ПРАЙВИТ ИНВЕСТМЕНТС»",
         "url": "https://mpi-corp.ru";,
         "logo": "https://mpi-corp.ru/imgs/logo-header.svg";,
         "description": "Мы являемся ключевым партнером многих отечественных и зарубежных разработчиков программного обеспечения и изготовителей радиоэлектронного оборудования.",
         "address": {
           "@type": "PostalAddress",
           "streetAddress": "пр. Ленина 5Л, оф. 503",
           "addressLocality": "г. Екатеринбург",
           "addressRegion": "Свердловская область",
           "postalCode": "620014",
           "addressCountry": "RU"
         },
         "contactPoint": {
           "@type": "ContactPoint",
           "telephone": "+7-800-234-17-14",
           "contactType": "Главный телефон",
           "areaServed": "RU",
           "availableLanguage": "ru"
         }
        }
        </script>
        ';
			
		$this->template->write_view('content_main', 'mains/home', array(
			'item'=>$item,
			'articles'=>$articles,
			'catalogs1'=>$catalogs1,
			'catalogs2'=>$catalogs2,
			'page1'=>$page1,
			'texts'=>$texts,
			'gallerys1'=>$gallerys1,
			'gallerys2'=>$gallerys2,
            'schema'=>$schema,
		));
		
		$this->template->write('top10', 'main-page');
		$this->template->write('top9', 'main-page-header');
		
		$this->template->render();
	}
}
?>