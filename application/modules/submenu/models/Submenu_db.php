<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu_db extends CI_Model
{

    var $table = 'user_submenu';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('user_menu', 'user_menu.menu_id = user_submenu.menu_id', 'inner');
        $this->db->order_by('submenu_title', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('submenu_id', $id);
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
        $this->db->where('submenu_id', $id);
        $this->db->delete($this->table);
    }

    public function get_menu()
    {
        $this->db->select('*');
        $this->db->from('user_menu');
        $query = $this->db->get();

        return $query->result_array();
    }
}
