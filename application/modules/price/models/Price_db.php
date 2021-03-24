<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price_db extends CI_Model
{

    var $table = 'price';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // public function price_id()
    // {
    //     $this->db->select('right(price_id,4) as kode', false);
    //     $this->db->order_by('price_id', 'desc');
    //     $this->db->limit(1);
    //     $query = $this->db->get('price');
    //     if ($query->num_rows() <> 0) {
    //         $data = $query->row();
    //         $kode = intval($data->kode) + 1;
    //     } else {
    //         $kode = 1;
    //     }

    //     $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
    //     $result_id = 'P' .$kodemax;

    //     return $result_id;
    // }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('product', 'product.product_id = price.product_id', 'right');
        // $this->db->join('division', 'division.division_id = price.division_id', 'right');
        $this->db->where(array('is_active' => '1', 'price_value =' => null));
        $this->db->order_by('product_name','ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function list_data_price()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('product', 'product.product_id = price.product_id', 'right');
        // $this->db->join('division', 'division.division_id = price.division_id', 'right');
        $this->db->where(array('is_active' => '1', 'price_value !=' => null));
        $this->db->order_by('product_name','ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('price_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('price_id', $id);
        $this->db->delete($this->table);
    }

    public function get_product()
    {
        $this->db->select('product.*, price_value');
        $this->db->from('product');
        $this->db->join('price', 'product.product_id = price.product_id', 'left');
        $this->db->where(array('is_active' => '1', 'price_value =' => null));
        $this->db->group_by('product.product_id');
        $this->db->order_by('product_name','ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_product_price()
    {
        $this->db->select('product.*, price_value');
        $this->db->from('product');
        $this->db->join('price', 'product.product_id = price.product_id', 'left');
        $this->db->where(array('is_active' => '1', 'price_value !=' => null));
        $this->db->group_by('product.product_id');
        $this->db->order_by('product_name','ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_division()
    {
        $this->db->select('*');
        $this->db->from('division');
        $query = $this->db->get();

        return $query->result_array();
    }
}
