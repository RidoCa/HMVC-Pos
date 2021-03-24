<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('login/Login_db', 'Login');
	}

	public function index()
	{
		$data['icon']    = 'fa-dashboard';
		$data['content'] = $this->load->view('login/login.php', $data, true);
		$this->load->view('template/auth_template', $data);
	}

	function login_action()
	{
		$data = array(
			'user_email' 	=> htmlentities($this->input->post('email', TRUE)),
			'user_password' => htmlentities(md5($this->input->post('password')))
		);

		$resultUser = $this->Login->check_user($data);

		$status = "";
		if ($resultUser->num_rows() >= 1) {
			foreach ($resultUser->result() as $sess) {
				$sess_data['logged_in'] = TRUE;
				$sess_data['user_id']   = $sess->user_id;
				$sess_data['role_id']   = $sess->role_id;
				$sess_data['username']  = $sess->user_email;
				$status 				= $sess->active;
				$this->session->set_userdata($sess_data);
			}

			if ($status == '1') {
				redirect(site_url("dashboard"), 'refresh');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible alert-message">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-fw fa-warning"></i> Peringatan</h4>
                Akun tidak aktif! <br> silahkan hubungi <b>system administrator</b>.
			  </div>');
				redirect(site_url("login"));
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible alert-message">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-fw fa-ban"></i> Gagal Masuk</h4>
                Cek username, kata sandi!
              </div>');
			redirect(site_url("login"));
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url() . 'login');
	}

	function blocked()
	{
		$this->load->view('errors/blocked');
	}
}