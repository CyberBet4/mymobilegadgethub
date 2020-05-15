<?php

// php cart class
class Cart extends CI_Model
{
    public function __construct(){
            $this->load->database();
        }
  

    // insert into cart table
    public  function insertIntoCart($params = null, $table = "cart"){
        if ($this->db->get($table) != null){
            if ($params != null){
                // "Insert into cart(user_id) values (0)"
                // get table columns
                $columns = implode(',', array_keys($params));

                $values = implode(',' , array_values($params));

                // create sql query
                $query_string = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $columns, $values);

                // execute query
                $result = $this->db->query($query_string);
                return $result;
            }
        }
    }

    // to get user_id and item_id and insert into cart table
    public  function addToCart($userid, $itemid){
        if (isset($userid) && isset($itemid)){
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid
            );

            // insert data into cart
            $result = $this->insertIntoCart($params);
            if ($result){
                // Reload Page
                redirect();
            }
        }
    }

    // delete cart item using cart item id
    public function deleteCart($item_id = null, $table = 'cart'){
        if($item_id != null){
            $this->db->where("item_id", $item_id);
            if($this->db->delete($table)){
                redirect(base_url().'cart');
            }
            return $result;
        }
    }

    // calculate sub total
    public function getSum($arr){
        if(isset($arr)){
            $sum = 0;
            foreach ($arr as $item){
                $sum += floatval($item[0]);
            }
            return sprintf('%.2f' , $sum);
        }
    }

    // get item_it of shopping cart list
    public function getCartId($cartArray = null, $key = "item_id"){
        if ($cartArray != null){
            $cart_id = array_map(function ($value) use($key){
                return $value[$key];
            }, $cartArray);
            return $cart_id;
        }
    }

    // Save for later
    public function saveForLater($item_id = null, $saveTable = "wishlist", $fromTable = "cart"){
        if ($item_id != null){
            $query = "INSERT INTO {$saveTable} SELECT * FROM {$fromTable} WHERE item_id={$item_id};";
            $query .= "DELETE FROM {$fromTable} WHERE item_id={$item_id};";

            // execute multiple query

            if($this->db->insert($saveTable, array("item_id"=>$item_id)) && $this->db->where("item_id", $item_id)){
                $this->db->delete($fromTable);
                redirect(base_url().'cart');

            }
            return $result;
        }
    }


    // Delete from wishlist
    public function deleteWishlist($item_id = null){
        if ($item_id != null){

            $this->db->where("item_id", $item_id);
                $this->db->delete("wishlist");
                redirect(base_url().'cart');

        }
    }
}