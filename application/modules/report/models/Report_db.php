<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_db extends CI_Model
{

	// var $table = 'customer';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function laststock(){
		$this->db->select('*');
		$this->db->from('product');
		$this->db->join('inventory', 'inventory.product_id = product.product_id', 'inner');
		$this->db->where('is_active', '1');
		// $this->db->group_by('product_id');
		$this->db->order_by('t_product.product_id', 'ASC');
		
		$query = $this->db->get();

		return $query->result_array();
	}

	public function transaction(){
		$this->db->select('*, t_transaction.created_at as date');
		$this->db->from('transaction');
		$this->db->join('transaction_detail', 'transaction_detail.transaction_id = transaction.transaction_id', 'inner');
		$this->db->join('product', 'transaction_detail.product_id = product.product_id', 'inner');
		$this->db->where('transaction_pay !=', '');
		$this->db->order_by('t_transaction.created_at', 'DESC');
		
		$query = $this->db->get();

		$results = array();

		foreach ($query->result_array() as $row) {
			if (!isset($results[$row['transaction_id']])) {
				$results[$row['transaction_id']] = array('trx_id' => $row['transaction_id']);
			}
			$results[$row['transaction_id']]['date'][]           	= $row['date'];
			$results[$row['transaction_id']]['product'][]           = $row['product_name'];
			$results[$row['transaction_id']]['qty'][]           	= $row['transaction_qty'];
			$results[$row['transaction_id']]['price'][]          	= $row['transaction_price'];
			$results[$row['transaction_id']]['note'][]           	= $row['transaction_note'];
		}

		$results = array_values($results);
		return $results;
	}

	public function transaction_filter($start, $end){
		$this->db->select('*, t_transaction.created_at as date');
		$this->db->from('transaction');
		$this->db->join('transaction_detail', 'transaction_detail.transaction_id = transaction.transaction_id', 'inner');
		$this->db->join('product', 'transaction_detail.product_id = product.product_id', 'inner');
		$this->db->where(array('transaction_pay !=' => '', 't_transaction.created_at >= ' => $start, 't_transaction.created_at <= ' => $end));
		$this->db->order_by('t_transaction.created_at', 'DESC');
		
		$query = $this->db->get();

		$results = array();

		foreach ($query->result_array() as $row) {
			if (!isset($results[$row['transaction_id']])) {
				$results[$row['transaction_id']] = array('trx_id' => $row['transaction_id']);
			}
			$results[$row['transaction_id']]['date'][]           	= $row['date'];
			$results[$row['transaction_id']]['product'][]           = $row['product_name'];
			$results[$row['transaction_id']]['qty'][]           	= $row['transaction_qty'];
			$results[$row['transaction_id']]['price'][]          	= $row['transaction_price'];
			$results[$row['transaction_id']]['note'][]           	= $row['transaction_note'];
		}

		$results = array_values($results);
		return $results;
	}
}	
