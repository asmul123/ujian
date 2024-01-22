<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Ujikom extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('M_Setting');
        $this->load->model('Mskema');
        $this->load->model('Mtuk');
        $this->load->model('Mujikom');
        $this->load->model('Masesor');
        $this->load->model('Masesi');
        $this->load->model('Maksesasesi');
        $this->load->model('Mak01');
        $this->load->model('M_Akses');
        $this->load->helper('tgl_indo');
        cek_login_user();
    }

    public function index()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikom'] = $this->Mujikom->getAll();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom', $data);
        $this->load->view('template/footer');
    }

    public function permohonan()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikom'] = $this->Mujikom->getAll();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_apl01', $data);
        $this->load->view('template/footer');
    }

    public function asman()
    {
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['idasesor'] = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['ujikom'] = $this->Mujikom->getAll();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;
        $this->load->view('template/header');
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_apl02', $data);
        $this->load->view('template/footer');
    }

    public function kerahasiaan()
    {
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['idasesor'] = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['ujikom'] = $this->Mujikom->getAll();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;
        $this->load->view('template/header');
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_ak01', $data);
        $this->load->view('template/footer');
    }

    public function ak01_process()
    {

        $id_asesi = $this->input->post('id_asesi', true);
        $ttd = $this->input->post('ttd', false);
        $jmlak01 = $this->Maksesasesi->getcountak01($id_asesi);
        $data = array(
            'tgl_ttd_asesor' => date('Y-m-d'),
            'ttd_asesor' => $ttd
        );
        if ($jmlak01 != 0) {
            $this->Maksesasesi->editak01($data, $id_asesi);
            $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Dipebaharui</div>');
            redirect(base_url('ujikom/kerahasiaan'));
        }
    }

    public function proses_pengajuan($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataapl01'] = $this->Maksesasesi->getApl01Asesi($idasesi);
        $data['skema'] = $this->Maksesasesi->getskema($idasesi);
        $data['idasesi'] = $idasesi;
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_apl01-app', $data);
        $this->load->view('template/footer');
    }

    public function proses_apl02($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataapl02'] = $this->Maksesasesi->getApl02Asesi($idasesi);
        $data['skema'] = $this->Maksesasesi->getskema($idasesi);
        $data['idasesi'] = $idasesi;
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_apl02-app', $data);
        $this->load->view('template/footer');
    }

    public function proses_ak01($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['jadwal'] = $this->Maksesasesi->getjadwalasesi($idasesi);
        $data['skema'] = $this->Maksesasesi->getskema($idasesi);
        $data['dataak01'] = $this->Mak01->getak01($data['skema']['id_skema']);
        $data['idasesi'] = $idasesi;
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_ak01-app', $data);
        $this->load->view('template/footer');
    }

    public function apl01_process()
    {
        $id_asesi = $this->input->post('id_asesi', true);
        $catatan = $this->input->post('catatan', true);
        $status = $this->input->post('status', true);
        $ttd = $this->input->post('ttd', false);
        $jmlapl01 = $this->Maksesasesi->getcountapl01($id_asesi);
        if ($jmlapl01 == 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger left-icon-alert" role="alert"> <strong>Gagal!</strong> Asesi Belum membuat Pengajuan</div>');
            redirect(base_url('ujikom/proses_pengajuan/' . $id_asesi));
        } else {
            $data = array(
                'status' => $status
            );
            $this->Maksesasesi->editapl01($data, $id_asesi);
            $data2 = array(
                'id_admin' => $this->session->userdata('id_user'),
                'catatan' => $catatan,
                'ttd_app' => $ttd,
                'tgl_app' => date('Y-m-d'),
            );
            $this->Maksesasesi->editappapl01($data2, $id_asesi);
            $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Pengajuan telah disimpan</div>');
            redirect(base_url('ujikom/proses_pengajuan/' . $id_asesi));
        }
    }

    public function apl02_process()
    {
        $id_asesi = $this->input->post('id_asesi', true);
        $catatan = $this->input->post('catatan', true);
        $status_ajuan = $this->input->post('status_ajuan', true);
        $ttd = $this->input->post('ttd', false);
        $jmlapl02 = $this->Maksesasesi->getcountapl02($id_asesi);
        if ($jmlapl02 == 0) {
            $this->session->set_flashdata('alert', '<div class="alert alert-danger left-icon-alert" role="alert"> <strong>Gagal!</strong> Asesi Belum membuat Pengajuan</div>');
            redirect(base_url('ujikom/asman'));
        } else {
            $data = array(
                'status_ajuan' => $status_ajuan,
                'ttd_asesor' => $ttd,
                'tgl_terima' => date('Y-m-d'),
                'catatan' => $catatan
            );
            $this->Maksesasesi->editapl02($data, $id_asesi);
            $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Keputusan telah disimpan</div>');
            redirect(base_url('ujikom/asman'));
        }
    }

    public function asesorasesi($idpaket)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['datasertifikasi'] = $this->Mujikom->getsertifikasi($idpaket);
        $data['datapaket'] = $this->Mujikom->getDetail($idpaket);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_partisipan', $data);
        $this->load->view('template/footer');
    }

    public function hapus($id)
    {
        $this->Mujikom->hapus($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Dihapus</div>');
        redirect(base_url('ujikom'));
    }

    public function hapusrekam($id, $idpaket)
    {
        $this->Mujikom->hapusrekam($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Dihapus</div>');
        redirect(base_url('ujikom/asesorasesi/' . $idpaket));
    }

    public function form($idjadwal = NULL)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['dataskema'] = $this->Mskema->getskema();
        $data['datatuk'] = $this->Mtuk->gettuk();
        $data['datajadwal'] = $this->Mujikom->getBYId($idjadwal);
        $data['idjadwal'] = $idjadwal;
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_form', $data);
        $this->load->view('template/footer');
    }

    public function rekam($idjadwal)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['dataskema'] = $this->Mskema->getskema();
        $data['datatuk'] = $this->Mtuk->gettuk();
        $data['datajadwal'] = $this->Mujikom->getDetail($idjadwal);
        $data['dataasesor'] = $this->Masesor->getasesor();
        $data['dataasesi'] = $this->Masesi->getasesi();
        $data['idjadwal'] = $idjadwal;
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Jadwal Ujikom'])->row()->id_menus;
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_ujikom/v_ujikom_rekam', $data);
        $this->load->view('template/footer');
    }

    public function prosesdata()
    {

        $id = $this->input->post('id');
        $nama_paket = $this->input->post('nama_paket');
        $id_skema = $this->input->post('id_skema');
        $id_tuk = $this->input->post('id_tuk');
        $pembiayaan = $this->input->post('pembiayaan');
        $tgl_sertifikasi = $this->input->post('tgl_sertifikasi');
        $data = [
            'nama_paket' => $nama_paket,
            'id_skema' => $id_skema,
            'id_tuk' => $id_tuk,
            'tgl_sertifikasi' => $tgl_sertifikasi,
            'pembiayaan' => $pembiayaan
        ];
        if ($id == "") {
            $this->Mujikom->tambah($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Ditambahkan</div>');
            redirect(base_url('ujikom'));
        } else {
            $this->Mujikom->ubah($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Diperbaharui</div>');
            redirect(base_url('ujikom'));
        }
    }

    public function prosesrekam()
    {

        $id_paket = $this->input->post('id_paket');
        $id_asesor = $this->input->post('id_asesor');
        $id_asesi = $this->input->post('id_asesi');
        $count = count($id_asesi);
        $gagal = 0;
        $berhasil = 0;
        for ($i = 0; $i < $count; $i++) {
            $data_asesi = $id_asesi[$i];
            $cek = $this->Mujikom->cekrekam($data_asesi, $id_paket);
            if ($cek >= 1) {
                $gagal++;
            } else {
                $data = [
                    'id_asesor' => $id_asesor,
                    'id_asesi' => $data_asesi,
                    'id_paket' => $id_paket
                ];
                $this->Mujikom->rekam($data);
                $berhasil++;
            }
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Mendambahkan : ' . $berhasil . ' data dan gagal Menambahkan : ' . $gagal . ' data</div>');
        redirect(base_url('ujikom/asesorasesi/' . $id_paket));
    }
}
