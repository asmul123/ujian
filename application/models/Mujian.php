<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mujian extends CI_Model
{
    function getJadwal($idasesor)
    {
        $this->db->select('*, count(id_asesi) as jmlasesi');
        $this->db->join('tb_paket', 'tb_paket.id = tb_sertifikasi.id_paket');
        $this->db->where('id_asesor', $idasesor);
        $this->db->group_by('id_paket');
        $query = $this->db->get('tb_sertifikasi');
        return $query->result_array();
    }

    function getPeserta($ruang, $rombel)
    {
        $this->db->select('*');
        $this->db->where('ruang', $ruang);
        $this->db->where('rombel', $rombel);
        $query = $this->db->get('tb_peserta');
        return $query->result();
    }

    function getTest()
    {
        $this->db->select('*, tb_daftar_test.id as idtest');
        $this->db->join('tb_soal', 'tb_soal.id = tb_daftar_test.id_soal');
        $query = $this->db->get('tb_daftar_test');
        return $query->result_array();
    }

    function getTestCount($idpeserta)
    {
        $this->db->select('count(id) as jml');
        $this->db->where('id_peserta', $idpeserta);
        $query = $this->db->get('tb_status_test');
        return $query->row()->jml;
    }

    function getTestCountF($idpeserta)
    {
        $this->db->select('count(id) as jml');
        $this->db->where('id_peserta', $idpeserta);
        $this->db->where('status_test', '2');
        $query = $this->db->get('tb_status_test');
        return $query->row()->jml;
    }

    function getTestRuang($ruang)
    {
        $this->db->select('*, tb_daftar_test.id as idtest');
        $this->db->join('tb_soal', 'tb_soal.id = tb_daftar_test.id_soal');
        $this->db->where('ruang', $ruang);
        $query = $this->db->get('tb_daftar_test');
        return $query->result_array();
    }

    function getRombel($ruang)
    {
        $this->db->select('rombel');
        $this->db->from('tb_peserta');
        $this->db->where('ruang', $ruang);
        $this->db->group_by('rombel');
        $query = $this->db->get();
        return $query->result();
    }

    function getTestDetail($id)
    {
        $this->db->select('*');
        $this->db->join('tb_soal', 'tb_soal.id = tb_daftar_test.id_soal');
        $this->db->where('tb_daftar_test.id', $id);
        $query = $this->db->get('tb_daftar_test');
        return $query->row();
    }

    function getJenisTest($id)
    {
        $this->db->select('*');
        $this->db->where('id_jenis', $id);
        $query = $this->db->get('tb_jenis_test');
        return $query->row_array();
    }

    function addtest($data)
    {
        $this->db->insert('tb_daftar_test', $data);
    }

    function edittest($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_daftar_test', $data);
    }

    function releasetoken($data, $idtest)
    {
        $this->db->where('id', $idtest);
        $this->db->update('tb_daftar_test', $data);
    }
}
