<?php
defined('BASEPATH') or exit('No direct script access allowed');

class penjualan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('db_model');
	}

	public function index()
	{
		//echo  'hello panda';
		$this->template->load('template', 'penjualan_view');
	}

	public function list()
	{
		echo json_encode($this->db_model->get_all("tbl_jasa")->result());
	}
	public function list_client()
	{
		echo json_encode($this->db_model->get_all("tbl_client")->result());
	}
	public function transaksi()
	{
		date_default_timezone_set('Asia/Jakarta');
		$tgl = date('Y-m-d');

		$data = [
			"id_pengguna" => 1,
			"tgl_transaksi" => $tgl
		];
		echo json_encode($this->db_model->insert_get("tbl_transaksi", $data));
	}
	public function jual_hutang()
	{
		$data = [
			"id_transaksi" => $this->input->post("id", TRUE),
			"tgl_jatuh_tempo" => $this->input->post("tgl", TRUE),
			"id_client" => $this->input->post("client", TRUE),
			"status_piutang" => 0
		];
		echo json_encode($this->db_model->insert('tbl_piutang', $data));
	}
	public function barang_insert()
	{
		$data = [
			"id_transaksi" => $this->input->post("id_transaksi", TRUE),
			"id_barang" => $this->input->post("id_barang", TRUE),
			"jumlah_penjualan" => $this->input->post("jumlah", TRUE),
			"harga_jual" => $this->input->post("harga", TRUE),
			"harga_kulak" => $this->input->post("harga_kulak", TRUE)
		];
		$this->db_model->insert('tbl_penjualan', $data);

		$lama = (int) $this->input->post("stok", TRUE) - (int)$this->input->post("jumlah", TRUE);
		$data = [
			"stok_barang" =>  $lama
		];

		$this->db_model->update('tbl_barang', $data, array('id_barang' => $this->input->post('id_barang', TRUE)));

		echo json_encode('');
	}
	public function jasa_insert()
	{
		$data = [
			"id_transaksi" => $this->input->post("id_transaksi", TRUE),
			"id_jasa" => $this->input->post("id_jasa", TRUE),
		];
		echo json_encode($this->db_model->insert('tbl_penjualan_jasa', $data));
	}
}
