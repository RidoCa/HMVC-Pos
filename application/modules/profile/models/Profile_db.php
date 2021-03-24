<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_db extends CI_Model
{

    var $table = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function profile($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $id);
        $this->db->join('role', 'role.role_id = user.role_id', 'inner');
        $query = $this->db->get();

        return $query->result_array();
    }

    
}
