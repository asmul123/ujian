<?php

date_default_timezone_set('Asia/Jakarta');

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengguna extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');
		$this->load->model('Mpengguna');
		$this->load->model('M_Akses');

		cek_login_user();
	}

	public function index($level = NULL)
	{
		if ($this->session->userdata('tipeuser') != "1") {
			redirect(base_url('pengguna/profile'));
		}
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		if ($level == NULL) {
			$data['datapengguna'] = $this->Mpengguna->getpengguna();
		} else {
			$data['datapengguna'] = $this->Mpengguna->getpenggunafilter($level);
		}
		$data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Pengguna'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_pengguna/v_pengguna', $data);
		$this->load->view('template/footer');
	}

	public function tambah()
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Pengguna'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_pengguna/v_pengguna-add', $data);
		$this->load->view('template/footer');
	}

	public function add_process()
	{
		$nama = $this->input->post('nama', true);
		$username = $this->input->post('username', true);
		$user_level = $this->input->post('user_level', true);
		$cekUsername = $this->Mpengguna->cekUsername($this->input->post('username', true));
		$password = $this->input->post('password', true);
		$password2 = $this->input->post('password2', true);
		if ($password === $password2) {
			$password = md5($password);
		} else {
			$password = "tidaksesuai";
		}
		if ($cekUsername == 'kosong') {
			if ($password != 'tidaksesuai') {
				$data = array(
					'username' => $username,
					'nama' => $nama,
					'password' => $password,
					'user_level' => $user_level
				);
				$this->Mpengguna->adduser($data);
				$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Data Pengguna.
																</div>');
				redirect(base_url('pengguna'));
			} else {
				$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Mohon periksa kembali Konfirmasi Kata Sandi.
		                                        		</div>');
				redirect(base_url('pengguna/tambah'));
			}
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Nama Pengguna sudah ada, Coba lagi.
		                                        		</div>');
			redirect(base_url('pengguna/tambah'));
		}
	}

	public function hapus($idr)
	{

		$this->Mpengguna->delpengguna($id);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
		<strong>Sukses!</strong> Berhasil Menghapus Data Pengguna.
                                        		</div>');
		redirect(base_url('pengguna'));
	}

	public function ubah($iduser)
	{
		$id = $this->session->userdata('tipeuser');
		$data['datapengguna'] = $this->Mpengguna->getpenggunadetail($iduser);
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Pengguna'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_pengguna/v_pengguna-edit', $data);
		$this->load->view('template/footer');
	}

	public function profile()
	{
		$id = $this->session->userdata('tipeuser');
		$data['datapengguna'] = $this->Mpengguna->getpenggunadetail($this->session->userdata('id_user'));
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Profile'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_pengguna/v_pengguna-profile', $data);
		$this->load->view('template/footer');
	}

	public function edt_process()
	{
		$id = $this->input->post('id', true);
		$nama = $this->input->post('nama', true);
		$username = $this->input->post('username', true);
		$user_level = $this->input->post('user_level', true);
		$cekUsername = $this->Mpengguna->cekUsernameU($this->input->post('username', true), $id);
		$password = $this->input->post('password', true);
		$password2 = $this->input->post('password2', true);
		if ($password === $password2) {
			$password = md5($password);
		} else {
			$password = "tidaksesuai";
		}

		if ($cekUsername == 'kosong') {
			if ($password != 'tidaksesuai') {
				if ($user_level) {
					if ($this->input->post('password', true) == "") {
						$data2 = array(
							'username' => $username,
							'nama' => $nama,
							'user_level' => $user_level
						);
					} else {
						$data2 = array(
							'username' => $username,
							'nama' => $nama,
							'password' => $password,
							'user_level' => $user_level
						);
					}
				} else {
					if ($this->input->post('password', true) == "") {
						$data2 = array(
							'username' => $username,
							'nama' => $nama
						);
					} else {
						$data2 = array(
							'username' => $username,
							'nama' => $nama,
							'password' => $password
						);
					}
				}
				$this->Mpengguna->edituser($data2, $id);
				$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
					<strong>Sukses!</strong> Berhasil Mengubah Data Pengguna.
															</div>');
				redirect(base_url('pengguna'));
			} else {
				$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Mohon periksa kembali Konfirmasi Kata Sandi.
		                                        		</div>');
				redirect(base_url('pengguna/ubah/' . $id));
			}
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Nama Pengguna ' . $username . ' sudah ada, Coba lagi.
		                                        		</div>');
			redirect(base_url('pengguna/ubah/' . $id));
		}
	}
}
