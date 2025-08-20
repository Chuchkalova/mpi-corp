<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends CI_Model {

    public function searchCategories($query) {
        $this->db->select('id, name, url, h1, short_text, gallerys_id');
        $this->db->from('catalogs_group');

        $this->db->group_start();
        $this->db->like('name', $query);
        $this->db->or_like('h1', $query);
        $this->db->or_like('meta_title', $query);
        $this->db->or_like('meta_description', $query);
        $this->db->or_like('meta_keywords', $query);
        $this->db->or_like('search_tags', $query);
        $this->db->group_end();

        $this->db->where('is_show', 1);
        $this->db->where('is_block', 0);
        $this->db->not_like('url', 'produkty');

        return $this->db->get()->result_array();
    }

    public function searchProducts($query) {
        $this->db->select('
            catalogs.id,
            catalogs.name,
            catalogs.url,
            catalogs.h1,
            catalogs.price,
            catalogs.articul,
            catalogs.short_text,
            catalogs.gallery_id,
            catalogs_group.url as category_url
        ');
        $this->db->from('catalogs');
        $this->db->join('catalogs_group', 'catalogs_group.id = catalogs.pid', 'left');

        $this->db->group_start();
        $this->db->like('catalogs.name', $query);
        $this->db->or_like('catalogs.h1', $query);
        $this->db->or_like('catalogs.articul', $query);
        $this->db->or_like('catalogs.meta_title', $query);
        $this->db->or_like('catalogs.meta_description', $query);
        $this->db->or_like('catalogs.meta_keywords', $query);
        $this->db->group_end();

        $this->db->where('catalogs.is_show', 1);
        $this->db->where('catalogs.is_block', 0);
        $this->db->where('catalogs_group.is_block', 0);
        $this->db->not_like('catalogs_group.url', 'produkty');

        return $this->db->get()->result_array();
    }
}
