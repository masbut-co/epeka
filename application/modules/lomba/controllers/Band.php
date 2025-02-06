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
		$id_kegiatan = $this->input->post('id_kegiatan', TRUE); // XSS filtering
	
		// Validasi input $id_kegiatan
		if (!is_numeric($id_kegiatan) || $id_kegiatan <= 0) {
			// Handle invalid input
			echo json_encode(['error' => 'Invalid ID Kegiatan']); // Return error as JSON
			return;
		}
	
		$data = $this->voting_model->getBandKategori($id_kegiatan)->result_array();
	
		// Selalu escape output JSON untuk mencegah XSS
		echo json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); 
    }

	public function addVotingBand() {
		// secret key di file config
		$secret = $this->config->item('recaptcha_secret_key');

		// Validasi reCAPTCHA
		$recaptcha_response = $this->input->post('g-recaptcha-response', TRUE); // Sanitasi input

		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Mohon isi captcha.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}

		$remoteIp = $this->input->get_request_header('X-Forwarded-For', TRUE); // Dapatkan IP address yang aman
		if ($remoteIp === null) {
			$remoteIp = $_SERVER['REMOTE_ADDR'];
		}

		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptcha_response . "&remoteip=" . $remoteIp;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Pastikan verifikasi SSL
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Periksa HTTP status code
		curl_close($ch);

		if ($response === false || $httpCode !== 200) {  // Periksa kesalahan dan HTTP status code
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat verifikasi captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}

		$response = json_decode($response);

		if (json_last_error() !== JSON_ERROR_NONE) {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}

		if (!isset($response->success) || $response->success === false || !isset($response->score) || $response->score <= 0.7) { // validasi dari server G-RecapC, pastikan properti ada
			$this->session->set_flashdata('error', 'Captcha tidak valid atau Anda dicurigai sebagai robot. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}


		// Lanjutkan proses voting setelah validasi reCAPTCHA
		if (!empty($_POST)) {
			// Sanitasi input menggunakan xss_clean
			$id_balai = $this->input->post('id_balai', TRUE);
			$id_kegiatan = $this->input->post('kgt', TRUE);
			$usia = $this->input->post('usia', TRUE);
			$pend = $this->input->post('pend', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$email = $this->security->xss_clean($this->input->post('email', TRUE)); // Sanitasi email
			$nohp = $this->input->post('nohp', TRUE);

			$band_kategori = $this->voting_model->getBandKategori($id_kegiatan)->result_array();
			foreach ($band_kategori as $bk) {
				$voting = $this->voting_model;
				$id_kategori = $bk['id_kategori'];
				$nil = 'nil_'.$bk['id_kategori'];
				$saran = 'saran_'.$bk['id_kategori'];
				// Sanitasi input di dalam loop
				$nilai = $this->input->post($nil, TRUE);
				$saran_value = $this->security->xss_clean($this->input->post($saran, TRUE)); // Sanitasi saran

				if ($nilai != 0) {
					$voting->addVoting($id_kegiatan, $id_kategori, $nilai, $saran_value, $email, $nohp, $id_balai, $usia, $pend, $gender);
				}
			}

			$this->session->set_flashdata('success', 'Berhasil disimpan');
			redirect('../../voting-sukses');

		} else {
			redirect('https://bpsdm.pu.go.id/sipeka');
		}
	}

	public function addKeluhanBand() {
		// secret key di file config
		$secret = $this->config->item('recaptcha_secret_key');

		// Validasi reCAPTCHA
		$recaptcha_response = $this->input->post('g-recaptcha-response', TRUE); // Sanitasi input

		if (empty($recaptcha_response)) {
			$this->session->set_flashdata('error', 'Mohon isi captcha.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}

		$remoteIp = $this->input->get_request_header('X-Forwarded-For', TRUE); // Dapatkan IP address yang aman
		if ($remoteIp === null) {
			$remoteIp = $_SERVER['REMOTE_ADDR'];
		}

		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptcha_response . "&remoteip=" . $remoteIp;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Pastikan verifikasi SSL
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Periksa HTTP status code
		curl_close($ch);

		if ($response === false || $httpCode !== 200) {  // Periksa kesalahan dan HTTP status code
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat verifikasi captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}

		$response = json_decode($response);

		if (json_last_error() !== JSON_ERROR_NONE) {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses captcha. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}

		if (!isset($response->success) || $response->success === false || !isset($response->score) || $response->score <= 0.7) { // validasi dari server G-RecapC, pastikan properti ada
			$this->session->set_flashdata('error', 'Captcha tidak valid atau Anda dicurigai sebagai robot. Silakan coba lagi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}
	
		// Captcha berhasil, lanjutkan proses
		$id_balai = $this->input->post('id_balai', TRUE); // Menggunakan input class dan xss filtering
		$email = $this->input->post('email', TRUE); // XSS filtering
		$nohp = $this->input->post('nohp', TRUE); // XSS filtering
		$keluhan = $this->input->post('keluhan', TRUE); // XSS filtering
	
		// Validasi Input (gunakan library validasi CodeIgniter jika memungkinkan)
		$this->load->library('form_validation');
		$this->form_validation->set_rules('keluhan', 'Keluhan', 'required');
		$this->form_validation->set_rules('nohp', 'No HP', 'required|numeric|min_length[10]|max_length[13]');
		$this->form_validation->set_rules('email', 'Email', 'valid_email');
	
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('../sipeka'); // Gunakan URL yang lebih spesifik
			return;
		}

		// Validasi Input Lebih Lanjut (Sisi Server)
		if (empty($keluhan) || empty($nohp)) { // Pastikan keluhan dan nohp tidak kosong
			$this->session->set_flashdata('error', 'Keluhan dan No HP harus diisi.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}
	
		// Validasi format email (sisi server)
		if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('error', 'Format email tidak valid.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}
	
		// Validasi No HP (contoh: hanya angka dan panjang tertentu)
		if (!preg_match('/^[0-9]{10,13}$/', $nohp)) {  // Contoh validasi 10-13 digit angka
			$this->session->set_flashdata('error', 'Format No HP tidak valid.');
			redirect('https://bpsdm.pu.go.id/sipeka');
			return;
		}
	
		// Konfigurasi upload
		$config['upload_path']          = './uploads/keluhan/'; // Direktori upload
		$config['allowed_types']        = 'jpg|png'; // Tipe file yang diizinkan
		$config['max_size']             = 6200; // Ukuran file maksimum (1MB)
		$config['encrypt_name'] = TRUE; // Enkripsi nama file
		// $config['file_name'] = 'keluhan_'.$id_balai.'_time_'.date("Y_m_d_h_i_s");

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('gambar'))
		{
			$error = $this->upload->display_errors(); // Ambil pesan error
			$this->session->set_flashdata('error', $error); // Tampilkan pesan error ke pengguna
			redirect('https://bpsdm.pu.go.id/sipeka'); // Redirect kembali ke form
			return; // Stop eksekusi
		}
	
		$voting = $this->voting_model;
		$voting->addKeluhan($keluhan, $config['file_name'], $email, $nohp, $id_balai);
	
		$this->session->set_flashdata('success', 'Berhasil disimpan');
		redirect('../voting/sukses');
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