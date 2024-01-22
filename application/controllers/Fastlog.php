<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fastlog extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Mlogin');
		$this->load->library('session');
	}

	function index($ruang, $sandi)
	{
		$user = $this->db->get_where('tb_users', array('username' => $ruang, 'password' => $sandi))->row();

		if (empty($user)) {
			echo "<script>alert('Data yang anda masukkan salah');window.close('','_parent','');</script>";
		} else {
			// if(md5($password) == $user->password){ // Jika password yang diinput sama dengan password yang didatabase
			$session = array(
				'authenticated' => true, // Buat session authenticated dengan value true
				'username' => $ruang,  // Buat session nip
				'nama' => $user->nama,
				'id_user' => $user->id, // Buat session authenticated
				'tipeuser' => $user->user_level,
				'login' => true
			);
			$this->session->set_userdata($session); // Buat session sesuai $session
			$this->Mlogin->userlog();
			redirect('welcome'); // Redirect ke halaman welcome
			// }else{
			// $this->session->set_flashdata('message', 'Password salah'); // Buat session flashdata
			//     echo "<script>
			// 		alert('Password salah');history.go(-1);
			// 	</script>";
			//     // redirect('C_Login'); 
			//     // Redirect ke halaman login
			// }
		}
	}
}
