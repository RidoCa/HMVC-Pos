<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('category/Category_db', 'Category');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Category->list_data();

        $data['content'] = $this->load->view('category/category.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Category->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        $data = array(
            'category_id'       => htmlentities($this->input->post('acronim')),
            'category_name'    => htmlentities($this->input->post('category'))
        );

        $this->Category->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        $data = array(
            'category_name'    => htmlentities($this->input->post('category'))
        );

        $value = $this->Category->get_by_id($this->input->post('acronim'));
        $product = is_used('product', 'category_id', $value->category_id);

        if ($product->num_rows() > 0) {
            echo json_encode(array("status" => FALSE));
        } else {
            $this->Category->update(array('category_id' => htmlentities($this->input->post('acronim'))), $data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_delete($id)
    {
        $value = $this->Category->get_by_id($id);
        $product = is_used('product', 'category_id', $value->category_id);

        if ($product->num_rows() > 0) {
            echo json_encode(array("status" => FALSE));
        } else {
            $this->Category->delete_by_id($id);
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

        if ($this->input->post('category') == '') {
            $data['inputerror'][] = 'category';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
