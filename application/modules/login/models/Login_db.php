<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_db extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function check_user($data)
	{
		$this->db->select('*, user.is_active as active');
		$this->db->join('role', 'role.role_id = user.role_id', 'left');
		$query = $this->db->get_where('user', $data);
		return $query;
	}

	function data_user($id)
	{
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('role', 'role.role_id = user.role_id', 'left');
		$this->db->where('user.user_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $data) {
				$user[] = $data;
			}
			return $user;
		}
	}

	public function get_array_menu($id)
	{
		$this->db->select('*');
		$this->db->from('user_menu');
		$this->db->join('user_access_menu', 'user_menu.menu_id = user_access_menu.menu_id', 'inner');
		$this->db->join('user_submenu', 'user_menu.menu_id = user_submenu.menu_id', 'inner');
		$this->db->where(array('role_id' => $id, 'user_submenu.is_active' => '1'));
		$this->db->order_by('user_menu.menu_sort, submenu_title');

		$query = $this->db->get();

		$results = array();

		foreach ($query->result_array() as $row) {
			if (!isset($results[$row['menu_id']])) {
				$results[$row['menu_id']] = array('main' => $row['menu_name']);
			}

			$results[$row['menu_id']]['data'][] = array(
				"title" => $row['submenu_title'],
				"url"	=> $row['submenu_url'],
				"icon"  => $row['submenu_icon']
			);
		}

		$results = array_values($results);
		return $results;
	}
}
