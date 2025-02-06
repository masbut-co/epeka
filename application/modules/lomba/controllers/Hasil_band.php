<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_band extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
	}

	public function index() {
		$band_aktif = $this->voting_model->getUnitBandAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");
		$band_kategori = $this->voting_model->getBandKategori()->result_array();
		if ($band_aktif != null) {
			$vote_unit = 0;
			$vote_unit_real = 0;
			$jlh_vote = $this->voting_model->getJumlahVoterBand($band_aktif->id_unit)->row();
			if ($jlh_vote == null) {
				$vote_unit = 0;
				$vote_unit_real = 0;
			} else {
				$vote_unit = $jlh_vote->jlh_vote/sizeof($band_kategori)*5;
				$vote_unit_real = $jlh_vote->jlh_vote/sizeof($band_kategori);
			}

			$total_rating = 0;
			$total_semua_kategori = 0;

			for ($k = 0; $k < sizeof($band_kategori); $k++) {
				$total_rating = 0;
				for ($l = 1; $l <= 5; $l++) {
					$get_count_rating = $this->voting_model->getNilaiRatingPerBintangBand($band_aktif->id_unit, $band_kategori[$k]['id_kategori'], $l)->row();
					$actual_rating = ($get_count_rating->jlh_bintang) * $l;
					$total_rating += $actual_rating;
				}

				$real_actual_rating = ($total_rating/1000)*100;
				$real_actual_rating = ($real_actual_rating/100)*$band_kategori[$k]['persentase'];
				$total_semua_kategori += $real_actual_rating;
			}

			$data = array(
				'band_aktif' => $band_aktif,
				'band_kategori' => $band_kategori,
				'curr_date' => $curr_date,
				'total_nilai' => $total_semua_kategori);
		} else {
			$data = array(
				'band_aktif' => $band_aktif,
				'band_kategori' => $band_kategori,
				'curr_date' => $curr_date);
		}

		$this->load->view('hasil_band_vote', $data);
	}

}