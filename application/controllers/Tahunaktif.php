<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Tahunaktif extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('M_Setting');
        $this->load->model('Mtahunaktif');
        $this->load->model('M_Akses');
        cek_login_user();
    }

    public function index()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['tahunaktif'] = $this->Mtahunaktif->getAll();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Tahun Aktif'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_tahunaktif/v_tahunaktif', $data);
        $this->load->view('template/footer');
    }

    public function hapus($id)
    {
        $this->Mtahunaktif->hapus($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Dihapus</div>');
        redirect('tahunaktif');
    }

    public function tambah()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Tahun Aktif'])->row()->id_menus;
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_tahunaktif/v_tahunaktif_add', $data);
        $this->load->view('template/footer');
    }

    public function prosestambah()
    {
        // $id_user = $this->session-
        $data = [
            'tahun_aktif' => $this->input->post('tahun_aktif')
        ];
        $cekData = $this->db->get_where('tb_tahun_aktif', ['tahun_aktif' =>  $data['tahun_aktif']])->result();
        if (count($cekData) > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning left-icon-alert" role="alert"> <strong>Perhatian!</strong> Data Sudah ada</div>');
            redirect('tahunaktif/tambah');
        } else {
            $this->Mtahunaktif->tambah($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil Ditambahkan</div>');
            redirect('tahunaktif');
        }
    }

    public function ubah($idta)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['tahunaktif'] = $this->Mtahunaktif->getBYId($idta);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Tahun Aktif'])->row()->id_menus;
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_tahunaktif/v_tahunaktif_ubah', $data);
        $this->load->view('template/footer');
    }

    public function prosesubah()
    {
        $id = $this->input->post('id');
        $data = [
            'tahun_aktif' => $this->input->post('tahun_aktif')
        ];
        $cekData = $this->db->get_where('tb_tahun_aktif', ['id !=' => $id, 'tahun_aktif' =>  $data['tahun_aktif']])->result();
        if (count($cekData) > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning left-icon-alert" role="alert"> <strong>Perhatian!</strong> Data Sudah ada</div>');
            redirect('tahunaktif/ubah/' . $id);
        } else {
            $this->Mtahunaktif->ubah($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"><strong>Sukses!</strong> Data Berhasil Diubah</div>');
            redirect('tahunaktif');
        }
    }
}
