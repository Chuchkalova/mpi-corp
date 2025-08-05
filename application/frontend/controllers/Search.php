<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Search_model');
    }

    public function index() {
        $query = $this->input->get('q', true); // запрос из ?q=текст

        $data['query'] = $query;
        $data['categories'] = [];
        $data['products'] = [];

        if ($query) {
            $data['categories'] = $this->Search_model->searchCategories($query);
            $data['products'] = $this->Search_model->searchProducts($query);
        }

        $this->load->view('search_result', $data);
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
