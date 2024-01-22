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

    function repair_skema()
    {
        $no = 0;
        $gagal = 0;
        $this->db->select('*');
        $this->db->from('tb_ia_05');
        $query = $this->db->get()->result_array();
        if ($query) {
            foreach ($query as $q) :
                // echo $q['id_unit'] . "<br>";
                $this->db->select('id_skema');
                $this->db->from('tb_unit');
                $this->db->where('id', ($q['id_unit']));
                $r = $this->db->get()->row_array();
                $data = array(
                    'id_skema' => $r['id_skema']
                );
                $this->db->where('id', $q['id']);
                $this->db->update('tb_ia_05', $data);
                $no++;
            endforeach;
        } else {
            $gagal++;
        }
        return "berhasil memperbaharui : " . $no . " data, gagal : " . $gagal . " data";
    }
}
