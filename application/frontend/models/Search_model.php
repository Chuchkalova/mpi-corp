<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function searchCategories($query) {
        $this->db->select('id, name, url, h1');
        $this->db->from('catalogs_group');
        $this->db->like('name', $query);
        $this->db->or_like('h1', $query);
        $this->db->or_like('meta_title', $query);
        $this->db->or_like('meta_description', $query);
        $this->db->or_like('meta_keywords', $query);
        $this->db->or_like('search_tags', $query);
        $this->db->where('is_show', 1);
        return $this->db->get()->result_array();
    }

    public function searchProducts($query) {
        $this->db->select('catalogs.id, catalogs.name, catalogs.url, catalogs.h1, catalogs.price, catalogs.articul, catalogs_group.url as category_url');
        $this->db->from('catalogs');
        // заменили group_id на pid
        $this->db->join('catalogs_group', 'catalogs_group.id = catalogs.pid', 'left');

        // группируем все условия поиска
        $this->db->group_start();
        $this->db->like('catalogs.name', $query);
        $this->db->or_like('catalogs.h1', $query);
        $this->db->or_like('catalogs.articul', $query);
        $this->db->or_like('catalogs.meta_title', $query);
        $this->db->or_like('catalogs.meta_description', $query);
        $this->db->or_like('catalogs.meta_keywords', $query);
        $this->db->group_end();

        // фильтруем только видимые товары
        $this->db->where('catalogs.is_show', 1);

        return $this->db->get()->result_array();
    }
}
