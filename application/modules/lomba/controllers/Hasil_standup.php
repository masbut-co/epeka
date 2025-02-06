<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_standup extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
	}

	public function index() {
		$standup_aktif = $this->voting_model->getUnitStandupAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");
		$standup_kategori = $this->voting_model->getStandupKategori()->result_array();
		if ($standup_aktif != null) {
			$vote_unit = 0;
			$vote_unit_real = 0;
			$jlh_vote = $this->voting_model->getJumlahVoterStandup($standup_aktif->id_unit)->row();
			if ($jlh_vote == null) {
				$vote_unit = 0;
				$vote_unit_real = 0;
			} else {
				$vote_unit = $jlh_vote->jlh_vote/sizeof($standup_kategori)*5;
				$vote_unit_real = $jlh_vote->jlh_vote/sizeof($standup_kategori);
			}

			$total_rating = 0;
			$total_semua_kategori = 0;

			for ($k = 0; $k < sizeof($standup_kategori); $k++) {
				$total_rating = 0;
				for ($l = 1; $l <= 5; $l++) {
					$get_count_rating = $this->voting_model->getNilaiRatingPerBintangStandup($standup_aktif->id_unit, $standup_kategori[$k]['id_kategori'], $l)->row();
					$actual_rating = ($get_count_rating->jlh_bintang) * $l;
					$total_rating += $actual_rating;
				}

				$real_actual_rating = ($total_rating/1000)*100;
				$real_actual_rating = ($real_actual_rating/100)*$standup_kategori[$k]['persentase'];
				$total_semua_kategori += $real_actual_rating;
			}

			$data = array(
				'standup_aktif' => $standup_aktif,
				'standup_kategori' => $standup_kategori,
				'curr_date' => $curr_date,
				'total_nilai' => $total_semua_kategori);
		} else {
			$data = array(
				'standup_aktif' => $standup_aktif,
				'standup_kategori' => $standup_kategori,
				'curr_date' => $curr_date);
		}

		$this->load->view('hasil_standup_vote', $data);
	}

}