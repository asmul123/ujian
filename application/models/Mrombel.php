<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mrombel extends CI_Model
{

    function getrombel()
    {
        $this->db->select('*');
        $this->db->from('tb_rombel');
        return $this->db->get()->result();
    }

    function getthisrombel($id)
    {
        $this->db->select('*');
        $this->db->from('tb_rombel');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    function addrombel($data)
    {
        $this->db->insert('tb_rombel', $data);
    }

    function delrombel($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_rombel');
    }

    function editrombel($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_rombel', $data);
    }

    function cekRombel($no_pes)
    {
        $query = $this->db->get_where('tb_rombel', ['rombel' => $no_pes])->row();
        if (empty($query)) {
            return 'kosong';
        } else {
            return 'ada';
        }
    }
}
