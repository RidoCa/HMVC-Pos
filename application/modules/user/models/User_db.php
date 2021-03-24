<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_db extends CI_Model
{

    var $table = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function user_id()
    {
        $this->db->select('right(user_id,5) as kode', false);
        $this->db->order_by('user_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('user');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }

        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $result_id = 'USR_' . date('Ymd') . '_' . $kodemax;

        return $result_id;
    }

    public function list_data()
    {
        $this->db->select('role_name, store_name, user.*');
        $this->db->from($this->table);
        $this->db->join('role', 'role.role_id = user.role_id', 'inner');
        $this->db->join('store', 'store.store_id = user.store_id', 'inner');
        $this->db->where('role.role_id !=', 'SYS');
        $this->db->order_by('user_name', 'ASC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $id);
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
        $this->db->where('user_id', $id);
        $this->db->delete($this->table);
    }

    public function get_role()
    {
        $this->db->select('*');
        $this->db->from('role');
        $this->db->where(array('is_active' => '1', 'role_id !=' => 'SYS'));
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_store()
    {
        $this->db->select('*');
        $this->db->from('store');
        // $this->db->where(array('is_active' => '1', 'role_id !=' => 'SYS'));
        $query = $this->db->get();

        return $query->result_array();
    }
}
