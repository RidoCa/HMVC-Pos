<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		is_logged_in();

		$this->load->model('password/Password_db', 'Password');
		$this->load->model('login/Login_db', 'Login');
	}

	public function index()
	{
		$data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
		$data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));

		$data['content']     = $this->load->view('password/password.php', $data, true);
		$this->load->view('template/landing_template', $data);
	}

	public function ajax_update()
	{
		$this->_validate();

		$data = array(
			'user_password' 	=> htmlentities(md5($this->input->post('re_pass')))
		);

		$this->Password->update(array('user_id' => $this->session->userdata('user_id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$data['user'] = $this->db->get_where('user', ['user_id' => $this->session->userdata('user_id')])->row_array();
		$curr_pass = md5($this->input->post('curr_pass'));

		if ($this->input->post('curr_pass') == '') {
			$data['inputerror'][] = 'curr_pass';
			$data['error_string'][] = 'Wajib diisi';
			$data['status'] = FALSE;
		} else if ($curr_pass != $data['user']['user_password']) {
			$data['inputerror'][] = 'curr_pass';
			$data['error_string'][] = 'Kata sandi salah';
			$data['status'] = FALSE;
		}

		if ($this->input->post('new_pass') == '') {
			$data['inputerror'][] = 'new_pass';
			$data['error_string'][] = 'Wajib diisi';
			$data['status'] = FALSE;
		} else if ($this->input->post('new_pass') === $this->input->post('curr_pass')) {
			$data['inputerror'][] = 'new_pass';
			$data['error_string'][] = 'Kata sandi tidak boleh sama dengan yang sudah ada';
			$data['status'] = FALSE;
		}

		if ($this->input->post('re_pass') == '') {
			$data['inputerror'][] = 're_pass';
			$data['error_string'][] = 'Wajib diisi';
			$data['status'] = FALSE;
		} else if ($this->input->post('re_pass') != $this->input->post('new_pass')) {
			$data['inputerror'][] = 're_pass';
			$data['error_string'][] = 'Kata sandi tidak cocok';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}
}
