<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('product/Product_db', 'Product');
    }

    public function index()
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list']     = $this->Product->list_data();
        $data['category'] = $this->Product->get_category();

        $data['content'] = $this->load->view('product/product.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Product->get_by_id($id);
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
            'product_id'       => $this->Product->product_id(),
            'category_id'      => htmlentities($this->input->post('category')),
            'product_name'     => htmlentities($this->input->post('product')),
            'is_active'        => $is_active
        );

        if (!empty($_FILES['foto']['name'])) {
            $upload = $this->_do_upload();
            $data['product_image'] = $upload;
        }

        $this->Product->save($data);
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
            // 'product_id'       => $this->Product->product_id(),
            'category_id'      => htmlentities($this->input->post('category')),
            'product_name'     => htmlentities($this->input->post('product')),
            'is_active'        => $is_active
        );

        if ($this->input->post('remove_photo')) // if remove photo checked
        {
            if (file_exists('assets/img/product/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo'))
            unlink('assets/img/product/' . $this->input->post('remove_photo'));
            $data['product_image'] = '';
        }

        if (!empty($_FILES['foto']['name'])) {
            $upload = $this->_do_upload();

            //delete file
            $product = $this->Product->get_by_id($this->input->post('id'));
            if (file_exists('assets/img/product/' . $product->product_image) && $product->product_image)
            unlink('assets/img/product/' . $product->product_image);

            $data['product_image'] = $upload;
        }


        $this->Product->update(array('product_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Product->get_by_id($id);
        $this->Product->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _do_upload()
    {
        $config['upload_path']          = 'assets/img/product/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048; //set max size allowed in Kilobyte
        $config['max_width']            = 1500; // set max width image allowed
        $config['max_height']           = 1500; // set max height allowed
        $config['file_name']            = $_FILES['foto']['name']; //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) //upload and validate
        {
            $data['inputerror'][] = 'foto';
            $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }

        return $this->upload->data('file_name');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('category') == '') {
            $data['inputerror'][] = 'category';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('product') == '') {
            $data['inputerror'][] = 'product';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
