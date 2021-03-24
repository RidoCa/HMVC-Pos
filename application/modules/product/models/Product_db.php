<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_db extends CI_Model
{

    var $table = 'product';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function lastID()
	{
		$this->db->select('product_id');
		$this->db->like('product_id', 'PRD' . dateAuto(date('Ymd')), 'both');
		$this->db->order_by('product_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('product');

		return $query->row_array();
	}

    public function product_id()
    {
		$lastID  = $this->lastID();

		if (!empty($lastID)) {
			$this->db->select('right(product_id,5) as kode', false);
			$this->db->order_by('product_id', 'desc');
			$this->db->limit(1);
			$query = $this->db->get('product');
			if ($query->num_rows() <> 0) {
				$data = $query->row();
				$kode = intval($data->kode) + 1;
			} else {
				$kode = 1;
			}

			$kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);
			$result_id = 'PRD' . dateAuto(date('Ymd')) . $kodemax;
		} else {
			$kodemax = str_pad("00001", 5, "0", STR_PAD_LEFT);
			$result_id = 'PRD' . dateAuto(date('Ymd')) . $kodemax;
		}

        return $result_id;
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('product_name', 'ASC');
        // $this->db->where('is_active', '1');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('product_id', $id);
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
        $this->db->where('product_id', $id);
        $this->db->delete($this->table);
    }

    public function get_category()
    {
        $this->db->select('*');
        $this->db->from('category');
        $query = $this->db->get();

        return $query->result_array();
    }
}
