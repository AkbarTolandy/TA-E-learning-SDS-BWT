<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		$result = array('data' => array());

		$data = $this->db->get('roles')->result_array();
		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
				<a href="'.site_url('administrador/admin/role-access/' .$value['id']).'" class="badge badge-warning">Access</a>
      	<a href="'.site_url('administrador/role/edit/'.$value['id']).'" class="badge badge-success">Edit</a>
      	<a href="'.site_url('administrador/role/delete/'.$value['id']).'" onclick="'.$confirm.'" class="badge badge-danger">Delete</a>
			';

			$result['data'][$key] = array(
				$no,
				$value['role_name'],
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function edit($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/admin/role");
		$role = $this->menu->first("roles", 'id', $id); 
		if(empty($role)) redirect("administrador/admin/role"); 

		$role = $role->row();
		$data = array('role' => $role);

		$data['title'] = 'Edit <strong>Role</strong>';
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
			$data = array(
				'role_name' => $this->input->post('role', true)
			);

			$this->menu->update('id', $id, $data, 'roles'); #metode untuk update data.
			$this->session->set_flashdata("message", '<div class="alert alert-success">ID Role <strong>'.$id.'</strong> updated</div>');
			redirect('administrador/admin/role');
		endif;
	}

	public function delete($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/admin/role"); 

		$this->session->set_flashdata("message", '<div class="alert alert-danger">ID Role <strong>'.$id.'</strong> deleted</div>');
		$this->menu->delete('id', $id, 'roles');
		redirect('administrador/admin/role');
	}

}