<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_db extends CI_Model
{

    var $table = 'role';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function list_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('role_name', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function list_menu()
    {
        $this->db->select('*');
        $this->db->from('user_menu');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('role_id', $id);
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
        $this->db->where('role_id', $id);
        $this->db->delete($this->table);
    }

    public function get_role($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('role_id', $id);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function save_access($data)
    {
        $this->db->insert('user_access_menu', $data);
        return $this->db->insert_id();
    }

    public function delete_access($role, $menu)
    {
        $this->db->where(array('role_id' => $role, 'menu_id' => $menu));
        $this->db->delete('user_access_menu');
    }
}
