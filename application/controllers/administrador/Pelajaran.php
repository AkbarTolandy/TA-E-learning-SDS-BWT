<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelajaran extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'Mata Pelajaran';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/pelajaran/index', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = [
				'status' => (!empty($post['status'])) ? $post['status'] : 0,
				'nama_pelajaran' => $this->input->post('name', true),
				'slug' => url_title($this->input->post('name', true), 'dash', true)
			];

			$this->db->insert('pelajaran', $data);
			$_id = $this->db->insert_id();

			$this->session->set_flashdata("message", '<div class="alert alert-success">Pelajaran Baru Ditambahkan</div>');
			redirect('administrador/pelajaran');
		endif;
	}

	public function getMataPelajaran()
	{
		$result = array('data' => array());

		$data = $this->db->get('pelajaran')->result_array();
		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
				<a href="'.site_url('administrador/pelajaran/edit/'.$value['id']).'" class="badge badge-success">Edit</a>
				<a href="'.site_url('administrador/pelajaran/delete/'.$value['id']).'" onclick="'.$confirm.'" 
					class="badge badge-danger">Delete</a>
			';

			$result['data'][$key] = array(
				$no,
				$value['nama_pelajaran'],
				$value['slug'],
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function edit($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/pelajaran");

		$materi = $this->menu->first("pelajaran", 'id', $id); 
		if(empty($materi)) redirect("administrador/pelajaran"); 

		$materi = $materi->row();
		$data = array('materi' => $materi);

		$data['title'] = 'Edit <strong>Mata Pelajaran</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$this->form_validation->set_rules('name', 'Name', 'required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/pelajaran/index', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'status' => (!empty($post['status'])) ? $post['status'] : 0,
				'nama_pelajaran' => $this->input->post('name', true),
				'slug' => url_title($this->input->post('name', true), 'dash', true)
			);

			$this->menu->update('id', $id, $data, 'pelajaran'); #metode untuk update data.
			$this->session->set_flashdata("message", '<div class="alert alert-success">
				ID Pelajaran <strong>'.$id.'</strong> Updated</div>');
			redirect('administrador/pelajaran');

		endif;
	}

	public function delete($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/pelajaran"); 

		$result = $this->menu->first("pelajaran", 'id', $id);
		if(empty($result)) redirect("administrador/pelajaran"); 

		$this->session->set_flashdata("message", '<div class="alert alert-danger">ID Pelajaran <strong>'.$id.'</strong> Deleted</div>');
		$this->menu->delete('id', $id, 'pelajaran'); 
		redirect('administrador/pelajaran');
	}

}