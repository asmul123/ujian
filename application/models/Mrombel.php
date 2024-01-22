<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mrombel extends CI_Model
{

    function getrombel()
    {
        $this->db->select('*');
        $this->db->from('tb_rombel');
        return $this->db->get()->result();
    }

    function getasesidetail($id)
    {
        $this->db->select('*, tb_asesi.id as idas');
        $this->db->from('tb_asesi');
        $this->db->join('tb_users', 'tb_asesi.id_user = tb_users.id');
        $this->db->where('tb_asesi.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function hapusfoto($id)
    {
        $this->db->select('foto');
        $this->db->from('tb_asesi');
        $this->db->where('id', $id);
        $this->db->where('foto !=', 'noimage.png');
        $query = $this->db->get()->row_array();
        unlink('./assets/img/asesi/' . $query['foto']);
    }

    function addrombel($data)
    {
        $this->db->insert('tb_rombel', $data);
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

    function delasesi($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_asesi');
    }

    function deluser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_users');
    }

    function editasesi($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_asesi', $data);
    }

    function edituser($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_users', $data);
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

    function cekNopesU($no_pes, $id)
    {
        $this->db->select('*');
        $this->db->from('tb_asesi');
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
