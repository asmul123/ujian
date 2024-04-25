<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Msoal extends CI_Model
{

    function getSoal()
    {
        $this->db->select('*');
        $this->db->from('tb_soal');
        return $this->db->get()->result();
    }
    function getPertanyaan($id)
    {
        $this->db->select('*');
        $this->db->from('tb_soal_detail');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function getQSoal($id)
    {
        $this->db->select('count(id) as jml');
        $this->db->from('tb_soal_detail');
        $this->db->where('id_soal', $id);
        return $this->db->get()->row();
    }

    function getDetailbyID($id)
    {
        $this->db->select('*');
        $this->db->from('tb_soal_detail');
        $this->db->where('id_soal', $id);
        return $this->db->get()->result();
    }

    function addSoal($data)
    {
        $this->db->insert('tb_soal', $data);
    }

    function ubahSoal($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_soal', $data);
    }

    function ubahSoalDetail($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_soal_detail', $data);
    }

    function hapusSoal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_soal');

        $this->db->where('id_soal', $id);
        $this->db->delete('tb_soal_detail');
    }

    function hapusDetailSoal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_soal_detail');
    }

    function addSoalDetail($data)
    {
        $this->db->insert('tb_soal_detail', $data);
    }

    function editfria05($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_ia_05', $data);
    }

}
