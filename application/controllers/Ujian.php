<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Aksesasesor extends CI_Controller
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
        $this->load->model('Maksesasesor');
        $this->load->model('Maksesasesi');
        $this->load->model('Mmapa01');
        $this->load->model('Mfria02');
        $this->load->model('Mfria03');
        $this->load->model('Mfria05');
        $this->load->model('Mfria06');
        $this->load->model('Mfria07');
        $this->load->model('M_Akses');
        $this->load->helper('tgl_indo');
        cek_login_user();
    }

    public function index()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikom'] = $this->Maksesasesor->getJadwal($idasesor);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_aksesasesor', $data);
        $this->load->view('template/footer');
    }

    public function proses($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataak02'] = $this->Maksesasesor->getAk02($idasesi);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_putusan', $data);
        $this->load->view('template/footer');
    }

    public function daftar_asesi($idpaket)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($idpaket);
        $data['daftarasesi'] = $this->Maksesasesor->getAsesi($idpaket, $idasesor);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_daftar_asesi', $data);
        $this->load->view('template/footer');
    }

    public function daftar_test($idpaket)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($idpaket);
        $data['daftartest'] = $this->Maksesasesor->getTest($idpaket);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_daftar_test', $data);
        $this->load->view('template/footer');
    }

    public function list_test($idtest)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $cektoken = $this->Maksesasesor->getTestDetail($idtest)['token'];
        if ($cektoken == "") {
            $token = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
            $data = array(
                'token' => $token
            );
            $this->Maksesasesor->releasetoken($data, $idtest);
        } else {
            $data['token'] = $cektoken;
        }
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['datatest'] = $this->Maksesasesor->getTestDetail($idtest);
        $idpaket = $this->Maksesasesor->getTestDetail($idtest)['id_paket'];
        $data['ujikomdetail'] = $this->Mujikom->getDetail($idpaket);
        $data['idtest'] = $idtest;
        $data['daftarasesi'] = $this->Maksesasesor->getAsesi($idpaket, $idasesor);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_daftar_test-detail', $data);
        $this->load->view('template/footer');
    }

    public function release_token($idtest)
    {
        $token = substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(6 / strlen($x)))), 1, 6);
        $data = array(
            'token' => $token
        );
        $this->Maksesasesor->releasetoken($data, $idtest);
        redirect(base_url('aksesasesor/list_test/' . $idtest));
    }

    public function reset_test_asesi($idtest, $id)
    {
        $data = array(
            'status_test' => '1'
        );
        $this->db->where('id', $id);
        $this->db->update('tb_status_test', $data);
        redirect(base_url('aksesasesor/list_test/' . $idtest));
    }

    public function hapus_test_asesi($idtest, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_status_test');
        redirect(base_url('aksesasesor/list_test/' . $idtest));
    }

    public function hapus_test($id, $idpaket)
    {
        $this->db->where('id_test', $id);
        $this->db->delete('tb_status_test');

        $this->db->where('id', $id);
        $this->db->delete('tb_daftar_test');
        redirect(base_url('aksesasesor/daftar_test/' . $idpaket));
    }

    public function selesai_test_asesi($idtest, $id)
    {
        $betul = 0;
        $rekaman_test = $this->db->get_where('tb_status_test', array('id' => $id))->row()->rekaman;
        $id_asesi = $this->db->get_where('tb_status_test', array('id' => $id))->row()->id_asesi;
        $rt = explode("#", $rekaman_test);
        $jml_soal = count($rt) - 1;
        for ($i = 1; $i < count($rt); $i++) {
            $hasil = explode("-", $rt[$i]);
            $cek_jawaban = $this->Maksesasesi->cekjawabanpg($hasil[0]);
            if ($cek_jawaban == $hasil[1]) {
                $kom = 'K';
                $betul++;
            } else {
                $kom = 'BK';
            }
            $cek_ia = $this->db->get_where('fr_ia_05', array('id_asesi' => $id_asesi, 'id_ia' => $hasil[0]))->num_rows();
            $id_unit = $this->db->get_where('tb_ia_05', array('id' => $hasil[0]))->row()->id_unit;
            $data_ia = array(
                'id_asesi' => $id_asesi,
                'id_unit' => $id_unit,
                'id_ia' => $hasil[0],
                'kompetensi' => $kom,
                'jawaban' => $hasil[1]
            );
            if ($cek_ia >= 1) {
                $id_fr = $this->db->get_where('fr_ia_05', array('id_asesi' => $id_asesi, 'id_ia' => $hasil[0]))->row()->id;
                $this->db->where('id', $id_fr);
                $this->db->update('fr_ia_05', $data_ia);
            } else {
                $this->db->insert('fr_ia_05', $data_ia);
            }
        }
        $nilai = $betul / $jml_soal * 100;
        $data_akhir = array(
            'nilai' => $nilai,
            'status_test' => '2'
        );
        $this->db->where('id', $id);
        $this->db->update('tb_status_test', $data_akhir);
        redirect(base_url('aksesasesor/list_test/' . $idtest));
    }

    public function proses_demonstrasi_test()
    {
        $id = $this->input->post('id_status_test', true);
        $nilai = $this->input->post('nilai', true);
        $kompetensi = $this->input->post('kompetensi', true);
        $rekaman_test = $this->db->get_where('tb_status_test', array('id' => $id))->row()->rekaman;
        $id_asesi = $this->db->get_where('tb_status_test', array('id' => $id))->row()->id_asesi;
        $idtest = $this->db->get_where('tb_status_test', array('id' => $id))->row()->id_test;
        $rt = explode("#", $rekaman_test);
        $proses = 0;
        $tambah = 0;
        $ubah = 0;
        if ($kompetensi == 1) {
            for ($i = 1; $i < count($rt); $i++) {
                $daftar_unit = $this->db->get_where('tb_ia_02', array('id' => $rt[$i]))->row()->daftar_unit;
                $du = explode("#", $daftar_unit);
                for ($j = 1; $j < count($du); $j++) {
                    $this->db->select('tb_kuk.id as idkuk');
                    $this->db->from('tb_kuk');
                    $this->db->join('tb_elemen', 'tb_elemen.id=tb_kuk.id_elemen');
                    $this->db->where('id_unit', $du[$j]);
                    $datakuk = $this->db->get()->result();
                    foreach ($datakuk as $dk) {
                        $proses++;
                        $data_ia = array(
                            'id_asesi' => $id_asesi,
                            'id_unit' => $du[$j],
                            'id_kuk' => $dk->idkuk,
                            'nilai' => $nilai,
                            'kompetensi' => 'K'
                        );
                        $cek_ia = $this->db->get_where('fr_ia_01', array('id_asesi' => $id_asesi, 'id_kuk' => $dk->idkuk))->num_rows();
                        if ($cek_ia >= 1) {
                            $ubah++;
                            $id_fr = $this->db->get_where('fr_ia_01', array('id_asesi' => $id_asesi, 'id_kuk' => $dk->idkuk))->row()->id;
                            $this->db->where('id', $id_fr);
                            $this->db->update('fr_ia_01', $data_ia);
                        } else {
                            $tambah++;
                            $this->db->insert('fr_ia_01', $data_ia);
                        }
                    }
                }
            }
        }
        $data_akhir = array(
            'nilai' => $nilai,
            'status_test' => '2'
        );
        $this->db->where('id', $id);
        $this->db->update('tb_status_test', $data_akhir);
        redirect(base_url('aksesasesor/list_test/' . $idtest . '/' . count($rt) . '/' . count($du) . '/' . count($datakuk) . '/' . $tambah . '/' . $ubah));
    }

    public function tambah_test()
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['jenis_test'] = $this->input->post('jenis_test', true);
        $data['id_paket'] = $this->input->post('id_paket', true);
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($data['id_paket']);
        $data['daftartest'] = $this->Maksesasesor->getTest($data['id_paket']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_daftar_test-form', $data);
        $this->load->view('template/footer');
    }

    public function ubah_test($idtest)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $data['daftartest'] = $this->Maksesasesor->getTestDetail($idtest);
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($data['daftartest']['id_paket']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_daftar_test-edit', $data);
        $this->load->view('template/footer');
    }

    public function prosestest()
    {

        $id_jenis = $this->input->post('id_jenis');
        $id_paket = $this->input->post('id_paket');
        $durasi = $this->input->post('durasi');
        $random_soal = $this->input->post('random_soal');
        $random_jawaban = $this->input->post('random_jawaban');
        $upload_file = $this->input->post('upload_file');
        $link_file = $this->input->post('link_file');
        $max_file = $this->input->post('max_file');
        $start_at = $this->input->post('date_start_at') . " " . $this->input->post('time_start_at');
        $finish_at = $this->input->post('date_finish_at') . " " . $this->input->post('time_finish_at');
        $so = $this->input->post('soal_observasi');
        $count = count($so);
        $soal_observasi = "";
        for ($i = 0; $i < $count; $i++) {
            $soal_observasi = $soal_observasi . "#" . $so[$i];
        }
        $data = [
            'id_paket' => $id_paket,
            'durasi' => $durasi,
            'random_soal' => $random_soal,
            'random_jawaban' => $random_jawaban,
            'upload_file' => $upload_file,
            'link_file' => $link_file,
            'max_file' => $max_file,
            'start_at' => $start_at,
            'finish_at' => $finish_at,
            'soal_observasi' => $soal_observasi,
            'id_jenis' => $id_jenis,
            'id_paket' => $id_paket
        ];
        $idtest = $this->input->post('idtest');
        if ($idtest) {
            $this->Maksesasesor->edittest($data, $idtest);
        } else {
            $this->Maksesasesor->addtest($data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success left-icon-alert" role="alert"> <strong>Sukses!</strong> Data Berhasil ditambahhkan</div>');
        redirect(base_url('aksesasesor/daftar_test/' . $id_paket));
    }

    public function fria01($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['dataasesor'] = $this->Masesor->getasesordetail($idasesor);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataunit'] = $this->Mskema->getunit($data['ujikomdetail']['id_skema']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_fria01', $data);
        $this->load->view('template/footer');
    }

    public function fria03($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['dataasesor'] = $this->Masesor->getasesordetail($idasesor);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataunit'] = $this->Mskema->getunit($data['ujikomdetail']['id_skema']);
        $data['datafria03'] = $this->Mfria03->getfria03($data['ujikomdetail']['id_skema']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_fria03', $data);
        $this->load->view('template/footer');
    }

    public function fria06($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['dataasesor'] = $this->Masesor->getasesordetail($idasesor);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataunit'] = $this->Mskema->getunit($data['ujikomdetail']['id_skema']);
        $data['datafria06'] = $this->Mfria06->getfria06($data['ujikomdetail']['id_skema']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_fria06', $data);
        $this->load->view('template/footer');
    }

    public function fria07($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['dataasesor'] = $this->Masesor->getasesordetail($idasesor);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataunit'] = $this->Mskema->getunit($data['ujikomdetail']['id_skema']);
        $data['datafria07'] = $this->Mfria07->getfria07($data['ujikomdetail']['id_skema']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_fria07', $data);
        $this->load->view('template/footer');
    }

    public function soal($idasesi)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['dataasesor'] = $this->Masesor->getasesordetail($idasesor);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataunit'] = $this->Mskema->getunit($data['ujikomdetail']['id_skema']);
        $data['datafria05'] = $this->Mfria05->getfria05($data['ujikomdetail']['id_skema']);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_fria05', $data);
        $this->load->view('template/footer');
    }

    public function ia01proses($idasesi, $idunit)
    {
        $this->load->view('template/header');
        $id = $this->session->userdata('tipeuser');
        $idasesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $data['menu'] = $this->M_Setting->getmenu1($id);
        $dataserti = $this->Maksesasesi->getpaket($idasesi);
        $data['ujikomdetail'] = $this->Mujikom->getDetail($dataserti['id_paket']);
        $data['dataasesor'] = $this->Masesor->getasesordetail($idasesor);
        $data['dataasesi'] = $this->Masesi->getasesidetail($idasesi);
        $data['dataunit'] = $this->Mskema->getunitdetail($idunit);
        $data['akses'] = $this->M_Akses->getByLinkSubMenu(urlPath(), $id);
        $data['activeMenu'] = $this->db->get_where('tb_submenu', ['submenu' => 'Pelaksanaan Ujikom'])->row()->id_menus;

        $this->load->view('template/sidebar', $data);
        $this->load->view('v_aksesasesor/v_fria01-form', $data);
        $this->load->view('template/footer');
    }

    public function ia01save()
    {
        $add = 0;
        $update = 0;
        $id_unit = $this->input->post('id_unit', true);
        $id_asesi = $this->input->post('id_asesi', true);
        $pcdunit = $this->db->query("SELECT tb_kuk.id as id_kuk FROM tb_kuk left join tb_elemen on (tb_kuk.id_elemen=tb_elemen.id) where id_unit='" . $id_unit . "'")->result_array();
        foreach ($pcdunit as $icdunit) {
            $pcdia = $this->db->query("SELECT * FROM fr_ia_01 where id_asesi='" . $id_asesi . "' and id_kuk='" . $icdunit['id_kuk'] . "'");
            $jcdia = $pcdia->num_rows();
            $kom = $this->input->post('kom' . $icdunit['id_kuk'], true);
            $nilai = $this->input->post('nilai' . $icdunit['id_kuk'], true);
            if ($kom != "") {
                if ($jcdia >= 1) {
                    $this->Maksesasesor->delfria01($icdunit['id_kuk'], $id_asesi);
                    $data = array(
                        'kompetensi' => $kom,
                        'nilai' => $nilai,
                        'id_asesi' => $id_asesi,
                        'id_kuk' => $icdunit['id_kuk'],
                        'id_unit' => $id_unit
                    );
                    $this->Maksesasesor->addfria01($data);
                    $update++;
                } else {
                    $data = array(
                        'kompetensi' => $kom,
                        'nilai' => $nilai,
                        'id_asesi' => $id_asesi,
                        'id_kuk' => $icdunit['id_kuk'],
                        'id_unit' => $id_unit
                    );
                    $this->Maksesasesor->addfria01($data);
                    $add++;
                }
            }
        }
        $Pesan = $add . " data ditambahkan, " . $update . " data diubah";
        echo "
        <script>
            alert('$Pesan');
            document.location.href = '" . base_url('aksesasesor/fria01/' . $id_asesi) . "';
        </script>";
    }

    public function ak02_process()
    {
        $id_asesor = $this->Masesor->getidasesor($this->session->userdata('id_user'));
        $id_asesi = $this->input->post('id_asesi', true);
        $catatan = $this->input->post('catatan', true);
        $tindakan = $this->input->post('tindakan', true);
        $kompetensi = $this->input->post('kompetensi', true);
        $ttd_asesor = $this->input->post('ttd', true);
        $id_asesi = $this->input->post('id_asesi', true);
        $dataserti = $this->Maksesasesi->getpaket($id_asesi);
        $pcdia = $this->db->query("SELECT * FROM fr_ak_02 where id_asesi='" . $id_asesi . "'");
        $jcdia = $pcdia->num_rows();
        if ($jcdia >= 1) {
            $data = array(
                'id_asesor' => $id_asesor,
                'catatan' => $catatan,
                'tindakan' => $tindakan,
                'kompetensi' => $kompetensi,
                'ttd_asesor' => $ttd_asesor,
                'tgl_putusan' => date('Y-m-d')
            );
            $this->Maksesasesor->editfrak02($data, $id_asesi);
            echo "
                    <script>
                        alert('Berhasil Mengubah data Putusan');
                        document.location.href = '" . base_url('aksesasesor/daftar_asesi/' . $dataserti['id_paket']) . "';
                    </script>";
        } else {
            $data = array(
                'id_asesi' => $id_asesi,
                'id_asesor' => $id_asesor,
                'catatan' => $catatan,
                'tindakan' => $tindakan,
                'kompetensi' => $kompetensi,
                'ttd_asesor' => $ttd_asesor,
                'tgl_putusan' => date('Y-m-d')
            );
            $this->Maksesasesor->addfrak02($data);
            echo "
                    <script>
                        alert('Berhasil Menyimpan data Putusan');
                        document.location.href = '" . base_url('aksesasesor/daftar_asesi/' . $dataserti['id_paket']) . "';
                    </script>";
        }
    }

    public function ia03save()
    {
        $add = 0;
        $update = 0;
        $id_asesi = $this->input->post('id_asesi', true);
        $umpan_balik = $this->input->post('umpan_balik', true);
        $id_skema = $this->input->post('id_skema', true);
        $datafria03 = $this->Mfria03->getfria03($id_skema);
        foreach ($datafria03 as $df) {
            $jia03 = $this->Maksesasesor->getCountRefIa03($df->id, $id_asesi);
            $kom = $this->input->post('kom' . $df->id, true);
            $jawaban = $this->input->post('jawaban' . $df->id, true);
            if ($kom != "") {
                if ($jia03 >= 1) {
                    $data = array(
                        'kompetensi' => $kom,
                        'jawaban' => $jawaban,
                        'umpan_balik' => $umpan_balik
                    );
                    $this->Maksesasesor->editfria03($data, $df->id, $id_asesi);
                    $update++;
                } else {
                    $data = array(
                        'kompetensi' => $kom,
                        'jawaban' => $jawaban,
                        'id_asesi' => $id_asesi,
                        'id_ia' => $df->id,
                        'id_unit' => $df->id_unit,
                        'umpan_balik' => $umpan_balik
                    );
                    $this->Maksesasesor->addfria03($data);
                    $add++;
                }
            }
        }
        $Pesan = $add . " data ditambahkan, " . $update . " data diubah";
        echo "
        <script>
            alert('$Pesan');
            document.location.href = '" . base_url('aksesasesor/fria03/' . $id_asesi) . "';
        </script>";
    }

    public function ia06save()
    {
        $add = 0;
        $update = 0;
        $id_asesi = $this->input->post('id_asesi', true);
        $id_skema = $this->input->post('id_skema', true);
        $datafria06 = $this->Mfria06->getfria06($id_skema);
        foreach ($datafria06 as $df) {
            $jia06 = $this->Maksesasesor->getCountRefIa06($df->id, $id_asesi);
            $kom = $this->input->post('kom' . $df->id, true);
            $jawaban = $this->input->post('jawaban' . $df->id, true);
            if ($kom != "") {
                if ($jia06 >= 1) {
                    $data = array(
                        'kompetensi' => $kom,
                        'jawaban' => $jawaban
                    );
                    $this->Maksesasesor->editfria06($data, $df->id, $id_asesi);
                    $update++;
                } else {
                    $data = array(
                        'kompetensi' => $kom,
                        'jawaban' => $jawaban,
                        'id_asesi' => $id_asesi,
                        'id_ia' => $df->id,
                        'id_unit' => $df->id_unit
                    );
                    $this->Maksesasesor->addfria06($data);
                    $add++;
                }
            }
        }
        $Pesan = $add . " data ditambahkan, " . $update . " data diubah";
        echo "
        <script>
            alert('$Pesan');
            document.location.href = '" . base_url('aksesasesor/fria06/' . $id_asesi) . "';
        </script>";
    }

    public function ia07save()
    {
        $add = 0;
        $update = 0;
        $id_asesi = $this->input->post('id_asesi', true);
        $id_skema = $this->input->post('id_skema', true);
        $datafria07 = $this->Mfria07->getfria07($id_skema);
        foreach ($datafria07 as $df) {
            $jia07 = $this->Maksesasesor->getCountRefIa07($df->id, $id_asesi);
            $kom = $this->input->post('kom' . $df->id, true);
            $jawaban = $this->input->post('jawaban' . $df->id, true);
            if ($kom != "") {
                if ($jia07 >= 1) {
                    $data = array(
                        'kompetensi' => $kom,
                        'jawaban' => $jawaban
                    );
                    $this->Maksesasesor->editfria07($data, $df->id, $id_asesi);
                    $update++;
                } else {
                    $data = array(
                        'kompetensi' => $kom,
                        'jawaban' => $jawaban,
                        'id_asesi' => $id_asesi,
                        'id_ia' => $df->id,
                        'id_unit' => $df->id_unit
                    );
                    $this->Maksesasesor->addfria07($data);
                    $add++;
                }
            }
        }
        $Pesan = $add . " data ditambahkan, " . $update . " data diubah";
        echo "
        <script>
            alert('$Pesan');
            document.location.href = '" . base_url('aksesasesor/fria07/' . $id_asesi) . "';
        </script>";
    }

    public function ia05save()
    {
        $add = 0;
        $update = 0;
        $id_asesi = $this->input->post('id_asesi', true);
        $id_skema = $this->input->post('id_skema', true);
        $datafria05 = $this->Mfria05->getfria05($id_skema);
        foreach ($datafria05 as $df) {
            $jia05 = $this->Maksesasesor->getCountRefIa05($df->id, $id_asesi);
            $kom = $this->input->post('kom' . $df->id, true);
            $jawaban = $this->input->post('jawab' . $df->id, true);
            if ($kom == "") {
                if ($df->kunci == $jawaban) {
                    $kom = "K";
                } else {
                    $kom = "BK";
                }
            }
            if ($jia05 >= 1) {
                $data = array(
                    'kompetensi' => $kom,
                    'jawaban' => $jawaban
                );
                $this->Maksesasesor->editfria05($data, $df->id, $id_asesi);
                $update++;
            } else {
                $data = array(
                    'kompetensi' => $kom,
                    'jawaban' => $jawaban,
                    'id_asesi' => $id_asesi,
                    'id_ia' => $df->id,
                    'id_unit' => $df->id_unit
                );
                $this->Maksesasesor->addfria05($data);
                $add++;
            }
        }
        $Pesan = $add . " data ditambahkan, " . $update . " data diubah";
        echo "
        <script>
            alert('$Pesan');
            document.location.href = '" . base_url('aksesasesor/fria05/' . $id_asesi) . "';
        </script>";
    }

    public function ia01set($id_asesi)
    {
        $add = 0;
        $update = 0;
        $dataskema = $this->Maksesasesi->getskema($id_asesi);
        $dataunit = $this->Mskema->getunit($dataskema['id_skema']);
        foreach ($dataunit as $du) {
            $pcdunit = $this->db->query("SELECT tb_kuk.id as id_kuk FROM tb_kuk left join tb_elemen on (tb_kuk.id_elemen=tb_elemen.id) where id_unit='" . $du->id . "'")->result_array();
            foreach ($pcdunit as $icdunit) {
                $pcdia = $this->db->query("SELECT * FROM fr_ia_01 where id_asesi='" . $id_asesi . "' and id_kuk='" . $icdunit['id_kuk'] . "'");
                $jcdia = $pcdia->num_rows();
                if ($jcdia >= 1) {
                    $this->Maksesasesor->delfria01($icdunit['id_kuk'], $id_asesi);
                    $data = array(
                        'kompetensi' => 'K',
                        'id_asesi' => $id_asesi,
                        'id_kuk' => $icdunit['id_kuk'],
                        'id_unit' => $du->id
                    );
                    $this->Maksesasesor->addfria01($data);
                    $update++;
                } else {
                    $data = array(
                        'kompetensi' => 'K',
                        'id_asesi' => $id_asesi,
                        'id_kuk' => $icdunit['id_kuk'],
                        'id_unit' => $du->id
                    );
                    $this->Maksesasesor->addfria01($data);
                    $add++;
                }
            }
        }
        $Pesan = $add . " data ditambahkan, " . $update . " data diubah";
        echo "
        <script>
            alert('$Pesan');
            document.location.href = '" . base_url('aksesasesor/fria01/' . $id_asesi) . "';
        </script>";
    }
}
