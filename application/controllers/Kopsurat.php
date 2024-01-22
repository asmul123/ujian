<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kopsurat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('M_Setting');
        $this->load->model('M_Akses');
        cek_login_user();
    }

    public function index()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['kopsurat'] = $this->M_Setting->getkop();
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Kop Surat'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_kopsurat/v_kopsurat', $data);
        $this->load->view('template/footer');
    }

    public function ubah()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['kopsurat'] = $this->M_Setting->getkop();
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Kop Surat'])->row()->id_menus;
        $this->load->view('template/sidebar', $data);
        $this->load->view('v_kopsurat/v_kopsurat-edit', $data);
        $this->load->view('template/footer');
    }

    public function edt_process()
    {
        $isi = $this->input->post('isi');
        $logo_kiri_lama = $this->input->post('logo_kiri_lama');
        $logo_kanan_lama = $this->input->post('logo_kanan_lama');
        $config['upload_path']          = './assets/img/kop/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 1024;
        $config['max_width']            = 6000;
        $config['max_height']           = 6000;
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('logo_kiri')) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">' . $this->upload->display_errors() . '</div>');
            $logo_kiri = $logo_kiri_lama;
        } else {
            $logo_kiri = $this->upload->data('file_name');
        }
        if (!$this->upload->do_upload('logo_kanan')) {
            $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">' . $this->upload->display_errors() . '</div>');
            $logo_kanan = $logo_kanan_lama;
        } else {
            $logo_kanan = $this->upload->data('file_name');
        }
        $data = [
            'logo_kiri' => $logo_kiri,
            'isi' => $isi,
            'logo_kanan' => $logo_kanan
        ];
        $this->M_Setting->editkop($data, '1');
        $this->session->set_flashdata('alert', '<div class="alert alert-success left-icon-alert" role="alert">
																<strong>Sukses!</strong> Berhasil Mengubah KOP Surat.
																</div>');
        redirect(base_url('kopsurat'));
    }
}
