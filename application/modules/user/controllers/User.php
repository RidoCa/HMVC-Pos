<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('user/User_db', 'User');
    }

    public function index()
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list']     = $this->User->list_data();
        $data['role']     = $this->User->get_role();
        $data['store']    = $this->User->get_store();

        $data['content'] = $this->load->view('user/user.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->User->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        if (htmlentities($this->input->post('is_active'))) :
            $is_active = htmlentities($this->input->post('is_active'));
        else :
            $is_active = "0";
        endif;

        $data = array(
            'user_id'             => $this->User->user_id(),
            'role_id'             => htmlentities($this->input->post('role')),
            'store_id'            => htmlentities($this->input->post('store')),
            'user_name'           => htmlentities($this->input->post('name')),
            'user_email'          => htmlentities($this->input->post('email')),
            'user_password'       => htmlentities(md5('smart12345')),
            'user_regist'         => date('Ymd'),
            'is_active'           => $is_active
        );


        $this->User->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        if (htmlentities($this->input->post('is_active'))) :
            $is_active = htmlentities($this->input->post('is_active'));
        else :
            $is_active = "0";
        endif;

        $data = array(
            'role_id'             => htmlentities($this->input->post('role')),
            'store_id'            => htmlentities($this->input->post('store')),
            'user_name'           => htmlentities($this->input->post('name')),
            'user_email'          => htmlentities($this->input->post('email')),
            'is_active'           => $is_active
        );

        $this->User->update(array('user_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->User->get_by_id($id);
        $this->User->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_changepass($id)
    {
        $this->User->get_by_id($id);

        $data = array(
            'user_password'   => md5('smart12345')
            );

        $this->User->update(array('user_id' => $id), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('role') == '') {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Wajib dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('email') == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        // if ($this->input->post('password') == '') {
        //     $data['inputerror'][] = 'password';
        //     $data['error_string'][] = 'Wajib diisi';
        //     $data['status'] = FALSE;
        // }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
