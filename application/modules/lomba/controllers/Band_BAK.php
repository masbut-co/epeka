<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Band extends MX_Controller {

	public function __construct(){
		parent::__construct();		
		$this->load->model('voting_model');
		$this->load->helper(array('form', 'url'));
	}

	public function index() {
		$this->load->view('landing_page');
	}

    public function balai() {
        $id_balai = $_GET['balai'];
		//$kgt_kategori = $this->voting_model->getKategori()->result_array();
		$getkgt = $this->voting_model->getKegiatan($id_balai);
		$band_aktif = $this->voting_model->getUnitBandAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");

        $id_kegiatan = $this->input->post('id_kegiatan');
		
		$data = array(
			'band_aktif' => $band_aktif,
			'curr_date' => $curr_date,
			'getkgt'=> $getkgt,
			// 'kgt_kategori'=> $kgt_kategori,
			'id_balai'=> $id_balai);
		$this->load->view('band_vote', $data);
    }

    public function baalaikat() {
        $id_kegiatan = $this->input->post('id_kegiatan');
        $data = $this->voting_model->getBandKategori($id_kegiatan)->result_array();
        echo json_encode($data);
    }

	public function addVotingBand() {
		//captcha
		 if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
			$captcha = $_POST['g-recaptcha-response'];
		} else {
			$this->session->set_flashdata('error', 'Mohon isi captcha.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		$secret = '6Le1IXwqAAAAAI_eZo9_v5_vCdPZs510pYgX6xPT'; // **PENTING:** Pindahkan ke file konfigurasi atau environment variable
		$remoteIp = $_SERVER['REMOTE_ADDR'];
	
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $remoteIp;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
	
		if ($response === false) {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat verifikasi captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		$response = json_decode($response);
	
		if (json_last_error() !== JSON_ERROR_NONE) {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		if ($response->success === false) {
			$this->session->set_flashdata('error', 'Captcha tidak valid. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		if ($response->score <= 0.7) {
			$this->session->set_flashdata('error', 'Anda dicurigai sebagai robot.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		// Captcha berhasil, lanjutkan proses voting
		if (!empty($_POST)) { 	
			$id_balai = $_POST['id_balai'];
			$id_kegiatan = $_POST['kgt'];
			// $id_kategori = $_POST['kategori'];
			$usia = $_POST['usia'];
			$pend = $_POST['pend'];
			$gender = $_POST['gender'];
			$email = $_POST['email'];
			$nohp = $_POST['nohp'];

			$band_kategori = $this->voting_model->getBandKategori($id_kegiatan)->result_array();
			foreach ($band_kategori as $bk) {
				$voting = $this->voting_model;
				$id_kategori = $bk['id_kategori'];
				$nil = 'nil_'.$bk['id_kategori'];
				$saran = 'saran_'.$bk['id_kategori'];
				if ($_POST[$nil] != 0) {
					// echo $id_kegiatan.'<>'.$id_kategori.'<>'. $_POST[$nil]. '<>'.$_POST[$saran]. '<>'.$email. '<>'.$nohp.'<>'. $id_balai. '<>'.$usia.'<>'. $pend. '<>'.$gender;
					$voting->addVoting($id_kegiatan, $id_kategori, $_POST[$nil], $_POST[$saran], $email, $nohp, $id_balai, $usia, $pend, $gender);
				}
			}
			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('../../voting-sukses');

		} else {
			redirect('https://bpsdm.pu.go.id/sipeka');
		}
	}

	public function addKeluhanBand() {
		//captcha
		if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
			$captcha = $_POST['g-recaptcha-response'];
		} else {
			$this->session->set_flashdata('error', 'Mohon isi captcha.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		$secret = '6Le1IXwqAAAAAI_eZo9_v5_vCdPZs510pYgX6xPT'; // **PENTING:** Pindahkan ke file konfigurasi atau environment variable
		$remoteIp = $_SERVER['REMOTE_ADDR'];
	
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $remoteIp;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
	
		if ($response === false) {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat verifikasi captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		$response = json_decode($response);
	
		if (json_last_error() !== JSON_ERROR_NONE) {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		if ($response->success === false) {
			$this->session->set_flashdata('error', 'Captcha tidak valid. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		if ($response->score <= 0.7) {
			$this->session->set_flashdata('error', 'Anda dicurigai sebagai robot.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return; // Hentikan eksekusi fungsi
		}
	
		// Captcha berhasil, lanjutkan proses voting
		if (!empty($_REQUEST)) {
			$id_balai = $_POST['id_balai'];
			$email = $_POST['email'];
			$nohp = $_POST['nohp'];
			$keluhan = $_POST['keluhan'];
			$voting = $this->voting_model;

			$config['upload_path'] = './upload/keluhan';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size'] = 6200;
			$config['file_name'] = 'keluhan_'.$id_balai.'_time_'.date("Y_m_d_h_i_s");

			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('gambar'))
			{
				$error = array('error' => $this->upload->display_errors());
				echo 'ERROR';
				die();
			}

			$voting->addKeluhan($keluhan, $config['file_name'], $email, $nohp, $id_balai);

			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('../../voting-sukses');
		} else {
			redirect('https://bpsdm.pu.go.id/sipeka');
		}
	}

    public function layanan() {
        $id_balai = $_GET['balai'];
        $layanan = $_GET['layanan'];
		//$kgt_kategori = $this->voting_model->getKategori()->result_array();
		$getkgt = $this->voting_model->getKegiatan($id_balai);
		$band_aktif = $this->voting_model->getUnitBandAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");

        $id_kegiatan = $this->input->post('id_kegiatan');
		
		$data = array(
			'band_aktif' => $band_aktif,
			'curr_date' => $curr_date,
			'getkgt'=> $getkgt,
			'id_balai'=> $id_balai);
		$this->load->view('band_vote_layanan', $data);
    }

	public function keluhan() {
        $id_balai = $_GET['balai'];
        $layanan = $_GET['layanan'];
		$getkgt = $this->voting_model->getKegiatan($id_balai);
		$band_aktif = $this->voting_model->getUnitBandAktif()->row();
		date_default_timezone_set("Asia/Jakarta");
		$curr_date = date("Y-m-d H:i:s");

        $id_kegiatan = $this->input->post('id_kegiatan');
		
		$data = array(
			'band_aktif' => $band_aktif,
			'curr_date' => $curr_date,
			'getkgt'=> $getkgt,
			'id_balai'=> $id_balai);
		$this->load->view('band_vote_keluhan', $data);
    }

}