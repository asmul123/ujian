<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mujikom extends CI_Model
{
    function getAll()
    {
        $query = $this->db->query("SELECT *,tb_paket.id as idpak FROM tb_paket left join tb_skema on (tb_paket.id_skema=tb_skema.id) right join tb_tuk on (tb_paket.id_tuk = tb_tuk.id) WHERE tb_paket.id<>'' ORDER BY tgl_sertifikasi DESC");
        return $query->result_array();
    }

    function getAjuan($status)
    {
        $this->db->select('*');
        $this->db->from('tb_apl_01');
        $this->db->join('tb_sertifikasi', 'tb_sertifikasi.id_asesi = tb_apl_01.id_asesi');
        $this->db->join('tb_approve_apl01', 'tb_approve_apl01.id_asesi = tb_apl_01.id_asesi');
        $this->db->where('status', $status);
        return $this->db->get();
    }

    function getAjuanapl02($status, $id)
    {
        $this->db->select('*');
        $this->db->from('tb_approve_apl02');
        $this->db->join('tb_sertifikasi', 'tb_sertifikasi.id_asesi = tb_approve_apl02.id_asesi');
        $this->db->join('tb_asesi', 'tb_asesi.id = tb_approve_apl02.id_asesi');
        $this->db->where('status_ajuan', $status);
        $this->db->where('tb_approve_apl02.id_asesor', $id);
        return $this->db->get();
    }

    function getAjuanak01($key, $value, $id)
    {
        $this->db->select('*');
        $this->db->from('fr_ak_01');
        $this->db->join('tb_sertifikasi', 'tb_sertifikasi.id_asesi = fr_ak_01.id_asesi');
        $this->db->join('tb_asesi', 'tb_asesi.id = fr_ak_01.id_asesi');
        $this->db->where($key, $value);
        $this->db->where('fr_ak_01.id_asesor', $id);
        return $this->db->get();
    }

    function getDetail($id)
    {
        $query = $this->db->query("SELECT *,tb_paket.id as idpak, tb_skema.id as idskema FROM tb_paket left join tb_skema on (tb_paket.id_skema=tb_skema.id) right join tb_tuk on (tb_paket.id_tuk = tb_tuk.id) where tb_paket.id='$id'");
        return $query->row_array();
    }

    function getBYId($id)
    {
        $query = $this->db->get_where('tb_paket', ['id' => $id]);
        return $query->row_array();
    }

    function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_paket');

        $this->db->where('id_paket', $id);
        $this->db->delete('tb_sertifikasi');
    }

    function hapusrekam($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_sertifikasi');
    }

    function tambah($data)
    {
        $this->db->insert('tb_paket', $data);
    }

    function rekam($data)
    {
        $this->db->insert('tb_sertifikasi', $data);
    }

    function cekrekam($idasesi, $idpaket)
    {
        $this->db->select('*');
        $this->db->from('tb_sertifikasi');
        $this->db->where('id_asesi', $idasesi);
        $this->db->where('id_paket', $idpaket);
        return $this->db->get()->num_rows();
    }

    function ubah($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_paket', $data);
    }

    function getsertifikasi($idpaket)
    {
        $this->db->select('*, tb_sertifikasi.id as idser, tb_asesor.nama as namaasesor, tb_asesi.nama as namaasesi');
        $this->db->join('tb_asesor', 'tb_asesor.id = tb_sertifikasi.id_asesor');
        $this->db->join('tb_asesi', 'tb_asesi.id = tb_sertifikasi.id_asesi');
        $this->db->where('id_paket', $idpaket);
        $this->db->order_by('tb_asesor.nama', 'ASC');
        $this->db->order_by('tb_asesi.nama', 'ASC');
        $query = $this->db->get('tb_sertifikasi');
        return $query->result_array();
    }
}
