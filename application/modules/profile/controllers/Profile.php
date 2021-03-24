<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('profile/Profile_db', 'Profile');
    }

    public function index()
    {
        $data['user']    = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']    = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['profile'] = $this->Profile->profile($this->session->userdata('user_id'));

        $data['content'] = $this->load->view('profile/profile.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }
}