<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_db extends CI_Model
{

    var $table = 'inventory';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function lastID()
	{
		$this->db->select('inventory_id');
		$this->db->like('inventory_id', 'IVT' . dateAuto(date('Ymd')), 'both');
		$this->db->order_by('inventory_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('inventory');

		return $query->row_array();
	}

    public function inventory_id()
    {
		$lastID  = $this->lastID();

		if (!empty($lastID)) {
			$this->db->select('right(inventory_id,5) as kode', false);
			$this->db->order_by('inventory_id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('inventory');
			if ($query->num_rows() <> 0) {
				$data = $query->row();
				$kode = intval($data->kode) + 1;
			} else {
				$kode = 1;
			}

			$kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);
			$result_id = 'IVT' . dateAuto(date('Ymd')) . $kodemax;
		} else {
			$kodemax = str_pad("00001", 5, "0", STR_PAD_LEFT);
			$result_id = 'IVT' . dateAuto(date('Ymd')) . $kodemax;
		}

        return $result_id;
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('product', 'product.product_id = inventory.product_id', 'inner');
        $this->db->order_by('product_name', 'ASC');
        // $this->db->where('is_active', '1');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('inventory_id', $id);
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
        $this->db->where('inventory_id', $id);
        $this->db->delete($this->table);
    }

    public function get_product()
    {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('is_active', '1');
        $this->db->order_by('product_name', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }
}
