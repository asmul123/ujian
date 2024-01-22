<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Aksespengawas extends CI_Controller
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
        $this->load->helper('tgl_indo');
        cek_login_user();
    }

    public function index()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $ruang = $this->db->get_where('tb_ruang', array('id_user' => $this->session->userdata('id_user')))->row()->ruang;
        $data['daftartest'] = $this->Mujian->getTestRuang($ruang);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Daftar Test'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_akses-pengawas/v_daftar_test', $data);
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
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Daftar Test'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_akses-pengawas/v_daftar_test-detail', $data);
        $this->load->view('template/footer');
    }

    public function release_token($idtest)
    {
        $token = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
        $data = array(
            'token' => $token
        );
        $this->Mujian->releasetoken($data, $idtest);
        redirect(base_url('aksespengawas/list_test/' . $idtest));
    }

    public function reset_test_peserta($idtest, $id)
    {
        $data = array(
            'status_test' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('tb_status_test', $data);
        redirect(base_url('aksespengawas/list_test/' . $idtest));
    }

    public function hapus_test_peserta($idtest, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_status_test');
        redirect(base_url('aksespengawas/list_test/' . $idtest));
    }

    public function hapus_test($id, $idpaket)
    {
        $this->db->where('id_test', $id);
        $this->db->delete('tb_status_test');

        $this->db->where('id', $id);
        $this->db->delete('tb_daftar_test');
        redirect(base_url('aksespengawas/daftar_test/' . $idpaket));
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
        redirect(base_url('aksespengawas/list_test/' . $idtest));
    }

    public function ubah_test($idtest)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['daftartest'] = $this->Mujian->getTestDetail($idtest);
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Daftar Test'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_akses-pengawas/v_daftar_test-edit', $data);
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
                $rombel = $this->Mujian->getRombel($dr->ruang);
                foreach ($rombel as $rb) {
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
            if ($idtest) {
                $this->Mujian->edittest($data, $idtest);
                $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil diubah</div>');
            } else {
                $this->Mujian->addtest($data);
                $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil ditambahkan</div>');
            }
        }
        redirect(base_url('aksespengawas'));
    }
}
