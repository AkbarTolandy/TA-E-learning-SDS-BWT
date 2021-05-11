<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	
		if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) :
			$id = $_COOKIE['id'];
			$key = $_COOKIE['key'];

			$user = $this->db->get_where('users', ['id' => $id])->row_array();
			if($key === hash('sha256', $user['username'])) {
				$data = [
					'username' => $user['username'],
					'role_id' => $user['role_id']
				];

				$this->session->set_userdata($data);
				$login = [
					"is_login" => date('Y-m-d H:i:s')
				];

				$this->db->where('id', $user['id']);
				$this->db->update('users', $login);
			}
		endif;

		if($this->session->userdata('username')) {
			redirect('administrador/admin');
		}

		$data['title'] = 'Login <strong>Page<strong>';

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->form_validation->run() === false) {
			$this->load->view('backend/templates/auth_header', $data);
			$this->load->view('backend/auth/login', $data);
			$this->load->view('backend/templates/auth_footer');
		} else {
			$this->login();
		}
	}

	private function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user = $this->db->get_where('users', ['username' => $username])->row_array();

		if($user) {

			if($user['is_active'] == 1) {
				if(password_verify($password, $user['password'])) {

					$data = [
						'username' => $user['username'],
						'role_id' => $user['role_id']
					];

					$roles = $this->db->get_where('roles', ['id' => $user['role_id']])->row_array();
					$data['role'] = $roles['role_name'];

					if($user['role_id'] == 3) :
						$this->db->select('kelas_id');
						$siswa = $this->db->get_where('siswa', ['user_id' => $user['id']])->row_array();
						$data['kelas_id'] = $siswa['kelas_id'];
					endif;

					$this->session->set_userdata($data);
					$login = [
						"is_login" => date('Y-m-d H:i:s')
					];

					$this->db->where('id', $user['id']);
					$this->db->update('users', $login);

					$remember = $this->input->post('remember_me');
					if($remember) :
						#set 1 menit cookie
						setcookie('id', $user['id'], time()+60);
						setcookie('key', hash('sha256', $user['email']), time()+60);
					endif;

					if($user['role_id'] == 1) {
						redirect('administrador/admin');
					} else {
						redirect('administrador/user');
					}
				} else {
					$this->session->set_flashdata('message', 
					'<div class="alert alert-danger">Wrong Password</div>');
					redirect('login');
				}

			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">
					This Username has not been activated</div>');
				redirect('login');
			}

		} else {
			$this->session->set_flashdata('message', 
				'<div class="alert alert-danger">Username is not registered</div>');
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role_id');

		setcookie('id', '', time() - 3600);
		setcookie('key', '', time() - 3600);

		$this->session->set_flashdata('message', 
		'<div class="alert alert-success">You have been logged out</div>');
		redirect('login');
	}

	public function blocked()
	{
		$this->load->view('backend/auth/blocked');
	}

	public function message()
	{
		$this->load->view('backend/auth/message');
	}

}