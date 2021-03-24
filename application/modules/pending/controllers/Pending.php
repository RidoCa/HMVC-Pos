<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pending extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('pending/Pending_db', 'Pending');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Pending->list_data();

        $data['content'] = $this->load->view('pending/pending.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_pending()
    {
        $id = $this->uri->segment(2);

        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Pending->add_data($id);

        $data['content'] = $this->load->view('pending/addpending.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function list_pending(){
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Pending->get_array_query();

        $data['content'] = $this->load->view('pending/addpending.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function detail($id)
    {   
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['detail']   = $this->Pending->get_detail($id);

        $data['content']  = $this->load->view('pending/pending_detail.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_cart()
    {
        $id       = $this->uri->segment(3);

        $check    = $this->Pending->check_transaction_id($id)->result_array();

        foreach ($check as $row) :
            $data = array(
                'transaction_id'    => $row['transaction_id'],
                'customer_id'       => $row['customer_id'],
                'transaction_value' => $row['transaction_value']
            );
        endforeach;

        $division = $this->Pending->get_customer_div($data['customer_id'])->row_array();
        $product  = $this->input->post('product');
        $qty      = $this->input->post('qty');
        $price    = $this->Pending->get_price($product, $division['division_id'])->row_array();
        $checkDetail1 = $this->Pending->check_transaction_detail($data['transaction_id'])->result_array();

        if (empty($price)) {
            echo json_encode(array("status" => FALSE));
        } else {
            $subtotal = (int) $qty * (int) $price['price_value'];

            if (!empty($checkDetail1)) {
                $checkDetail2 = $this->Pending->get_trx_detail($data['transaction_id'], $product)->row_array();

                foreach ($checkDetail1 as $row) {
                    $dt = array($row['product_id']);
                }

                if (in_array((!empty($checkDetail2) ? $checkDetail2['product_id'] : ''), $dt)) {
                    $price    =  $checkDetail2['transaction_price'];
                    $total    = ((int) $data['transaction_value'] - (int) $price) + $subtotal;
                } else {
                    $total    = (int) $data['transaction_value'] + (int) $subtotal;
                }
            } else {
                $total    = (int) $subtotal;
            }

            $dataTRX = array(
                'transaction_value'   => htmlentities($total)
            );

            $updateTRX = $this->Pending->update(array('transaction_id' => htmlentities($data['transaction_id'])), $dataTRX);

            if ($updateTRX) {
                $dataDetail = array(
                    'transaction_id'     => $data['transaction_id'],
                    'product_id'         => htmlentities($product),
                    'transaction_qty'    => htmlentities($qty),
                    'transaction_price'  => htmlentities($subtotal),
                    'transaction_note'   => htmlentities($this->input->post('catatan'))
                );

                $this->Pending->save_detail($dataDetail);
                echo json_encode(array("status" => TRUE));
            }
        }
    }
}
