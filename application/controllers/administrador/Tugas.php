<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tugas extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'Daftar Pelajaran';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$data['pelajaran'] = $this->db->query("SELECT * FROM mengajar")->result();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/tugas/index', $data);
		$this->load->view('backend/templates/footer');
	}

	public function detail($pelajaran_id)
	{
		#is_user();
		if($pelajaran_id == 0 && empty($pelajaran_id)) redirect("administrador/tugas"); 

		$pelajaran = $this->db->query("SELECT * FROM pelajaran WHERE id = $pelajaran_id");

		if(empty($pelajaran)) redirect("administrador/tugas"); 
		$pelajaran = $pelajaran->row();		

		$data = array('pelajaran' => $pelajaran);

		$data['title'] = 'Materi';

		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$data['member_id'] = $data['user']['id'];
		$user_id = $data['user']['id'];
		
		$this->form_validation->set_rules('materi_id', 'Materi', 'trim|required');
		$this->form_validation->set_rules('file', 'File', 'callback_file_check');

		if($this->form_validation->run() === FALSE) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/tugas/show', $data);
			$this->load->view('backend/templates/footer');
		else:

			$post = $this->input->post();
			$pelajaran_id = $post['pelajaran_id'];

			$this->db->select('id');
			$absen = $this->db->get_where('absen', ['siswa_id' => $user_id])->row();
			$id = $absen->id;

			$data = array(
				'materi_id' => $post['materi_id'],
				'pelajaran_id' => $pelajaran_id,
				'status' => 1
			);

			#upload gambar untuk proses insert
			if($_FILES["file"]["name"] !== "") :
				$this->set_upload();

				#jika berhasil diupload.
				if($this->upload->do_upload("file") ) :
					$file = $this->upload->data();
					$url = $file['file_name'];	
					$data['file_tugas'] = $url;

					$this->db->update('absen', $data, array('id' => $id)); #metode untuk update data.

					$this->session->set_flashdata("message", '<div class="alert alert-success">Tugas sudah disubmit.</div>');
					redirect('administrador/tugas/detail/' .$pelajaran_id);
				else:
					$this->error_upload();
					redirect('administrador/tugas/detail/' .$pelajaran_id);
				endif;
			endif;

		endif;
	}

	public function absen()
	{
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		$pelajaran_id = $this->input->post('pelajaran_id');

		$this->db->set([ 
			'hari' => date('l'),
			'pelajaran_id' => $pelajaran_id,
			'tanggal_hadir' => date('Y-m-d'),
			'pukul' => date('H:i:s'),
			'status' => 0
		]);

		$this->db->where('siswa_id', $data['user']['id']);
		$this->db->update('absen');

		$this->session->set_flashdata('message', 
			'<div class="alert alert-success">Terimakasih, Selamat belajar yak!!</div>');
		redirect('administrador/tugas/detail/' .$pelajaran_id);
	}

	private function set_upload()
	{
		$config['upload_path']          = './assets/backend/tmp/tugas'; #directory untuk menyimpan gambar/file
   		$config['allowed_types']        = 'pdf|docx'; #jenis dokumen
    	$config['max_size']             = 20480; // Limitasi 1 file image 10mb

    	$this->upload->initialize($config);
    }

    private function error_upload()
    {
		$error = array('errors' => $this->upload->display_errors()); #show errornya
		$this->session->set_flashdata('error-upload', '<div class="p-1 text-white alert-danger mt-3">'.$error['errors'].'</div>');
	}

	public function file_check($str)
	{
		$allowed_mime_type_arr = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		$mime = get_mime_by_extension($_FILES['file']['name']);

		if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="") :
			if(in_array($mime, $allowed_mime_type_arr)) :
				return true;
			else:
				$this->form_validation->set_message('file_check', 'Please select only pdf/docx file.');
				return false;
			endif;
		else:
			$this->form_validation->set_message('file_check', 'Please choose a file to upload.');
			return false;
		endif;
	}

}