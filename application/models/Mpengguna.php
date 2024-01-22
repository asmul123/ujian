<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mpengguna extends CI_Model
{

    function getpengguna()
    {
        return $this->db->query("SELECT *,tb_users.id as iduser FROM tb_users left join tb_userlevel on (tb_users.user_level=tb_userlevel.id) order by user_level ASC, nama ASC")->result();
    }

    function getpenggunafilter($level)
    {
        return $this->db->query("SELECT *,tb_users.id as iduser FROM tb_users left join tb_userlevel on (tb_users.user_level=tb_userlevel.id) where user_level='$level' order by user_level ASC, nama ASC")->result();
    }

    function getlevelpengguna()
    {
        return $this->db->query("SELECT * FROM tb_userlevel")->result();
    }

    function getpenggunadetail($id)
    {
        $this->db->select('*');
        $this->db->from('tb_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function adduser($data)
    {
        $this->db->insert('tb_users', $data);
    }

    function deluser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_users');
    }

    function edituser($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_users', $data);
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
}
