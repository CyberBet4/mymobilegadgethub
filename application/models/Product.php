<?php

// Use to fetch product data
class Product extends CI_Model
{
    public function __construct(){
            $this->load->database();
        }

    // fetch product data using getData Method
    public function getData($table = 'product'){
        $query  = $this->db->get($table);
        return $query->result_array();
    }

    // get product using item id
    public function getProduct($item_id = null, $table= 'product'){
        if (isset($item_id)){
            $query = $this->db->get_where($table, array('item_id'=> $item_id));
            return $query->result_array();
        }
    }

}