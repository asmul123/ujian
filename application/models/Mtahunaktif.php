<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mtahunaktif extends CI_Model
{
    function getAll()
    {
        $query = $this->db->query("SELECT * FROM tb_tahun_aktif ORDER BY tahun_aktif DESC");
        return $query->result_array();
    }

    function getBYId($id)
    {
        $query = $this->db->get_where('tb_tahun_aktif', ['id' => $id]);
        return $query->row_array();
    }

    function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_tahun_aktif');
    }

    function tambah($data)
    {
        $this->db->insert('tb_tahun_aktif', $data);
    }

    function ubah($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_tahun_aktif', $data);
    }
}
