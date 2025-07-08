<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'page404';
$route['translate_uri_dashes'] = FALSE;

$route['events'] = 'articles/show_all';
$route['events/(:num)'] = 'articles/show_all/$1';
$route['types_all'] = 'products_types/show_all';
$route['types_all/(:num)'] = 'products_types/show_all/$1';
$route['center'] = 'educations/show_all';

require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();

$query_res = $db->query("select * from articles where is_block=0 and is_show=1");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route['articles/'.$item_one['url']]='articles/show/'.$item_one['url'];
}

$query_res = $db->query("select * from articles_group where is_block=0 and is_show=1");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='articles/show_group/'.$item_one['url'];
	$route[$item_one['url']."/(:num)"]='articles/show_group/'.$item_one['url']."/$1";
}

$query_res = $db->query("select * from 	block_pages_group where is_block=0 and is_show=1 and type='item'");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='block_pages/show/'.$item_one['url'];
}

$query_res = $db->query("select * from 	gallerys_group where is_block=0 and is_show=1 and id='3'");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='gallerys/show_group/'.$item_one['url'];
}

$query_res = $db->query("select * from pages where is_block=0 and is_show=1");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='pages/show/'.$item_one['url'];
}

$query_res = $db->query("select * from educations where is_block=0 and is_show=1");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='educations/show/'.$item_one['url'];
}

$query_res = $db->query("select * from educations_group where is_block=0 and is_show=1 and pid=0");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='educations/show_group/'.$item_one['url'];
}

$query_res = $db->query("select * from catalogs_group where is_block=0 and is_show=1");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='catalogs/show_group/'.$item_one['url'];
	$route[$item_one['url']."/(:num)"]='catalogs/show_group/'.$item_one['url']."/$1";
}

$query_res = $db->query("select * from products_types where is_block=0 and is_show=1");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['url']]='products_types/show_group/'.$item_one['url'];
	$route[$item_one['url']."/(:num)"]='products_types/show_group/'.$item_one['url']."/$1";
}

$query_res = $db->query("
	select 
	s.url as seo_url,
	cg.url as url
	from seos s
	inner join catalogs_group cg on cg.id=s.catalogs_group_id
	where s.is_block=0 and cg.is_block=0 and cg.is_show=1 and s.types_id > 0
	");
$items=$query_res->result_array();
foreach($items as $item_one){
	$route[$item_one['seo_url']]='catalogs/show_group/'.$item_one['url']."/1/".$item_one['seo_url'];
	$route[$item_one['seo_url']."/(:num)"]='catalogs/show_group/'.$item_one['url']."/$1/".$item_one['seo_url'];
}

// Подкатегории внутри категории astralinux
$query_res = $db->query("SELECT id FROM catalogs_group WHERE url='astralinux' AND is_block=0 AND is_show=1");
$row = $query_res->row_array();
if (!empty($row)) {
    $astralinux_id = $row['id'];

    $query_res_lvl1 = $db->query("SELECT id, url FROM catalogs_group WHERE is_block=0 AND is_show=1 AND pid = ".$db->escape($astralinux_id));
    $level1 = $query_res_lvl1->result_array();

    foreach ($level1 as $item_one) {
        $route['astralinux/'.$item_one['url']] = 'catalogs/show_group/'.$item_one['url'];

        $query_res_lvl2 = $db->query("SELECT url FROM catalogs_group WHERE is_block=0 AND is_show=1 AND pid = ".$db->escape($item_one['id']));
        $level2 = $query_res_lvl2->result_array();
        foreach ($level2 as $sub_item) {
            $route['astralinux/'.$item_one['url'].'/'.$sub_item['url']] = 'catalogs/show_group/'.$sub_item['url'];
        }
    }
}


