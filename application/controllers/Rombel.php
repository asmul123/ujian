<?php

date_default_timezone_set('Asia/Jakarta');

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rombel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');
		$this->load->model('Mrombel');
		$this->load->model('M_Akses');

		cek_login_user();
	}

	public function index()
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['datarombel'] = $this->Mrombel->getrombel();
		$data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Rombel'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_rombel/v_rombel', $data);
		$this->load->view('template/footer');
	}

	public function tambah()
	{
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Asesi'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_rombel/v_rombel-add', $data);
		$this->load->view('template/footer');
	}

	public function add_process()
	{
		$rombel = $this->input->post('rombel', true);
		$cekRombel = $this->Mrombel->cekRombel($rombel);
		if ($cekRombel == 'kosong') {
			$data = array(
				'rombel' => $rombel
			);
			$this->Mrombel->addrombel($data);
			$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Data Rombel.
																</div>');
			redirect(base_url('rombel'));
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
			<strong>Gagal!</strong> Sudah Ada Rombel Tersebut.
			</div>');
			redirect(base_url('rombel/tambah'));
		}
	}

	public function hapus($id)
	{

		$this->Mrombel->delrombel($id);
		$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
		<strong>Sukses!</strong> Berhasil Menghapus Data Rombel.
                                        		</div>');
		redirect(base_url('rombel'));
	}

	public function ubah($id)
	{
		$id = $this->session->userdata('tipeuser');
		$data['rombel'] = $this->Mrombel->getthisrombel($id);
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Data Asesi'])->row()->id_menus;

		$this->load->view('template/header');
		$this->load->view('template/sidebar', $data);
		$this->load->view('v_rombel/v_rombel-edit', $data);
		$this->load->view('template/footer');
	}

	public function edt_process()
	{
		$rombel = $this->input->post('rombel', true);
		$id = $this->input->post('id', true);
		$cekRombel = $this->Mrombel->cekRombel($rombel);
		if ($cekRombel == 'kosong') {
			$data = array(
				'rombel' => $rombel
			);
			$this->Mrombel->editrombel($data, $id);
			$this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Menambahkan Data Rombel.
																</div>');
			redirect(base_url('rombel'));
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-warning left-icon-alert" role="alert">
			<strong>Gagal!</strong> Sudah Ada Rombel Tersebut.
			</div>');
			redirect(base_url('rombel/tambah'));
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
		$this->load->view('v_rombel/v_rombel-import', $data);
		$this->load->view('template/footer');
	}

	public function template()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'TEMPLATE ROMBEL');

		$sheet->setCellValue('A2', 'Rombel');

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
		$sheet->getStyle('A2:A3')->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);
		$filename = "Template Data Rombel";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
