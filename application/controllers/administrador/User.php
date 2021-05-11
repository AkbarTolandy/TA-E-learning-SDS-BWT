<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'My Profile';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/user/index', $data);
		$this->load->view('backend/templates/footer');
	}

	public function changePassword()
	{
		is_auth();
		$data['title'] = 'Change <strong>Password</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
		$this->form_validation->set_rules('new_password2', 'Confirm Password', 'required|trim|min_length[3]|matches[new_password1]');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/user/change-password', $data);
			$this->load->view('backend/templates/footer');
		else:
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password1');

			if(!password_verify($current_password, $data['user']['password'])) :
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong current password!</div>');
				redirect('administrador/user/change-password');
			else:
				if($current_password == $new_password) :
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Password cannot be the same as current password!</div>');
					redirect('administrador/user/change-password');
				else:

					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
					$this->db->set('password', $password_hash);
					$this->db->where('username', $this->session->userdata('username'));
					$this->db->update('users');

					$this->session->set_flashdata('message', '<div class="alert alert-success">Password changed!</div>');
					redirect('administrador/user/change-password');
				endif;
			endif;

		endif;
	}

	public function edit($value='')
	{
		is_auth();
		$data['title'] = 'Edit <strong>Profile</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('name', 'Name', 'required|trim');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/user/edit', $data);
			$this->load->view('backend/templates/footer');
		else:
			$name = $this->input->post('name');
			$username = $this->input->post('username');
			
			if($this->session->userdata('role_id') == 3) {
				$number_phone = $this->input->post('number_phone');
				$gender = $this->input->post('gender');
				$address = $this->input->post('address');

			} else if($this->session->userdata('role_id') == 2) {
				$number_phone = $this->input->post('number_phone');
				$gender = $this->input->post('gender');
			}

			$user_id = $data['user']['id'];

			$upload_image = $_FILES['image']['name'];
			if($upload_image) :

				$config['upload_path']          = './assets/backend/img/profile'; #directory untuk menyimpan gambar/file
		    $config['allowed_types']        = 'png|jpg|jpeg|gif'; #jenis gambar
				$config['max_size']     = '2048';

				$this->upload->initialize($config);
				
				if ($this->upload->do_upload('image')) :
			    if($this->session->userdata('role_id') == 3) {
			      $table = 'siswa';
			    } else if ($this->session->userdata('role_id') == 2) {
			      $table = 'guru';
			    } else {
			      $table = 'administrator';
			    }
				    
          $avatar = $this->db->get_where($table, array('user_id' => $user_id))->row('avatar');
                    
					$oldImage = $avatar;
					if($oldImage != 'default.png') :
						unlink(FCPATH. 'assets/backend/img/profile/'. $oldImage);
					endif;

					$newImage = $this->upload->data('file_name');
					$this->db->set('avatar', $newImage);
				else:
					$error = array('errors' => $this->upload->display_errors()); #show errornya
					$this->session->set_flashdata('error-upload', '<div class="text-danger">'.$error['errors'].'</div>');
					redirect('administrador/user/edit');
				endif;
			endif;

			if($this->session->userdata('role_id') == 3) {
				$this->db->set('name', $name);
				$this->db->set('number_phone', $number_phone);
				$this->db->set('gender', $gender);
				$this->db->set('address', $address);
				$this->db->where('user_id', $user_id);
				$this->db->update('siswa');
			} else if ($this->session->userdata('role_id') == 2) {
				$this->db->set('number_phone', $number_phone);
				$this->db->set('gender', $gender);
				$this->db->set('name', $name);
				$this->db->where('user_id', $user_id);
				$this->db->update('guru');
			} else {
				$this->db->set('name', $name);
				$this->db->where('user_id', $user_id);
				$this->db->update('administrator');
			}

			$this->session->set_flashdata('message', 
				'<div class="alert alert-success">Your profile has been updated</div>');
			redirect('administrador/user');
		endif;
	}
}