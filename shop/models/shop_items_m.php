<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Anatoly Khelmer
 */
class Shop_Items_m extends MY_Model {

    public function  __construct() {
        parent::__construct();
    }

    public function get_all($base_where = array())
    {
        $where = '';
        if (!empty($base_where)) {
            $where = 'where ';
            $i = 0;
            foreach($base_where as $name => $value) {
                $where .= ($i) ? ' and ' : '';
                if ($name == 'status') {
                    if ($value == 'draft') $value = 0;
                    else $value = 1;
                }
                $where .= "{$name} = {$this->db->escape($value)}";
                $i++;
            }
        }
        $query = "select * from `shop_items` $where;";
        $sql = $this->db->query($query);
        return $sql;
    }

    public function get_all_in_cat($cat_id)
    {
        $query = "select * from `shop_items` where category={$this->db->escape($cat_id)};";
        $sql = $this->db->query($query);
        return $sql;
    }

    public function get($id)
    {
        $query = "select * from `shop_items` where id={$this->db->escape($id)};";
        $sql = $this->db->query($query);
        $row = $sql->row();
        return $row;
    }


    public function get_options($id=0)
    {
        $query = "select * from `shop_item_options` where item_id={$this->db->escape($id)};";
        $sql = $this->db->query($query);
        return $sql;
    }

    /**
     * Get all values for option with id specified
     *
     * @param int $option_id
     * @return sql query result
     */
    public function get_option_values($option_id=0)
    {
        $query = "select * from `shop_item_option_values` where option_id={$this->db->escape($option_id)};";
        $sql = $this->db->query($query);
        return $sql;
    }


    public function get_option_value($value_id=0)
    {
        $query = "select * from `shop_item_option_values` where id={$this->db->escape($value_id)};";
        $sql = $this->db->query($query);
        $row = $sql->row();
        return $row;
    }


    public function search($word)
    {
        $word = '%'.$word.'%';
        $query = "select * from `shop_items` where name like {$this->db->escape($word)};";
        $sql = $this->db->query($query);
        return $sql;
    }

    public function create($params)
    {
        if ($params['status'] == 'draft') $status = 0;
        else $status = 1;
        $name = $this->db->escape($params['title']);
        $price = $this->db->escape($params['price']);
        $category = $this->db->escape($params['category']);
        $gallery = $this->db->escape($params['gallery']);
        $status = $this->db->escape($status);
        $description = $this->db->escape($params['description']);
        
        // Let's start from items
        $query = "insert into `shop_items` (name, price, category, gallery, status, description)
                    values ($name, $price, $category, $gallery, $status, $description);";
        $sql = $this->db->query($query);
        if ($sql == false) return false;

        $item_id = $this->db->insert_id();

        // Now options if we have
        // Option name first of all
        if (isset($params['option_name']) && $params['option_name'] != '') {
            $query = "insert into `shop_item_options` (name, item_id) values ({$this->db->escape($params['option_name'])}, {$this->db->escape($item_id)});";
            $sql = $this->db->query($query);
            $item_option_id = $this->db->insert_id();
            if ($sql == false) return false;
        
            // And option values
            if (isset($params['value']) && $params['value'] != '') {
                foreach ($params['value'] as $option_value_id => $value) {
                    $query = "insert into `shop_item_option_values` (option_id, value) values ({$this->db->escape($item_option_id)}, {$this->db->escape($value)});";
                    $sql = $this->db->query($query);
                    if ($sql == false) return false;
                }
            }
        }
        return TRUE;
    }

    public function delete($id)
    {
        $query = "delete from `shop_items` where id={$this->db->escape($id)};";
        $sql = $this->db->query($query);
        return $sql;
    }

    public function edit($id, $params)
    {
        if ($params['status'] == 'draft') $status = 0;
        else $status = 1;
        $name = $this->db->escape($params['title']);
        $price = $this->db->escape($params['price']);
        $category = $this->db->escape($params['category']);
        $gallery = $this->db->escape($params['gallery']);
        $status = $this->db->escape($status);
        $description = $this->db->escape($params['description']);

        $query = "update `shop_items` set
                                        name = $name,
                                        price = $price,
                                        category = $category,
                                        gallery  = $gallery,
                                        status = $status,
                                        description = $description where
                    id = {$this->db->escape($id)};";
        $sql = $this->db->query($query);
        return $sql;
    }

}