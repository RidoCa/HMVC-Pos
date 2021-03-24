<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('login/Login_db', 'Login');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));

        $data['content'] = $this->load->view('dashboard/dashboard.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }
}
