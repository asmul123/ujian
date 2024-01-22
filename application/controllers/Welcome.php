<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');
		cek_login_user();
	}

	public function index()
	{
		// var_dump($this->session);
		$id = $this->session->userdata('tipeuser');

		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = '';

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		if ($this->session->userdata('tipeuser') == 1) {
			$this->load->view('template/index', $data);
		} else if ($this->session->userdata('tipeuser') == 2) {
			redirect(base_url('aksespengawas'));
		} else if ($this->session->userdata('tipeuser') == 3) {
			redirect(base_url('aksespeserta'));
		} else {
			redirect(base_url('clogin/logout'));
		}
		$this->load->view('template/footer');
	}
}
