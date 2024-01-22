<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('M_Setting');
        $this->load->model('M_Akses');
        $this->load->model('Mujian');
        $this->load->model('Maksespeserta');
        $this->load->model('Mpeserta');
        $this->load->helper('tgl_indo');
        cek_login_user();
    }

    public function index()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['daftartest'] = $this->Mujian->getTest();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Test'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujian/v_daftar_test', $data);
        $this->load->view('template/footer');
    }

    public function list_test($idtest)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $cektoken = $this->Mujian->getTestDetail($idtest)->token;
        if ($cektoken == "") {
            $token = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
            $data = array(
                'token' => $token
            );
            $this->Mujian->releasetoken($data, $idtest);
        } else {
            $data['token'] = $cektoken;
        }
        $data['datatest'] = $this->Mujian->getTestDetail($idtest);
        $data['idtest'] = $idtest;
        $data['daftarpeserta'] = $this->Mujian->getPeserta($data['datatest']->ruang, $data['datatest']->rombel);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Test'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujian/v_daftar_test-detail', $data);
        $this->load->view('template/footer');
    }

    public function release_token($idtest)
    {
        $token = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
        $data = array(
            'token' => $token
        );
        $this->Mujian->releasetoken($data, $idtest);
        redirect(base_url('test/list_test/' . $idtest));
    }

    public function reset_test_peserta($idtest, $id)
    {
        $data = array(
            'status_test' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('tb_status_test', $data);
        redirect(base_url('test/list_test/' . $idtest));
    }

    public function hapus_test_peserta($idtest, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_status_test');
        redirect(base_url('test/list_test/' . $idtest));
    }

    public function hapus_test($id)
    {
        $this->db->where('id_test', $id);
        $this->db->delete('tb_status_test');

        $this->db->where('id', $id);
        $this->db->delete('tb_daftar_test');
        redirect(base_url('test'));
    }

    public function selesai_test_peserta($idtest, $id)
    {
        $betul = 0;
        $rekaman_test = $this->db->get_where('tb_status_test', array('id' => $id))->row()->rekaman;
        $rt = explode("#", $rekaman_test);
        $jml_soal = count($rt) - 1;
        for ($i = 1; $i < count($rt); $i++) {
            $hasil = explode("-", $rt[$i]);
            $cek_jawaban = $this->Maksespeserta->cekjawabanpg($hasil[0]);
            if ($cek_jawaban == $hasil[1]) {
                $betul++;
            }
        }
        $nilai = $betul / $jml_soal * 100;
        $data_akhir = array(
            'nilai' => $nilai,
            'status_test' => '2'
        );
        $this->db->where('id', $id);
        $this->db->update('tb_status_test', $data_akhir);
        redirect(base_url('test/list_test/' . $idtest));
    }

    public function ubah_test($idtest)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['idtest'] = $idtest;
        $data['daftartest'] = $this->Mujian->getTestDetail($idtest);
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Test'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujian/v_daftar_test-edit', $data);
        $this->load->view('template/footer');
    }

    public function prosestest()
    {
        $datatest = 0;
        $id_soal = $this->input->post('id_soal');
        $ruang = $this->input->post('ruang');
        $rombel = $this->input->post('rombel');
        $durasi = $this->input->post('durasi');
        $random_soal = $this->input->post('random_soal');
        $random_jawaban = $this->input->post('random_jawaban');
        $start_at = $this->input->post('date_start_at') . " " . $this->input->post('time_start_at');
        $finish_at = $this->input->post('date_finish_at') . " " . $this->input->post('time_finish_at');
        $semua_ruang = $this->input->post('semua_ruang');
        if ($semua_ruang == "1") {
            $data_ruang = $this->db->get('tb_ruang')->result();
            foreach ($data_ruang as $dr) {
                $data_rombel = $this->Mujian->getRombel($dr->ruang);
                foreach ($data_rombel as $rb) {
                    $data = [
                        'id_soal' => $id_soal,
                        'ruang' => $dr->ruang,
                        'durasi' => $durasi,
                        'random_soal' => $random_soal,
                        'random_jawaban' => $random_jawaban,
                        'start_at' => $start_at,
                        'finish_at' => $finish_at,
                        'rombel' => $rb->rombel
                    ];
                    $this->Mujian->addtest($data);
                    $datatest++;
                }
            }
            $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil ditambahhkan (' . $datatest . ')</div>');
        } else {
            $idtest = $this->input->post('idtest');
            $data = [
                'id_soal' => $id_soal,
                'ruang' => $ruang,
                'durasi' => $durasi,
                'random_soal' => $random_soal,
                'random_jawaban' => $random_jawaban,
                'start_at' => $start_at,
                'finish_at' => $finish_at,
                'rombel' => $rombel
            ];

            if ($idtest) {
                $this->Mujian->edittest($data, $idtest);
                $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil diubah</div>');
            } else {
                $this->Mujian->addtest($data);
                $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil ditambahkan</div>');
            }
        }
        redirect(base_url('test'));
    }
    
	public function all_grade()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'DAFTAR NILAI PESERTA DIDIK');
        
		$sheet->setCellValue('A2', 'No');
        $sheet->mergeCells('A2:A3');
		$sheet->setCellValue('B2', 'No Peserta');
        $sheet->mergeCells('B2:B3');
		$sheet->setCellValue('C2', 'Nama Lengkap');
        $sheet->mergeCells('C2:C3');
		$sheet->setCellValue('D2', 'Kelas');
        $sheet->mergeCells('D2:D3');
		$sheet->setCellValue('E2', 'Nilai');
        $daftar_mapel = $this->db->get('tb_soal')->result();
        $koln = 'D';
        foreach($daftar_mapel as $dm){
            $koln++;
            $sheet->setCellValue($koln.'3', $dm->judul_soal);
        }
        $sheet->mergeCells('A1:'.$koln.'1');
        $sheet->mergeCells('E2:'.$koln.'2');
        $daftar_peserta = $this->Mpeserta->getpeserta();
        $no = 1;
        $row = 4;
        foreach($daftar_peserta as $dp){
            $col = 'D';
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $no++);
            $sheet->setCellValue('C'.$row, $no++);
            $sheet->setCellValue('D'.$row, $no++);
            foreach($daftar_mapel as $dm){
                $col++;
                $nilai = $this->Mpeserta->getNilaiPeserta($dp->id, $dm->id);
                $sheet->setCellValue($col.$row, $nilai);
            }
        }

		$styleHeader = [
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

		$styleBody = [
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
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getStyle('A2:I3')->applyFromArray($styleHeader);
		$sheet->getStyle('A4:I'.$row)->applyFromArray($styleHeader);

		$writer = new Xlsx($spreadsheet);
		$filename = "Daftar Nilai Peserta";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
