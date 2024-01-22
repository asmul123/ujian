<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clogin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Mlogin');
		$this->load->library('session');
	}

	function index()
	{
		if ($this->session->userdata('login') === true) {
			redirect('welcome');
		} else if ($this->session->userdata('login-siswa')) {
			redirect('dashboard');
		}
		$this->load->view('v_login');
	}

	function siswa()
	{
		// echo 'Login Siswa';
		if ($this->session->userdata('login-siswa') === true) {
			redirect('dashboard');
		}
		$this->load->view('v_siswa/v_siswa-login.php');
	}

	function cek_login()
	{

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user = $this->Mlogin->get($username, $password);

		if (empty($user)) {
			echo "<script>alert('Data yang anda masukkan salah');history.go(-1);</script>";
		} else {
			// if(md5($password) == $user->password){ // Jika password yang diinput sama dengan password yang didatabase
			$session = array(
				'authenticated' => true, // Buat session authenticated dengan value true
				'username' => $username,  // Buat session nip
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

	public function logout()
	{
		$this->Mlogin->logout();
		$this->session->sess_destroy(); // Hapus semua session
		redirect('clogin'); // Redirect ke halaman login
	}
}
