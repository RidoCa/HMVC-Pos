<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
		$this->load->library('pdf');
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('report/Report_db', 'Report');
    }

    public function laststock()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Report->laststock();

        $data['content'] = $this->load->view('report/laststock.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

	function pdfLaststock()
	{
		ob_clean();
		$filename = "laporan_stok_barang";

		$data['list'] = $this->Report->laststock();

		$dompdf = $this->pdf;

		$html = $this->load->view('report/laststock_pdf.php', $data, true);

		$dompdf->load_html($html);

		$dompdf->set_paper('A4', 'potrait');

		$dompdf->render();

		$dompdf->output();

		$dompdf->stream($filename . '.pdf', array("Attachment" => 1));
	}

	public function printLaststock()
	{
		$data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
		$data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
		$data['list'] = $this->Report->laststock();

		$data['content'] = $this->load->view('report/laststock_pdf.php', $data);
		// $this->load->view('template/landing_template', $data);
	}

	public function transaction()
	{	
		$this->session->unset_userdata('start');
		$this->session->unset_userdata('end');
		$data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
		$data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
		$data['list'] = $this->Report->transaction();

		$data['content'] = $this->load->view('report/transaction.php', $data, true);
		$this->load->view('template/landing_template', $data);
	}

	public function filter() {
		$start = $this->input->post('start');
		$end   = $this->input->post('finish');
		$sess = array(
			"start" => $start,
			"end"   => $end
		);
		$this->session->set_userdata($sess);
		$data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
		$data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
		$data['list'] = $this->Report->transaction_filter($start." 00:00:00", $end." 23:59:59");

		$data['content'] = $this->load->view('report/transaction.php', $data, true);
		$this->load->view('template/landing_template', $data);
	}

	function pdfTransaction()
	{
		ob_clean();

		$start  = $this->session->userdata('start');
		$finish = $this->session->userdata('end');
		
		$filename = "laporan_transaksi";

		if(empty($start) && empty($finish)) {
			$data['list'] = $this->Report->transaction();
		} else {
			$data['list'] = $this->Report->transaction_filter($start . " 00:00:00", $finish . " 23:59:59");
		}

		$dompdf = $this->pdf;

		$html = $this->load->view('report/transaction_pdf.php', $data, true);

		$dompdf->load_html($html);

		$dompdf->set_paper('A4', 'potrait');

		$dompdf->render();

		$dompdf->output();

		$dompdf->stream($filename . '.pdf', array("Attachment" => 1));
	}

	public function printTransaction()
	{
		$start  = $this->session->userdata('start');
		$finish = $this->session->userdata('end');
		$data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
		$data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
		if (empty($start) && empty($finish)) {
			$data['list'] = $this->Report->transaction();
		} else {
			$data['list'] = $this->Report->transaction_filter($start . " 00:00:00", $finish . " 23:59:59");
		}

		$data['content'] = $this->load->view('report/transaction_pdf.php', $data);
		// $this->load->view('template/landing_template', $data);
	}
}
