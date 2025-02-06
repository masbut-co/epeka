<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stand_up extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
	}

	public function index() {
		$standup_aktif = $this->voting_model->getUnitStandupAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");
		$standup_kategori = $this->voting_model->getStandupKategori()->result_array();
		$data = array(
			'standup_aktif' => $standup_aktif,
			'standup_kategori' => $standup_kategori,
			'curr_date' => $curr_date);
		$this->load->view('standup_vote', $data);
	}

	public function addVotingStandup() {
		if (!empty($_REQUEST)) {
			$standup_kategori = $this->voting_model->getStandupKategori()->result_array();
			foreach ($standup_kategori as $sk) {
				$voting = $this->voting_model;
				$id_kategori = $sk['id_kategori'];
				$nilai = $_POST[$sk['kategori_input']];
				$voting->addVoting($id_kategori, $nilai);
				$voting->ubahJlhPeserta();
			}
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('../../voting-sukses');
		} else {
			redirect('https://bpsdm.pu.go.id/rating-online/stand-up');
		}
	}

}