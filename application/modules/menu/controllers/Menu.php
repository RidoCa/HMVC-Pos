<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('menu/Menu_db', 'Menu');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Menu->list_data();

        $data['content'] = $this->load->view('menu/menu.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Menu->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'menu_name'    => htmlentities($this->input->post('menu')),
            'menu_sort'    => htmlentities($this->input->post('sort'))
        );

        $this->Menu->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'menu_name'    => htmlentities($this->input->post('menu')),
            'menu_sort'    => htmlentities($this->input->post('sort'))

        );

        $this->Menu->update(array('menu_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Menu->get_by_id($id);
        $this->Menu->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('menu') == '') {
            $data['inputerror'][] = 'menu';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('sort') == '') {
            $data['inputerror'][] = 'sort';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
