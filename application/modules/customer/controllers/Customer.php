<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('customer/Customer_db', 'Customer');
    }

    public function index()
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list']     = $this->Customer->list_data();
        $data['division'] = $this->Customer->get_division();
        $data['content'] = $this->load->view('customer/customer.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Customer->get_by_id($id);
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
            'customer_id'         => $this->Customer->customer_id(),
            'division_id'         => htmlentities($this->input->post('division')),
            'customer_name'       => htmlentities($this->input->post('name')),
            'customer_address'    => htmlentities($this->input->post('address')),
            'customer_phone'      => htmlentities($this->input->post('phone')),
            'is_active'           => $is_active
        );


        $this->Customer->save($data);
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
            'division_id'         => htmlentities($this->input->post('division')),
            'customer_name'       => htmlentities($this->input->post('name')),
            'customer_address'    => htmlentities($this->input->post('address')),
            'customer_phone'      => htmlentities($this->input->post('phone')),
            'is_active'           => $is_active
        );

        $this->Customer->update(array('customer_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Customer->get_by_id($id);
        $this->Customer->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('division') == '') {
            $data['inputerror'][] = 'division';
            $data['error_string'][] = 'Wajib dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('phone') == '') {
            $data['inputerror'][] = 'phone';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('address') == '') {
            $data['inputerror'][] = 'address';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
