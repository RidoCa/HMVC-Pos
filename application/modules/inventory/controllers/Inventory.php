<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('inventory/Inventory_db', 'Inventory');
    }

    public function index()
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list']     = $this->Inventory->list_data();
        $data['product']  = $this->Inventory->get_product();

        $data['content'] = $this->load->view('inventory/inventory.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Inventory->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'inventory_id'        => $this->Inventory->inventory_id(),
            'product_id'          => htmlentities($this->input->post('product')),
            'inventory_stock'     => htmlentities($this->input->post('stock')),
            'inventory_units'     => htmlentities($this->input->post('unit'))
        );


        $this->Inventory->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'product_id'          => htmlentities($this->input->post('product')),
            'inventory_stock'     => htmlentities($this->input->post('stock')),
            'inventory_units'     => htmlentities($this->input->post('unit'))
        );

        $this->Inventory->update(array('inventory_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Inventory->get_by_id($id);
        $this->Inventory->delete_by_id($id);
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

        if ($this->input->post('stock') == '') {
            $data['inputerror'][] = 'stock';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('unit') == '') {
            $data['inputerror'][] = 'unit';
            $data['error_string'][] = 'Wajib dipilih';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}