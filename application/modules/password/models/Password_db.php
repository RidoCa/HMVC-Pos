<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password_db extends CI_Model
{

	var $table = 'user';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
}
