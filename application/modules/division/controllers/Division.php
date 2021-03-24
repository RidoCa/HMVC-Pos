<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Division extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('division/Division_db', 'Division');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Division->list_data();

        $data['content'] = $this->load->view('division/division.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Division->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'division_name'    => htmlentities($this->input->post('division'))
        );

        $this->Division->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'division_name'    => htmlentities($this->input->post('division'))
        );

        $value = $this->Division->get_by_id($this->input->post('id'));
        $customer = is_used('customer', 'division_id', $value->division_id);
        $price    = is_used('price', 'division_id', $value->division_id);

        if ($customer->num_rows() > 0 && $price->num_rows() > 0) {
            echo json_encode(array("status" => FALSE));
        } else {
            $this->Division->update(array('division_id' => htmlentities($this->input->post('id'))), $data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_delete($id)
    {
        $value = $this->Division->get_by_id($id);
        $customer = is_used('customer','division_id', $value->division_id);
        $price    = is_used('price','division_id', $value->division_id);

        if($customer->num_rows() > 0 && $price->num_rows() > 0){
            echo json_encode(array("status" => FALSE));
        } else {
            $this->Division->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('division') == '') {
            $data['inputerror'][] = 'division';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
