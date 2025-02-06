<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Balai extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
	}

	public function index() {
		$id_balai = $_GET['balai'];
		//$kgt_kategori = $this->voting_model->getKategori()->result_array();
		$getkgt = $this->voting_model->getKegiatan();
		$band_aktif = $this->voting_model->getUnitBandAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");
		$band_kategori = $this->voting_model->getBandKategori()->result_array();
		$data = array(
			'band_aktif' => $band_aktif,
			'band_kategori' => $band_kategori,
			'curr_date' => $curr_date,
			'getkgt'=> $getkgt,
			// 'kgt_kategori'=> $kgt_kategori,
			'id_balai'=> $id_balai);
            $this->load->view('band_vote', $data);
	}

}