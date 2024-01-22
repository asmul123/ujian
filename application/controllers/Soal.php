<?php

date_default_timezone_set('Asia/Jakarta');

defined('BASEPATH') or exit('No direct script access allowed');

class Soal extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');
		$this->load->model('Msoal');
		$this->load->model('M_Akses');

		cek_login_user();
	}

	public function index()
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['soal'] = $this->Msoal->getSoal();
		// $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Soal'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_soal/v_daftar_soal', $data);
		$this->load->view('template/footer');
	}

	public function detail($id_soal)
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['soal'] = $this->Msoal->getDetailbyID($id_soal);
		$data['id_soal'] = $id_soal;
		// $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Soal'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_soal/v_detail_soal', $data);
		$this->load->view('template/footer');
	}

	public function tambah_detail()
	{
		$id_soal = $this->input->post('id_soal', true);
		$kunci = $this->input->post('kunci', true);
		$pertanyaan = $this->input->post('pertanyaan', false);
		$jawaban = "#_#";
		for ($i = 1; $i <= 6; $i++) {
			$jawaban = $jawaban . $i . "_#_" . $this->input->post('jawaban' . $i, false) . "#_#";
		}
		if ($id_soal != "") {
			$data = array(
				'id_soal' => $id_soal,
				'pertanyaan' => $pertanyaan,
				'kunci' => $kunci,
				'jawaban' => $jawaban
			);
			$this->Msoal->addSoalDetail($data);
			$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Pertanyaan.
																</div>');
			redirect(base_url('soal/detail/' . $id_soal));
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert">
																<strong>Gagal!</strong> Menambahkan Pertanyaan.
																</div>');
			redirect(base_url('soal/detail/' . $id_soal));
		}
	}

	public function ubah_detail()
	{
		$id = $this->input->post('id', true);
		$id_soal = $this->input->post('id_soal', true);
		$kunci = $this->input->post('kunci', true);
		$pertanyaan = $this->input->post('pertanyaan', false);
		$jawaban = "#_#";
		for ($i = 1; $i <= 6; $i++) {
			$jawaban = $jawaban . $i . "_#_" . $this->input->post('jawaban' . $i, false) . "#_#";
		}
		if ($id_soal != "") {
			$data = array(
				'id_soal' => $id_soal,
				'pertanyaan' => $pertanyaan,
				'kunci' => $kunci,
				'jawaban' => $jawaban
			);
			$this->Msoal->ubahSoalDetail($data, $id);
			$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Pertanyaan.
																</div>');
			redirect(base_url('soal/detail/' . $id_soal));
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert">
																<strong>Gagal!</strong> Menambahkan Pertanyaan.
																</div>');
			redirect(base_url('soal/detail/' . $id_soal));
		}
	}

	public function tambah()
	{
		$judul_soal = $this->input->post('judul_soal', true);
		$data = array(
			'judul_soal' => $judul_soal
		);
		$this->Msoal->addSoal($data);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Soal.
																</div>');
		redirect(base_url('soal'));
	}

	public function ubah()
	{
		$judul_soal = $this->input->post('judul_soal', true);
		$id_soal = $this->input->post('id_soal', true);
		$data = array(
			'judul_soal' => $judul_soal
		);
		$this->Msoal->ubahSoal($data, $id_soal);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Mengubah Soal.
																</div>');
		redirect(base_url('soal'));
	}

	public function hapus($id)
	{
		if ($id) {
			$this->Msoal->hapusSoal($id);
			$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Mengubah Soal.
																</div>');
		}
		redirect(base_url('soal'));
	}

	public function hapus_detail($id, $id_soal)
	{
		if ($id) {
			$this->Msoal->hapusDetailSoal($id);
			$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Mengubah Soal.
																</div>');
		}
		redirect(base_url('soal/detail/' . $id_soal));
	}

	public function edt_process()
	{
		$id = $this->input->post('id', true);
		$id_skema = $this->input->post('id_skema', true);
		$id_unit = $this->input->post('id_unit', true);
		$pertanyaan = $this->input->post('pertanyaan', false);
		$data = array(
			'id_unit' => $id_unit,
			'pertanyaan' => $pertanyaan
		);
		$this->Mfria05->editfria05($data, $id);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Mengubah Pertanyaan.
																</div>');
		redirect(base_url('fria05/index/' . $id_skema));
	}

	public function repair_skema()
	{
		echo $this->Mfria05->repair_skema();
	}

	public function cetaksoal($idskema)
	{
		$data['dataskema'] = $this->Mskema->getskemadetail($idskema);
		$data['datafria05'] = $this->Mfria05->getfria05($idskema);
		$data['dataunit'] = $this->Mfria05->getunitfria05($idskema);
		$data['idskema'] = $idskema;
		$this->load->view('template/header_cetak');
		$this->load->view('v_fria05/v_fria05-cetak', $data);
		$this->load->view('template/footer_cetak');
	}

	public function cetakkunci($idskema)
	{
		$data['dataskema'] = $this->Mskema->getskemadetail($idskema);
		$data['datafria05'] = $this->Mfria05->getfria05($idskema);
		$data['dataunit'] = $this->Mfria05->getunitfria05($idskema);
		$data['idskema'] = $idskema;
		$this->load->view('template/header_cetak');
		$this->load->view('v_fria05/v_fria05-kunci', $data);
		$this->load->view('template/footer_cetak');
	}

	public function cetakjawaban($idskema)
	{
		$data['dataskema'] = $this->Mskema->getskemadetail($idskema);
		$data['datafria05'] = $this->Mfria05->getfria05($idskema);
		$data['dataunit'] = $this->Mfria05->getunitfria05($idskema);
		$data['idskema'] = $idskema;
		$this->load->view('template/header_cetak');
		$this->load->view('v_fria05/v_fria05-jawaban', $data);
		$this->load->view('template/footer_cetak');
	}
}
