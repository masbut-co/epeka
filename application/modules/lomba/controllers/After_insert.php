<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class After_insert extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
	}

	public function index() {
		$this->load->view('daftar_sukses');
	}

}