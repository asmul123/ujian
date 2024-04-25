<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mpeserta extends CI_Model
{

    function getpeserta()
    {
        return $this->db->query("SELECT * FROM tb_peserta order by ruang ASC, rombel ASC, nama ASC")->result();
    }

    function getpesertadetail($id)
    {
        $this->db->select('*, tb_peserta.id as idpes');
        $this->db->from('tb_peserta');
        $this->db->join('tb_users', 'tb_peserta.id_user = tb_users.id');
        $this->db->where('tb_peserta.id_user', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function getserver($id)
    {
        $this->db->select('link_server');
        $this->db->from('tb_server');
        $this->db->join('tb_ruang', 'tb_server.id = tb_ruang.id_server');
        $this->db->join('tb_peserta', 'tb_ruang.ruang = tb_peserta.ruang');
        $this->db->where('tb_peserta.id_user', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getNilaiPeserta($id, $soal)
    {
        $this->db->select('nilai');
        $this->db->from('tb_status_test');
        $this->db->join('tb_daftar_test', 'tb_daftar_test.id = tb_status_test.id_test');
        $this->db->join('tb_peserta', 'tb_peserta.id = tb_status_test.id_peserta');
        $this->db->where('tb_peserta.id', $id);
        $this->db->where('tb_daftar_test.id_soal', $soal);
        $this->db->order_by('nilai', 'DESC');
        $query = $this->db->get();
        return $query->row();
    }

    function hapusfoto($id)
    {
        $this->db->select('foto');
        $this->db->from('tb_peserta');
        $this->db->where('id', $id);
        $this->db->where('foto !=', 'noimage.png');
        $query = $this->db->get()->row_array();
        unlink('./assets/img/peserta/' . $query['foto']);
    }

    function addpeserta($data)
    {
        $this->db->insert('tb_peserta', $data);
    }

    function adduser($data)
    {
        $this->db->insert('tb_users', $data);
    }

    function cekIdUser($username)
    {
        $query = $this->db->get_where('tb_users', ['username' => $username])->row();
        return $query;
    }

    function delpeserta($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_peserta');
    }

    function deluser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_users');
    }

    function editpeserta($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_peserta', $data);
    }

    function edituser($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_users', $data);
    }

    function cekNopes($no_pes)
    {
        $query = $this->db->get_where('tb_peserta', ['no_peserta' => $no_pes])->row();
        if (empty($query)) {
            return 'kosong';
        } else {
            return 'ada';
        }
    }

    function cekNopesU($no_pes, $id)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->where('no_peserta', $no_pes);
        $this->db->where('id <>', $id);
        $query = $this->db->get()->row();
        if (empty($query)) {
            return 'kosong';
        } else {
            return 'ada';
        }
    }

    function cekUsername($username)
    {
        $query = $this->db->get_where('tb_users', ['username' => $username])->row();
        if (empty($query)) {
            return 'kosong';
        } else {
            return 'ada';
        }
    }

    function cekUsernameU($username, $id)
    {
        $this->db->select('*');
        $this->db->from('tb_users');
        $this->db->where('username', $username);
        $this->db->where('id <>', $id);
        $query = $this->db->get()->row();
        if (empty($query)) {
            return 'kosong';
        } else {
            return 'ada';
        }
    }

    function cekAkun($id)
    {
        $query = $this->db->get_where('tb_users', ['id' => $id])->row();
        if (empty($query)) {
            return 'kosong';
        } else {
            return 'ada';
        }
    }
}
