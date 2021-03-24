<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pending_db extends CI_Model
{

    // var $table = 'pending';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from('transaction');
        $this->db->join('customer', 'customer.customer_id = transaction.customer_id', 'inner');
        $this->db->where('transaction_pay =', null);
        $this->db->order_by('transaction_id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_array_query()
    {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->join('product', 'product.category_id = category.category_id', 'inner');
        $this->db->join('price', 'price.product_id = product.product_id', 'inner');
        $this->db->join('inventory', 'inventory.product_id = product.product_id', 'inner');
        $this->db->where(array('is_active' => '1', 'inventory_stock >' => 0));
        $this->db->group_by('product.product_id');

        $query = $this->db->get();

        $results = array();

        foreach ($query->result_array() as $row) {
            if (!isset($results[$row['category_id']])) {
                $results[$row['category_id']] = array('category' => $row['category_name']);
            }
            $results[$row['category_id']]['product'][]           = $row['product_name'];
            $results[$row['category_id']]['image'][]             = $row['product_image'];
            $results[$row['category_id']]['product_id'][]        = $row['product_id'];
            $results[$row['category_id']]['inventory_stock'][]   = $row['inventory_stock'];
        }

        $results = array_values($results);
        return $results;
    }

    public function get_array_ajax($search)
    {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->join('product', 'product.category_id = category.category_id', 'inner');
        $this->db->join('price', 'price.product_id = product.product_id', 'inner');
        $this->db->join('inventory', 'inventory.product_id = product.product_id', 'inner');
        $this->db->like(array('is_active' => '1', 'product_name' => $search, 'inventory_stock' > 0));

        $query = $this->db->get();

        $results = array();

        foreach ($query->result_array() as $row) {
            if (!isset($results[$row['category_id']])) {
                $results[$row['category_id']] = array('category' => $row['category_name']);
            }
            $results[$row['category_id']]['product'][]      = $row['product_name'];
            $results[$row['category_id']]['image'][]        = $row['product_image'];
            $results[$row['category_id']]['product_id'][]   = $row['product_id'];
        }

        $results = array_values($results);
        return $results;
    }

    public function get_detail($id)
    {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('inventory', 'inventory.product_id = product.product_id', 'inner');
        $this->db->where('product.product_id', $id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_customer()
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->order_by('customer_name', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_payment()
    {
        $this->db->select('*');
        $this->db->from('payment');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function check_transaction()
    {
        $this->db->select('*');
        $this->db->from('transaction');
        $this->db->where('transaction_pay', NULL);
        $query = $this->db->get();

        return $query;
    }

    public function check_transaction_id($id)
    {
        $this->db->select('*');
        $this->db->from('transaction');
        $this->db->where('transaction_id', $id);
        $query = $this->db->get();

        return $query;
    }

    public function check_transaction_detail($invoice_id)
    {
        $this->db->select('*');
        $this->db->from('transaction_detail');
        $this->db->join('product', 'product.product_id = transaction_detail.product_id', 'inner');
        $this->db->where('transaction_id', $invoice_id);
        $query = $this->db->get();

        return $query;
    }

    public function get_customer_div($id)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('customer_id', $id);
        $query = $this->db->get();

        return $query;
    }

    public function get_price($product_id, $division_id)
    {
        $this->db->select('*');
        $this->db->from('price');
        $this->db->where(array('product_id' => $product_id, 'division_id' => $division_id));
        $query = $this->db->get();

        return $query;
    }

    public function get_trx_detail($trx_id, $product_id)
    {
        $this->db->select('*');
        $this->db->from('transaction_detail');
        $this->db->where(array('product_id' => $product_id, 'transaction_id' => $trx_id));
        $query = $this->db->get();

        return $query;
    }

    public function get_by_id($trx_id)
    {
        $this->db->select('*');
        $this->db->from('transaction');
        $this->db->where('transaction_id', $trx_id);
        $query = $this->db->get();

        return $query;
    }

    public function get_by_id_detail($trx_id, $product_id)
    {
        $this->db->select('*');
        $this->db->from('transaction_detail');
        $this->db->where(array('transaction_id' => $trx_id, 'product_id' => $product_id));
        $query = $this->db->get();

        return $query;
    }

    public function save($data)
    {
        $this->db->insert('transaction',$data);
        return $this->db->insert_id();
    }

    public function save_detail($data)
    {
        $this->db->insert('transaction_detail', $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update('transaction',$data,$where);
        return $this->db->affected_rows();
    }

    public function update_detail($where,$data) {
        $this->db->update('transaction_detail', $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($trx_id,$product_id) {
        $this->db->where(array('transaction_id' => $trx_id, 'product_id' => $product_id));
        $this->db->delete('transaction_detail');
    }

    public function delete_by_id_trx($trx_id)
    {
        $this->db->where('transaction_id', $trx_id);
        $this->db->delete('transaction');
    }
}
