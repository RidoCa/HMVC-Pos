<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('store/Store_db', 'Store');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Store->list_data();

        $data['content'] = $this->load->view('store/store.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Store->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'store_id'       => htmlentities($this->input->post('acronim')),
            'store_name'    => htmlentities($this->input->post('store'))
        );

        $this->Store->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            // 'store_id'      => htmlentities($this->input->post('acronim')),
            'store_name'    => htmlentities($this->input->post('store'))
        );

        $this->Store->update(array('store_id' => htmlentities($this->input->post('acronim'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Store->get_by_id($id);
        $this->Store->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('acronim') == '') {
            $data['inputerror'][] = 'acronim';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('store') == '') {
            $data['inputerror'][] = 'store';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
