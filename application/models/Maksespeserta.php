<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maksespeserta extends CI_Model
{

    function getDetailPeserta($id)
    {
        $this->db->select('*');
        $this->db->from('tb_peserta');
        $this->db->where('id_user', $id);
        return $this->db->get()->row();
    }
    function getTest($ruang, $rombel)
    {
        $this->db->select('*, tb_daftar_test.id as idtest');
        $this->db->join('tb_soal', 'tb_soal.id = tb_daftar_test.id_soal');
        $this->db->where('ruang', $ruang);
        $this->db->where('rombel', $rombel);
        $query = $this->db->get('tb_daftar_test');
        return $query->result();
    }

    function gettestpeserta($idpeserta, $id)
    {
        $this->db->select('*');
        $this->db->from('tb_status_test');
        $this->db->where('id_peserta', $idpeserta);
        $this->db->where('id_test', $id);
        return $this->db->get();
    }

    function gettestdet($id)
    {
        $this->db->select('*, tb_daftar_test.id as idtest');
        $this->db->from('tb_daftar_test');
        $this->db->join('tb_soal', 'tb_soal.id=tb_daftar_test.id_soal');
        $this->db->where('tb_daftar_test.id', $id);
        return $this->db->get();
    }

    function getsoalpg($id, $rand = null)
    {
        $this->db->select('*');
        $this->db->from('tb_soal_detail');
        $this->db->where('id_soal', $id);
        $this->db->order_by('id_jenissoal', 'ASC');
        if ($rand != null) {
            $this->db->order_by('id', 'RANDOM');
        }
        return $this->db->get()->result();
    }

    function cekjawabanpg($id)
    {
        $this->db->select('*');
        $this->db->from('tb_soal_detail');
        $this->db->where('id', $id);
        return $this->db->get()->row()->kunci;
    }

    function hapusbukti($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_bukti_peserta');
    }

    function addpesertatest($data)
    {
        $this->db->insert('tb_status_test', $data);
    }

    function edtpesertatest($data,$idtest,$idpes)
    {
        $this->db->where('id_peserta', $idpes);
        $this->db->where('id_test', $idtest);
        $this->db->update('tb_status_test', $data);
    }

    function addTest($data)
    {
        $this->db->insert('tb_status_test', $data);
    }
}
