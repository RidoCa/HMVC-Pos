<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Price extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('price/Price_db', 'Price');
    }

    public function index()
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['listProduct']            = $this->Price->list_data();
        $data['listProductPrice']       = $this->Price->list_data_price();

        array_push($data['listProduct'], $data['listProductPrice']);
        $data['list']   = $data['listProduct'];

        // echo count($data['arrProduct']);
        // echo count(end($data['arrProduct']));
        // echo '<pre>';
        // print_r($data['list']);
        // echo '</pre>';
        // exit;

        $data['arrProduct']             = $this->Price->get_product();
        $data['arrProductPrice']        = $this->Price->get_product_price();

        array_push($data['arrProduct'], $data['arrProductPrice']);
        $data['product']  = $data['arrProduct'];
       
        $data['division'] = $this->Price->get_division();

        $data['content'] = $this->load->view('price/price.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Price->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'product_id'     => htmlentities($this->input->post('product')),
            'division_id'    => htmlentities($this->input->post('division')),
            'price_name'     => htmlentities($this->input->post('name')),
            'price_value'    => htmlentities($this->input->post('price')),
            'date_start'     => htmlentities(tglDB($this->input->post('date1'))),
            'date_expired'   => htmlentities(tglDB($this->input->post('date2')))
        );


        $this->Price->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'product_id'     => htmlentities($this->input->post('product')),
            'division_id'    => htmlentities($this->input->post('division')),
            'price_name'     => htmlentities($this->input->post('name')),
            'price_value'    => htmlentities($this->input->post('price')),
            'date_start'     => htmlentities(tglDB($this->input->post('date1'))),
            'date_expired'   => htmlentities(tglDB($this->input->post('date2')))
        );

        $this->Price->update(array('price_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Price->get_by_id($id);
        $this->Price->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('product') == '') {
            $data['inputerror'][] = 'product';
            $data['error_string'][] = 'Wajib dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('price') == '') {
            $data['inputerror'][] = 'price';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
