<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fashion_show extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
	}

	public function index() {
		$fashion_aktif = $this->voting_model->getUnitFashionAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");
		$fashion_kategori = $this->voting_model->getFashionKategori()->result_array();
		$data = array(
			'fashion_aktif' => $fashion_aktif,
			'fashion_kategori' => $fashion_kategori,
			'curr_date' => $curr_date);
		$this->load->view('fashion_vote', $data);
	}

	public function addVotingFashion() {
		if (!empty($_REQUEST)) {
			$fashion_kategori = $this->voting_model->getFashionKategori()->result_array();
			foreach ($fashion_kategori as $fk) {
				$voting = $this->voting_model;
				$id_kategori = $fk['id_kategori'];
				$nilai = $_POST[$fk['kategori_input']];
				$voting->addVoting($id_kategori, $nilai);
				$voting->ubahJlhPeserta();
			}
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('../../voting-sukses');
		} else {
			redirect('https://bpsdm.pu.go.id/rating-online/fashion-show');
		}
	}

}