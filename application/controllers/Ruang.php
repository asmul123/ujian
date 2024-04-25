<?php

date_default_timezone_set('Asia/Jakarta');

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Ruang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');
		$this->load->model('Mruang');
		$this->load->model('M_Akses');

		cek_login_user();
	}

	public function index()
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['dataruang'] = $this->Mruang->getruang();
		$data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Ruang'])->row()->id_menus;
		
		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_ruang/v_ruang', $data);
		$this->load->view('template/footer');
	}
	
	public function daftar_ruang()
	{
		$data['dataruang'] = $this->Mruang->getruangserver();
		$this->load->view('v_ruang/v_daftar-ruang',$data);
	}

	public function generateakun()
	{
		$dataasesi = $this->Masesi->getasesi();
		$berhasil = 0;
		$gagal = 0;
		foreach ($dataasesi as $da) :
			$cekAkun = $this->Masesi->cekAkun($da->id_user);
			if ($cekAkun == "kosong") {
				$data2 = array(
					'username' => $da->no_peserta,
					'nama' => $da->nama,
					'password' => md5($da->no_peserta),
					'user_level' => '3'
				);
				$this->Masesi->adduser($data2);
				$user = $this->Masesi->cekIdUser($da->no_peserta);
				$data = array(
					'id_user' => $user->id
				);
				$this->Masesi->editasesi($data, $da->id);
				$berhasil++;
			} else {
				$gagal++;
			}
		endforeach;
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan ' . $berhasil . ' Akun Asesi, ' . $gagal . ' Akun dilewati.
																</div>');
		redirect(base_url('asesi'));
	}

	public function detail($idasesi)
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
		$data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPathDet(), $id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Asesi'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_asesi/v_asesi-detail', $data);
		$this->load->view('template/footer');
		// print_r($this->M_Siswa->getsiswadetail($nis));
	}

	public function tambah()
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['tahunaktif'] = $this->Mtahunaktif->getAll();
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Asesi'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_asesi/v_asesi-add', $data);
		$this->load->view('template/footer');
	}

	public function add_process()
	{
		$no_peserta = $this->input->post('no_peserta', true);
		$cekNopes = $this->Masesi->cekNopes($this->input->post('no_peserta', true));
		$nama = $this->input->post('nama', true);
		$kelas = $this->input->post('kelas', true);
		$tahun_aktif = $this->input->post('tahun_aktif', true);
		$username = $this->input->post('username', true);
		$cekUsername = $this->Masesi->cekUsername($this->input->post('username', true));
		$password = $this->input->post('password', true);
		$password2 = $this->input->post('password2', true);
		if ($password === $password2) {
			$password = md5($password);
		} else {
			$password = "tidaksesuai";
		}

		if ($cekNopes == 'kosong') {
			if ($cekUsername == 'kosong') {
				if ($password != 'tidaksesuai') {
					$config['upload_path']          = './assets/img/asesi/';
					$config['allowed_types']        = 'gif|jpg|png|jpeg';
					$config['max_size']             = 1024;
					$config['max_width']            = 6000;
					$config['max_height']           = 6000;
					$config['overwrite'] = TRUE;
					$config['remove_spaces'] = TRUE;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('foto')) {
						$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">' . $this->upload->display_errors() . '</div>');
						$foto = "noimage.png";
					} else {
						$foto = $this->upload->data('file_name');
					}
					$data2 = array(
						'username' => $username,
						'nama' => $nama,
						'password' => $password,
						'user_level' => '3'
					);
					$this->Masesi->adduser($data2);
					$user = $this->Masesi->cekIdUser($username);
					$data = array(
						'no_peserta' => $no_peserta,
						'nama' => $nama,
						'kelas' => $kelas,
						'foto' => $foto,
						'id_user' => $user->id,
						'tahun_aktif' => $tahun_aktif
					);
					$this->Masesi->addasesi($data);
					$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Data Asesi.
																</div>');
					redirect(base_url('asesi'));
				} else {
					$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Mohon periksa kembali Konfirmasi Kata Sandi.
		                                        		</div>');
					redirect(base_url('asesi/tambah'));
				}
			} else {
				$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Nama Pengguna sudah ada, Coba lagi.
		                                        		</div>');
				redirect(base_url('asesi/tambah'));
			}
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
			<strong>Gagal!</strong> Sudah Ada Asesi yang mempunyai No MET yang sama.
			</div>');
			redirect(base_url('asesi/tambah'));
		}
	}

	public function hapus($id, $iduser)
	{

		$this->Masesi->hapusfoto($id);
		$this->Masesi->delasesi($id);
		$this->Masesi->deluser($iduser);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
		<strong>Sukses!</strong> Berhasil Menghapus Data Asesor.
                                        		</div>');
		redirect(base_url('asesi'));
	}

	public function ubah($idasesi)
	{
		$id = $this->session->userdata('tipeuser');
		$data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
		$data['tahunaktif'] = $this->Mtahunaktif->getAll();
		$data['idasesi'] = $idasesi;
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Asesi'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_asesi/v_asesi-edit', $data);
		$this->load->view('template/footer');
	}

	public function edt_process()
	{
		$no_peserta = $this->input->post('no_peserta', true);
		$kelas = $this->input->post('kelas', true);
		$tahun_aktif = $this->input->post('tahun_aktif', true);
		$foto_lama = $this->input->post('foto_lama', true);
		$id_asesi = $this->input->post('id', true);
		$id_user = $this->input->post('id_user', true);
		$cekNopes = $this->Masesi->cekNopesU($no_met, $id_asesi);
		$nama = $this->input->post('nama', true);
		$username = $this->input->post('username', true);
		$cekUsername = $this->Masesi->cekUsernameU($username, $id_user);
		$password = $this->input->post('password', true);
		$password2 = $this->input->post('password2', true);
		if ($password === $password2) {
			$password = md5($password);
		} else {
			$password = "tidaksesuai";
		}

		if ($cekNopes == 'kosong') {
			if ($cekUsername == 'kosong') {
				if ($password != 'tidaksesuai') {
					$config['upload_path']          = './assets/img/asesi/';
					$config['allowed_types']        = 'gif|jpg|png|jpeg';
					$config['max_size']             = 1024;
					$config['max_width']            = 6000;
					$config['max_height']           = 6000;
					$config['overwrite'] = TRUE;
					$config['remove_spaces'] = TRUE;
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if ($this->upload->do_upload('foto')) {
						$foto = $this->upload->data('file_name');
						if ($foto_lama != "noimage.png") {
							unlink('./assets/img/asesi/' . $foto_lama);
						}
					} else {
						$foto = $foto_lama;
					}
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
					$this->Masesi->edituser($data2, $id_user);
					$data = array(
						'no_peserta' => $no_peserta,
						'nama' => $nama,
						'kelas' => $kelas,
						'tahun_aktif' => $tahun_aktif,
						'foto' => $foto
					);
					$this->Masesi->editasesi($data, $id_asesi);
					$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
					<strong>Sukses!</strong> Berhasil Mengubah Data Asesi.
															</div>');
					redirect(base_url('asesi'));
				} else {
					$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Mohon periksa kembali Konfirmasi Kata Sandi.
		                                        		</div>');
					redirect(base_url('asesi/ubah/' . $id_asesi));
				}
			} else {
				$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
		                                            		<strong>Gagal!</strong> Nama Pengguna ' . $username . ' sudah ada, Coba lagi.
		                                        		</div>');
				redirect(base_url('asesi/ubah/' . $id_asesi));
			}
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
			<strong>Gagal!</strong> Sudah Ada Asesi yang mempunyai No MET yang sama.
													</div>');
			redirect(base_url('asesi/ubah/' . $id_asesi));
		}
	}

	public function export()
	{

		$this->db->select('*');
		$this->db->from('tb_asesi');
		$this->db->order_by('tahun_aktif', 'DESC');
		$this->db->order_by('kelas', 'ASC');
		$this->db->order_by('nama', 'ASC');
		$asesi =	$this->db->get()->result();
		// var_dump($siswa);
		// die();
		// $this->db->query('tb_siswa', ['id_kelas' => $id])->result();
		try {
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$spreadsheet->getProperties()
				->setCreator("HOSTERWEB")
				->setLastModifiedBy("HOSTERWEB")
				->setTitle("SILSP")
				->setSubject("EXCEL ASESI")
				->setDescription(
					"Data Asesi UJIAN SMKN 1 GARUT"
				)
				->setKeywords("HOSTERWEB")
				->setCategory("excel");
			$spreadsheet->setActiveSheetIndex(0);
			$sheet->setCellValue('A1', 'DATA ASESI ');
			$sheet->mergeCells('A1:E1');

			$sheet->setCellValue('A2', 'UJIAN SMK NEGERI 1 GARUT ');
			$sheet->mergeCells('A2:E2');

			$sheet->setCellValue('A3', '');
			$sheet->mergeCells('A3:E3');

			$sheet->setCellValue('A4', 'No');
			$sheet->setCellValue('B4', 'No Peserta');
			$sheet->setCellValue('C4', 'Nama Asesi');
			$sheet->setCellValue('D4', 'Kelas');
			$sheet->setCellValue('E4', 'Tahun Aktif');

			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);

			$x = 5;
			$no = 1;
			foreach ($asesi as $row) {
				$sheet->setCellValue('A' . $x, $no++);
				$sheet->setCellValue('B' . $x, $row->no_peserta);
				$sheet->setCellValue('C' . $x, $row->nama);
				$sheet->setCellValue('D' . $x, $row->kelas);
				$sheet->setCellValue('E' . $x, $row->tahun_aktif);
				$x++;
			}
			$styleArray = [
				'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				],
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => '00000000'],
					],
				],

			];
			$row = $x - 1;
			$sheet->getStyle('A4:E' . $row)->applyFromArray($styleArray);

			$writer = new Xlsx($spreadsheet);
			$filename = 'Data Asesi ' . time();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		} catch (Exception $e) {
			echo 'Message: ' . $e->getMessage();
		}
	}

	public function import()
	{
		$id = $this->session->userdata('tipeuser');

		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Asesi'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_ruang/v_ruang-import', $data);
		$this->load->view('template/footer');
	}

	public function template()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'TEMPLATE Ruang');

		$sheet->setCellValue('A2', 'Ruang');
		$sheet->setCellValue('B2', 'Akses');
		$sheet->setCellValue('C2', 'Kode');

		$styleArray = [
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '00000000'],
				],
			],

		];
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getStyle('A2:C3')->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);
		$filename = "Template Data Ruang";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
