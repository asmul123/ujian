<?php

date_default_timezone_set('Asia/Jakarta');

defined('BASEPATH') or exit('No direct script access allowed');

class Aksespeserta extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('M_Setting');
		$this->load->model('Maksespeserta');
		$this->load->model('Mpeserta');
		$this->load->model('Msoal');
		$this->load->model('M_Akses');
		$this->load->helper('tgl_indo');
		cek_login_user();
	}

	public function index()
	{
		if ($this->session->userdata('id_test')) {
			redirect(base_url('aksespeserta/soal_test'));
		}
		$this->load->view('template/header');
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$datapeserta = $this->Maksespeserta->getDetailPeserta($this->session->userdata('id_user'));
		$data['daftartest'] = $this->Maksespeserta->getTest($datapeserta->ruang, $datapeserta->rombel);
		$data['idpeserta'] = $datapeserta->id;
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Daftar Test'])->row()->id_menus;

		$this->load->view('template/sidebar', $data);
		$this->load->view('v_akses-peserta/v_daftar_test', $data);
		$this->load->view('template/footer');
	}

	public function mulai_test($idtest)
	{

		$datapeserta = $this->Maksespeserta->getDetailPeserta($this->session->userdata('id_user'));
		$data_status_test = $this->Maksespeserta->gettestpeserta($datapeserta->id, $idtest);
		if ($this->session->userdata('id_test')) {
			redirect(base_url('aksespeserta/soal_test'));
		} else if ($data_status_test->num_rows() >= 1) {
			if ($data_status_test->row()->status_test == '2') {
				redirect(base_url('aksespeserta'));
			}
		}
		$this->load->view('template/header');
		$id = $this->session->userdata('tipeuser');
		$data['menu'] = $this->M_Setting->getmenu1($id);
		$data['idpeserta'] = $datapeserta->id;
		$data['data_test'] = $this->Maksespeserta->gettestdet($idtest)->row();
		$data['idtest'] = $idtest;
		$data['data_peserta'] = $datapeserta;
		$data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Daftar Test'])->row()->id_menus;

		$this->load->view('v_akses-peserta/v_konfirmasi-test', $data);
		$this->load->view('template/footer');
	}

	public function soal_test($no = null)
	{
		$data['idpeserta'] = $this->Mpeserta->getpesertadetail($this->session->userdata('id_user'))['idpes'];
		$data_status_test = $this->Maksespeserta->gettestpeserta($data['idpeserta'], $this->session->userdata('id_test'));
		if ($no == null) {
			$no = $this->input->post('no', true);
		}
		$no_soal = $this->input->post('no_soal', true);
		$soal = $this->input->post('soal', true);
		$jawaban = $this->input->post('jawaban', true);
		if ($jawaban) {
			$rekaman_lama = $data_status_test->row()->rekaman;
			$rl = explode("#", $rekaman_lama);
			$new_ans = array(
				$no_soal => $soal . '-' . $jawaban
			);
			$update = array_replace($rl, $new_ans);
			$rek = "";
			for ($i = 1; $i < count($update); $i++) {
				$rek = $rek . "#" . $update[$i];
			}
			$data_ans = array(
				'rekaman' => $rek
			);
			$this->db->where('id_test', $this->session->userdata('id_test'));
			$this->db->where('id_peserta', $data['idpeserta']);
			$this->db->update('tb_status_test', $data_ans);
		}
		if ($no == "akhir") {
			$betul = 0;
			$data_status_test = $this->Maksespeserta->gettestpeserta($data['idpeserta'], $this->session->userdata('id_test'));
			$rekaman_test = $data_status_test->row()->rekaman;
			$rt = explode("#", $rekaman_test);
			$jml_soal = count($rt) - 1;
			for ($i = 1; $i < count($rt); $i++) {
				$hasil = explode("-", $rt[$i]);
				$cek_jawaban = $this->Maksespeserta->cekjawabanpg($hasil[0]);
				if ($cek_jawaban == $hasil[1]) {
					// 		$kom = 'K';
					$betul++;
				}
			}
			$nilai = $betul / $jml_soal * 100;
			$data_akhir = array(
				'nilai' => $nilai,
				'status_test' => '2'
			);
			$this->db->where('id_test', $this->session->userdata('id_test'));
			$this->db->where('id_peserta', $data['idpeserta']);
			$this->db->update('tb_status_test', $data_akhir);
			$this->session->unset_userdata('id_test');
			redirect(base_url('aksespeserta'));
		}
		if ($this->session->userdata('id_test')) {
			$data_test = $this->Maksespeserta->gettestdet($this->session->userdata('id_test'))->row();
			if ($data_status_test->num_rows() >= 1) {
				if ($data_status_test->row()->status_test == "2") {
					$this->session->unset_userdata('id_test');
					$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert"> <strong>Gagal!</strong> Anda telah menyelesaikan test ini</div>');
					redirect(base_url('aksespeserta'));
				} else if ($data_status_test->row()->start_at == "0000-00-00 00:00:00"){
					$id_test = $this->session->userdata('id_test');
					$data_login = array(
					'start_at' => date('Y-m-d H:i:s')
					);
				$this->Maksespeserta->edtpesertatest($data_login, $id_test, $data['idpeserta']);					
				}
			} else {
				if ($data_test->random_soal == 1) {
					$datasoal = $this->Maksespeserta->getsoalpg($data_test->id_soal, 'Y');
					$rekaman = "";
					foreach ($datasoal as $ds) {
						$rekaman = $rekaman . "#" . $ds->id . "-0";
					}
				} else {
					$datasoal = $this->Maksespeserta->getsoalpg($data_test->id_soal);
					$rekaman = "";
					foreach ($datasoal as $ds) {
						$rekaman = $rekaman . "#" . $ds->id . "-0";
					}
				}
				$data_awal = array(
					'id_peserta' => $data['idpeserta'],
					'id_test' => $this->session->userdata('id_test'),
					'rekaman' => $rekaman,
					'start_at' => date('Y-m-d H:i:s'),
					'status_test' => '1'
				);
				$this->Maksespeserta->addpesertatest($data_awal);
			}
			if ($no == null) {
				$no = 1;
			}
			$data['no'] = $no;
			$data['data_test'] = $this->Maksespeserta->gettestdet($this->session->userdata('id_test'))->row();
			$durasi = $data['data_test']->durasi;
			$dr = explode(":", $durasi);
			$data_status_test = $this->Maksespeserta->gettestpeserta($data['idpeserta'], $this->session->userdata('id_test'));
			$data['status_test'] = $data_status_test->row();
			$data['start_at'] = $data['status_test']->start_at;
			$finish_at = new DateTime($data['data_test']->finish_at);
			$datetime = new DateTime($data['start_at']);
			$datetime->add(new DateInterval('PT' . $dr[0] . 'H' . $dr[1] . 'M'));
			if ($finish_at < $datetime) {
				$data['finish_at'] = $finish_at;
			} else {
				$data['finish_at'] = $datetime;
			}
			$data['rekaman'] = $data['status_test']->rekaman;
			$this->load->view('template/header');
			$this->load->view('v_akses-peserta/v_test-page', $data);
			$this->load->view('template/footer');
		} else {
			$idtest = $this->input->post('idtest');
			$token = $this->input->post('token');
			if ($token) {
				$cektoken = $this->Maksespeserta->gettestdet($idtest)->row()->token;
				if ($cektoken == $token) {
					$session = array(
						'id_test' => $idtest
					);
					$this->session->set_userdata($session);
					redirect(base_url('aksespeserta/soal_test'));
				} else {
					$this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert"> <strong>Gagal!</strong> Token yang anda masukan salah</div>');
					redirect(base_url('aksespeserta/mulai_test/' . $idtest));
				}
			} else {
				redirect(base_url('aksespeserta/daftar_test'));
			}
		}
	}
}
