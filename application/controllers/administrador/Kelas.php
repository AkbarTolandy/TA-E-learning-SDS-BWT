<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function getkelas()
	{
		$result = array('data' => array());

		$data = $this->db->get('kelas')->result_array();
		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
      	<a href="'.site_url('administrador/kelas/edit/'.$value['id']).'" class="badge badge-warning">Edit</a>
      	<a href="'.site_url('administrador/kelas/delete/'.$value['id']).'" onclick="'.$confirm.'" class="badge badge-danger">Delete</a>
			';

			$result['data'][$key] = array(
				$no,
				$value['kode_kelas'],
				$value['nama_kelas'],
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function index()
	{
		$data['title'] = 'Daftar <strong>Kelas</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('name', 'Nama Kelas', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/kelas/index', $data);
			$this->load->view('backend/templates/footer');
		else:
			$this->db->insert('kelas', [
				'nama_kelas' => $this->input->post('name'),  
				'kode_kelas' => $this->input->post('kode_kelas')
			]);

			$this->session->set_flashdata('message', '<div class="alert alert-success">New kelas added</div>');
			redirect('administrador/kelas');
		endif;
	}

	public function edit($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/kelas");
		$kelas = $this->menu->first("kelas", 'id', $id); 
		if(empty($kelas)) redirect("administrador/kelas"); 

		$kelas = $kelas->row();
		$data = array('kelas' => $kelas);

		$data['title'] = 'Edit <strong>Kelas</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('name', 'Nama Kelas', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/kelas/index', $data);
			$this->load->view('backend/templates/footer');
		else:
			$data = array(
				'nama_kelas' => $this->input->post('name', true),
				'kode_kelas' => $this->input->post('kode_kelas')
			);

			$this->menu->update('id', $id, $data, 'kelas'); #metode untuk update data.
			$this->session->set_flashdata("message", 
				'<div class="alert alert-success">ID Kelas <strong>'.$id.'</strong> Telah Diupdate</div>');
			redirect('administrador/kelas');
		endif;
	}

	public function delete($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/kelas"); 
		$this->session->set_flashdata("message", '<div class="alert alert-danger">ID Kelas <strong>'.$id.'</strong> Telah Dihapus</div>');
		$this->menu->delete('id', $id, 'kelas');
		redirect('administrador/kelas');
	}
}