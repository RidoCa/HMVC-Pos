<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->load->library('pdf');
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('transaction/Transaction_db', 'Transaction');
        $this->load->model('customer/Customer_db', 'Customer');
    }

    public function index()
    {
        $data['user']           = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']           = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list']           = $this->Transaction->get_array_query();

        $data['customer'] 		= $this->Transaction->get_customer();
        $data['check']          = $this->Transaction->check_transaction()->row_array();
        $data['checkDetail']    = $this->Transaction->check_transaction_detail((!empty($data['check']) ? $data['check']['transaction_id'] : ''))->num_rows();

        $data['content']  = $this->load->view('transaction/transaction.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_search()
    {
        $search = $this->input->post('search');
        $data   = $this->Transaction->get_array_ajax($search);

        echo json_encode($data);
    }

    public function detail($id)
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['detail']   = $this->Transaction->get_detail($id);
        $data['check']    = $this->Transaction->check_transaction()->result_array();

        $data['content']  = $this->load->view('transaction/product_detail.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function cart()
    {
        $id = $this->uri->segment(3);

        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['payment']  = $this->Transaction->get_payment();
        // $data['check']          = $this->Transaction->check_transaction()->row_array();
        // $data['checkDetail']    = $this->Transaction->check_transaction_detail((!empty($data['check']) ? $data['check']['transaction_id'] : ''))->result_array();
        $data['check']          = $this->Transaction->check_transaction_id($id)->row_array();
        $data['checkDetail']    = $this->Transaction->check_transaction_detail(($id))->result_array();

        $data['content']  = $this->load->view('transaction/cart.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $customer = htmlentities($this->input->post('newCust'));

        if (empty($customer)) {
            $data = array(
                'transaction_id'      => $this->Transaction->transaction_id(),
                'customer_id'         => htmlentities($this->input->post('customer'))
            );
            $this->Transaction->save($data);
            echo json_encode(array("status" => TRUE));
        } else {
            $dataCust = array(
                'customer_id'         => $this->Customer->customer_id(),
                'division_id'         => 1,
                'customer_name'       => $customer,
                'customer_address'    => '-',
                'customer_phone'      => '-',
                'is_active'           => 1
            );
            $this->Customer->save($dataCust);
            $data = array(
                'transaction_id'      => $this->Transaction->transaction_id(),
                'customer_id'         => $dataCust['customer_id']
            );
            $this->Transaction->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_cart()
    {
        // $id = $this->uri->segment(2);

        // echo $id;
        // exit;
        // if(!empty($id)) {
        //     $check    = $this->Transaction->check_transaction_id($id)->result_array();
        // } else {
            $check    = $this->Transaction->check_transaction()->result_array();
        // }

        foreach ($check as $row) :
            $data = array(
                'transaction_id'    => $row['transaction_id'],
                'customer_id'       => $row['customer_id'],
                'transaction_value' => $row['transaction_value']
            );
        endforeach;

        $division = $this->Transaction->get_customer_div($data['customer_id'])->row_array();
        $product  = $this->input->post('product');
        $qty      = $this->input->post('qty');
        $price    = $this->Transaction->get_price($product, $division['division_id'])->row_array();
        $checkDetail1 = $this->Transaction->check_transaction_detail($data['transaction_id'])->result_array();

        if(empty($price)) {
            echo json_encode(array("status" => FALSE));
        } else {
            $subtotal = (int) $qty * (int) $price['price_value'];
    
            if (!empty($checkDetail1)) {
                $checkDetail2 = $this->Transaction->get_trx_detail($data['transaction_id'], $product)->row_array();
    
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
    
            $updateTRX = $this->Transaction->update(array('transaction_id' => htmlentities($data['transaction_id'])), $dataTRX);
    
            if ($updateTRX) {
                $dataDetail = array(
                    'transaction_id'     => $data['transaction_id'],
                    'product_id'         => htmlentities($product),
                    'transaction_qty'    => htmlentities($qty),
                    'transaction_price'  => htmlentities($subtotal),
                    'transaction_note'   => htmlentities($this->input->post('catatan'))
                );
    
                // $checkDetail = $this->Transaction->get_trx_detail($data['transaction_id'], $product)->row_array();
    
                // if (!empty($checkDetail)) {
                //     $this->Transaction->update_detail(array('transaction_id' => htmlentities($data['transaction_id']), 'product_id' => $product), $dataDetail);
                // } else {
                    $this->Transaction->save_detail($dataDetail);
                // }
                echo json_encode(array("status" => TRUE));
            }
        }
    }

    public function ajax_delete_detail($trx_id, $product_id)
    {
        $checkDetail  = $this->Transaction->check_transaction_detail($trx_id)->num_rows();
        $value        = $this->Transaction->get_by_id($trx_id)->row_array();
        $price        = $this->Transaction->get_by_id_detail($trx_id, $product_id)->row_array();

        $total        = (int) $value['transaction_value'] - (int) $price['transaction_price'];

        if ($checkDetail <= 1) {
            $this->Transaction->delete_by_id_trx($trx_id);
            $this->Transaction->delete_by_id($trx_id, $product_id);
        } else {
            $dataTRX = array(
                'transaction_value'   => htmlentities($total)
            );
            $this->Transaction->update(array('transaction_id' => htmlentities($trx_id)), $dataTRX);
            $this->Transaction->delete_by_id($trx_id, $product_id);
        }

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_pay()
    {
        $invoice        = $this->input->post('invoice');
        $tax            = $this->input->post('tax');
        $payment        = $this->input->post('payment');
        $product        = $this->input->post('productid');
        $stock          = $this->input->post('transactionqty');

        for ($i = 0; $i < count($product); $i++) {
            $product;
        }

        $implode = implode('|', $product);

        $currStock = $this->db->query("SELECT inventory_stock FROM t_inventory WHERE product_id REGEXP '" . $implode . "'")->result_array();

        foreach ($currStock as $curr) {
            $stok[] = array(
                'stock' => $curr['inventory_stock']
            );
        }

        for ($x = 0; $x < count($stok); $x++) {
            $laststock = (int) $stok[$x]['stock'] - (int) $stock[$x];

            $this->db->query("UPDATE t_inventory SET inventory_stock = $laststock WHERE product_id = '$product[$x]'");
        }

        $data = array(
            'transaction_pay' => $tax,
            'payment_id'      => $payment
        );

        $this->Transaction->update(array('transaction_id' => $invoice), $data);
        echo json_encode(array("status" => TRUE));
    }

	function ajax_struct()
	{
		$invoice        = $this->uri->segment(3);

		$filename = "struk_".$invoice;

		$data['list']           = $this->Transaction->check_transaction_id($invoice)->row_array();
		$data['listDetail']     = $this->Transaction->check_transaction_detail(($invoice))->result_array();

		$dompdf = $this->pdf;

		$html = $this->load->view('transaction/struct.php', $data, true);

		$dompdf->load_html($html);

		$dompdf->set_paper('A4', 'potrait');

		$dompdf->render();

		$dompdf->output();

		$dompdf->stream($filename . '.pdf', array("Attachment" => 1));
	}

	public function printStruct()
	{
		$invoice        = $this->uri->segment(3);
		
		$data['list']           = $this->Transaction->check_transaction_id($invoice)->row_array();
		$data['listDetail']     = $this->Transaction->check_transaction_detail(($invoice))->result_array();

		$data['content'] = $this->load->view('transaction/struct.php', $data);
		// $this->load->view('template/landing_template', $data);
	}

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $customer = htmlentities($this->input->post('newCust'));
        if (empty($customer)) {
            if ($this->input->post('customer') == '') {
                $data['inputerror'][] = 'customer';
                $data['error_string'][] = 'Wajib dipilih';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
