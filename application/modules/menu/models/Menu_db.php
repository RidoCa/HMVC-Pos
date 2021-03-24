<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_db extends CI_Model
{

    var $table = 'user_menu';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('menu_name', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('menu_id', $id);
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
        $this->db->where('menu_id', $id);
        $this->db->delete($this->table);
    }
}
