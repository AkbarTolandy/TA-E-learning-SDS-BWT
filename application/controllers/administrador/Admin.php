<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		#login sebagai admin
		$data['user_admin'] = $this->db->query("SELECT a.id, a.username, a.is_active, b.role_name 
			FROM users a JOIN roles b 
			ON a.role_id = b.id AND a.role_id != 3 AND a.role_id != 2 ")->result();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/admin/index', $data);
		$this->load->view('backend/templates/footer');
	}

	public function role()
	{
		is_logged_in();
		$data['title'] = 'Role';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('role', 'Role', 'required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/admin/role', $data);
			$this->load->view('backend/templates/footer');
		else:
			$this->db->insert('roles', [
				'role_name' => $this->input->post('role', true)  
			]);

			$this->session->set_flashdata('message', '<div class="alert alert-success">New role added</div>');
			redirect('administrador/admin/role');
		endif;
	}

	public function roleAccess($role_id)
	{
		is_admin();
		$data['title'] = 'Role <strong>Access</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$data['role'] = $this->db->get_where('roles', ['id' => $role_id])->row_array();
		if(!$data['role']) redirect("administrador/admin");

		$this->db->where('id !=', 1);
		$data['menus'] = $this->db->get('user_menu')->result_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/admin/role-access', $data);
		$this->load->view('backend/templates/footer');
	}

	public function changeAccess()
	{
		is_admin();
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->db->get_where('user_access_menu', $data);
		if($result->num_rows() < 1) :
			$this->db->insert('user_access_menu', $data);
		else:
			$this->db->delete('user_access_menu', $data);
		endif;

		$this->session->set_flashdata('message', 
			'<div class="alert alert-success">Access changed</div>');
	}

	public function create()
	{
		is_admin();
		$data['title'] = 'Tambah <strong>User</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('fullname', 'Fullname', 'required|trim');
		$this->form_validation->set_rules('username', 'Username', 
			'trim|required|is_unique[users.username]', [
			'is_unique' => 'This Username has already registered!'
		]);

		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password]');

		if($this->form_validation->run() === FALSE) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/admin/save', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'role_id' => $post['role'],
				'username' => $post['username'],
				'is_active' => (!empty($post['is_active'])) ? $post['is_active'] : 0,
				'password' => password_hash($post['password'], PASSWORD_DEFAULT)
			);

			$this->db->insert("users", $data); #simpan data
			$_id = $this->db->insert_id();

			$admin = array(
				'user_id' => $_id,
				'name' => $post['fullname'],
				'avatar' => 'default.png'
			);

			$this->db->insert('administrator', $admin);

			$this->session->set_flashdata("message", 
				'<div class="alert alert-success">ID Admin <strong>'.$_id.'</strong> Baru Ditambahkan</div>');
			redirect('administrador/admin');

		endif;
	}

	public function edit($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/admin");

		$profile = $this->db->query("SELECT b.name, a.* 
			FROM users a JOIN administrator b 
			ON a.id = b.user_id 
			AND b.user_id = '$id' ");

		if($profile->num_rows() == 0) redirect("administrador/admin"); 

		$profile = $profile->row();
		$data = array('profile' => $profile);

		$data['title'] = 'Edit <strong>User</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('fullname', 'Nama', 'required|trim');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/admin/edit', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'username' => $post['username'],
				'is_active' => (!empty($post['is_active'])) ? $post['is_active'] : 0,
				'role_id' => $post['role']
			);

			$this->menu->update('id', $id, $data, 'users'); #metode untuk update data.

			$admin = array(
				'name' => $post['fullname'],
				'updated_at' => date("Y-m-d H:i:s"),
			);

			$this->menu->update('user_id', $id, $admin, 'administrator'); #metode untuk update data.
			$this->session->set_flashdata("message", '<div class="alert alert-success">ID Admin <strong>'.$id.'</strong> Sudah Di updated</div>');
			redirect('administrador/admin');
		endif;
	}

	public function delete($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/admin"); 

		$this->session->set_flashdata("message", 
			'<div class="alert alert-danger">ID Admin <strong>'.$id.'</strong> Sudah Deleted</div>');

		$this->menu->delete('user_id', $id, 'administrator'); 
		$this->menu->delete('id', $id, 'users'); 
		redirect('administrador/admin');
	}
}