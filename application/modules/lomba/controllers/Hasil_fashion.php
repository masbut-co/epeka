<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_fashion extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
	}

	public function index() {
		$fashion_aktif = $this->voting_model->getUnitFashionAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");
		$fashion_kategori = $this->voting_model->getFashionKategori()->result_array();
		if ($fashion_aktif != null) {
			$vote_unit = 0;
			$vote_unit_real = 0;
			$jlh_vote = $this->voting_model->getJumlahVoterFashion($fashion_aktif->id_unit)->row();
			if ($jlh_vote == null) {
				$vote_unit = 0;
				$vote_unit_real = 0;
			} else {
				$vote_unit = $jlh_vote->jlh_vote/sizeof($fashion_kategori)*5;
				$vote_unit_real = $jlh_vote->jlh_vote/sizeof($fashion_kategori);
			}

			$total_rating = 0;
			$total_semua_kategori = 0;

			for ($k = 0; $k < sizeof($fashion_kategori); $k++) {
				$total_rating = 0;
				for ($l = 1; $l <= 5; $l++) {
					$get_count_rating = $this->voting_model->getNilaiRatingPerBintangFashion($fashion_aktif->id_unit, $fashion_kategori[$k]['id_kategori'], $l)->row();
					$actual_rating = ($get_count_rating->jlh_bintang) * $l;
					$total_rating += $actual_rating;
				}

				$real_actual_rating = ($total_rating/1000)*100;
				$real_actual_rating = ($real_actual_rating/100)*$fashion_kategori[$k]['persentase'];
				$total_semua_kategori += $real_actual_rating;
			}

			$data = array(
				'fashion_aktif' => $fashion_aktif,
				'fashion_kategori' => $fashion_kategori,
				'curr_date' => $curr_date,
				'total_nilai' => $total_semua_kategori);
		} else {
			$data = array(
				'fashion_aktif' => $fashion_aktif,
				'fashion_kategori' => $fashion_kategori,
				'curr_date' => $curr_date);
		}

		$this->load->view('hasil_fashion_vote', $data);
	}

}