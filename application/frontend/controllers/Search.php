<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_ControllerTmpl {
    var $table="search";
    var $table_top="search";

    public function __construct() {
        parent::__construct();
        $this->load->model('Search_model');
    }

    public function index() {
        $query = $this->input->get('q', true);

        $this->load->model('Search_model');

        $data = [
            'query' => $query,
            'categories' => [],
            'products' => []
        ];

        if ($query) {
            $data['categories'] = $this->Search_model->searchCategories($query);
            $data['products'] = $this->Search_model->searchProducts($query);
        }

        // Подключение шаблонной вьюхи
        $this->template->write_view('content_main', 'search/search_result', $data);
        echo $this->template->render('', TRUE);
    }


    // AJAX endpoint
    public function ajax() {
        $query = $this->input->get('q', true);

        $result = [
            'categories' => [],
            'products' => []
        ];

        if ($query) {
            $result['categories'] = $this->Search_model->searchCategories($query);
            $result['products'] = $this->Search_model->searchProducts($query);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
    }
}
