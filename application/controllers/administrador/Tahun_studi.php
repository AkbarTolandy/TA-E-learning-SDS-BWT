<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_studi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function gettahunstudi()
	{
		$result = array('data' => array());

		$this->db->order_by('id', 'DESC');
		$data = $this->db->get('tahun_ajaran')->result_array();
		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			#button action
			$buttons = '
      	<a href="'.site_url('administrador/tahun-studi/edit/'.$value['id']).'" class="badge badge-warning">Edit</a>
      	<a href="'.site_url('administrador/tahun-studi/delete/'.$value['id']).'" onclick="'.$confirm.'" class="badge badge-danger">Delete</a>
			';

			$result['data'][$key] = array(
				$no,
				$value['year'],
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function index()
	{
		$data['title'] = 'Tahun <strong>Ajaran</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/tahun-studi/index', $data);
			$this->load->view('backend/templates/footer');
		else:
			$this->db->insert('tahun_ajaran', [ 
				'year' => $this->input->post('tahun_ajaran')
			]);

			$this->session->set_flashdata('message', '<div class="alert alert-success">Tahun Ajaran Ditambahkan</div>');
			redirect('administrador/tahun-studi');
		endif;
	}

	public function edit($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/tahun-studi");
		$tahun_ajaran = $this->menu->first("tahun_ajaran", 'id', $id); 
		if(empty($tahun_ajaran)) redirect("administrador/tahun-studi"); 

		$tahun_ajaran = $tahun_ajaran->row();
		$data = array('tahun_ajaran' => $tahun_ajaran);

		$data['title'] = 'Edit <strong>Tahun Ajaran</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/tahun-studi/index', $data);
			$this->load->view('backend/templates/footer');
		else:
			$data = array(
				'year' => $this->input->post('tahun_ajaran')
			);

			$this->menu->update('id', $id, $data, 'tahun_ajaran'); #metode untuk update data.
			$this->session->set_flashdata("message", 
				'<div class="alert alert-success">ID Tahun Studi <strong>'.$id.'</strong> Telah Diupdate</div>');
			redirect('administrador/tahun-studi');
		endif;
	}

	public function delete($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/tahun-studi"); 
		$this->session->set_flashdata("message", '<div class="alert alert-danger">ID Tahun Studi <strong>'.$id.'</strong> Telah Dihapus</div>');

		$this->menu->delete('id', $id, 'tahun_ajaran');
		redirect('administrador/tahun-studi');
	}
}