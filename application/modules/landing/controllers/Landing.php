<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->model('login/Login_db', 'Login');
    }

    public function index()
    {
        $data['icon']    = 'fa-dashboard';
        $data['content'] = $this->load->view('landing/landing.php', $data, true);
        $this->load->view('template/auth_template', $data);
    }
}
