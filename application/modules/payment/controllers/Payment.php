<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('payment/Payment_db', 'Payment');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Payment->list_data();

        $data['content'] = $this->load->view('payment/payment.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Payment->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'payment_id'      => htmlentities($this->input->post('acronim')),
            'payment_name'    => htmlentities($this->input->post('payment'))
        );

        $this->Payment->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'payment_name'    => htmlentities($this->input->post('payment'))
        );

        $value = $this->Payment->get_by_id($this->input->post('acronim'));
        $transaction = is_used('transaction', 'payment_id', $value->payment_id);

        if ($transaction->num_rows() > 0) {
            echo json_encode(array("status" => FALSE));
        } else {
            $this->Payment->update(array('payment_id' => htmlentities($this->input->post('acronim'))), $data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_delete($id)
    {
        $value = $this->Payment->get_by_id($id);
        $transaction = is_used('transaction', 'payment_id', $value->payment_id);

        if ($transaction->num_rows() > 0) {
            echo json_encode(array("status" => FALSE));
        } else {
            $this->Payment->delete_by_id($id);
            echo json_encode(array("status" => TRUE));
        }
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

        if ($this->input->post('payment') == '') {
            $data['inputerror'][] = 'payment';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
