<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Division_db extends CI_Model
{

    var $table = 'division';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('division_id', $id);
        $this->db->order_by('division', 'ASC');
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
        $this->db->where('division_id', $id);
        $this->db->delete($this->table);
    }
}
