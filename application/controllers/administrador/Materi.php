<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'Materi';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/materi/index', $data);
		$this->load->view('backend/templates/footer');
	}

	public function getMateriOnline()
	{
		$result = array('data' => array());

		$user = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->db->select('pelajaran_id');
		$mengajar = $this->db->get_where('mengajar', ['guru_id' => $user['id']])->row_array();
		$pelajaran_id = $mengajar['pelajaran_id'];

		$data = $this->db->query("SELECT * FROM materi 
			WHERE pelajaran_id = '$pelajaran_id' ORDER BY id DESC")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			// button
			$buttons = '
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">

			    <li><a href="'.site_url('administrador/materi/show/'. $value['id']).'" class="dropdown-item"> 
			    	<i class="fas fa-eye"></i> Detail</a></li>
			    <li><a href="'.site_url('administrador/materi/edit/'. $value['id']).'" class="dropdown-item">
			    	<i class="fas fa-edit"></i> Edit</a></li>
			    <li><a href="'.site_url('administrador/materi/destroy/'. $value['id']).'" onclick="'.$confirm.'" class="dropdown-item">
			    	<i class="fas fa-trash"></i> Hapus</a></li>			    
			  </ul>
			</div>
			';

			if($value['is_publish'] == 1) :
				$active = '<span class="badge badge-success">Yes</span>';
			else:
				$active = '<span class="badge badge-danger">No</span>';
			endif;

			$date = date('d F Y H:i:s', strtotime($value['created_at']));

			$result['data'][$key] = array(
				$no,
				$value['bab'],
				$value['title'],
				$date,

				$active,
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function getTugasOnline($materi_id)
	{
		$result = array('data' => array());

		$data = $this->db->query("SELECT * FROM absen 
			WHERE materi_id = '$materi_id' ORDER BY id DESC")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";

			$user = $this->db->get_where('siswa', 
			['user_id' => $value['siswa_id']])->row_array();
			// button
			$buttons = '<a href="'.base_url('assets/backend/tmp/tugas/'.$value['file_tugas']).'">Download</a>';

			$result['data'][$key] = array(
				$no,
				$user['name'],
				$value['tanggal_hadir'],
				$value['file_tugas'],
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
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

	public function store()
	{
		is_auth();
		$data['title'] = 'Tambah <strong>Materi</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$idguru = $data['user']['id'];

		$data['pelajaran'] = $this->db->query("SELECT b.* 
			FROM mengajar a 
			JOIN pelajaran b ON a.pelajaran_id = b.id AND a.guru_id = '$idguru' ")->result_array();

		$this->form_validation->set_rules('bab', 'Pertemuan', 'trim|required');
		$this->form_validation->set_rules('title', 'Judul Materi', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');

		$this->form_validation->set_rules('precondition', 'Prasyarat', 'trim|required');

		$this->form_validation->set_rules('pelajaran_id', 'Pelajaran', 'trim|required');
		$this->form_validation->set_rules('file', 'File', 'callback_file_check');

		if($this->form_validation->run() === FALSE) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/materi/create', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'bab' => $post['bab'],
				'title' => $post['title'],
				'slug' => $post['slug'],
				'pelajaran_id' => $post['pelajaran_id'],
				'is_publish' => (!empty($post['is_publish'])) ? $post['is_publish'] : 0,
				'description' => $post['description'],
				'precondition' => $post['precondition'],
				'created_at' => $post['created_at'] . ":00",
			);

			#upload gambar untuk proses insert
			if($_FILES["file"]["name"] !== "") : #bila gambar covernya tidak kosong
				$this->set_upload();

				#jika berhasil diupload.
				if($this->upload->do_upload("file") ) :
					$file = $this->upload->data();
					$url = $file['file_name'];	
					$data['document'] = $url;

					$this->db->insert("materi", $data); #simpan data
					$_id = $this->db->insert_id();

					$this->session->set_flashdata("message", '<div class="alert alert-success">ID Materi Online <strong>'.$_id.'</strong> Baru Ditambahkan</div>');
					redirect('administrador/materi');
				else:
					$this->error_upload();
					redirect('administrador/materi/store');
				endif;
			endif;

		endif;
	}

	private function set_upload()
	{
		$config['upload_path']          = './assets/backend/tmp/materi'; #directory untuk menyimpan gambar/file
    $config['allowed_types']        = 'pdf|docx'; #jenis dokumen
    $config['max_size']             = 20480; // Limitasi 1 file image 10mb

    $this->upload->initialize($config);
	}

	private function error_upload()
	{
		$error = array('errors' => $this->upload->display_errors()); #show errornya
		$this->session->set_flashdata('error-upload', '<div class="alert alert-danger">'.$error['errors'].'</div>');
	}

	public function show($id = null)
	{
		is_auth();
		$course = $this->getSingle($id);

		$data = array('course' => $course);

		$data['title'] = 'Detail <strong>Materi Online</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/materi/detail', $data);
		$this->load->view('backend/templates/footer');
	}

	public function edit($id = null)
	{
		is_auth();
		$materi = $this->getSingle($id);

		$data = array('materi' => $materi);

		$data['title'] = 'Edit <strong>Materi Online</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$idguru = $data['user']['id'];

		$data['pelajaran'] = $this->db->query("SELECT b.* 
			FROM mengajar a JOIN pelajaran b 
			ON a.pelajaran_id = b.id AND a.guru_id = '$idguru' ")->result_array();

		$this->form_validation->set_rules('bab', 'Pertemuan', 'trim|required');
		$this->form_validation->set_rules('title', 'Judul Materi', 'trim|required');
		$this->form_validation->set_rules('precondition', 'Prasyarat', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');

		$this->form_validation->set_rules('pelajaran_id', 'Pelajaran', 'trim|required');

		if($this->form_validation->run() === FALSE) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/materi/edit', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();

			$data = array(
				'bab' => $post['bab'],
				'title' => $post['title'],
				'slug' => $post['slug'],
				'pelajaran_id' => $post['pelajaran_id'],
				'precondition' => $post['precondition'],
				'is_publish' => (!empty($post['is_publish'])) ? $post['is_publish'] : 0,
				'description' => $post['description'],
				'updated_at' => date('Y-m-d H:i:s')
			);

			if(!empty($id)) :
				if($_FILES["file"]["name"] !== "") : #bila gambar covernya tidak kosong
					$this->set_upload();

					#jika berhasil diupload.
					if($this->upload->do_upload("file")) :
						$file = $this->upload->data();
						$url = $file['file_name'];	

						$data['document'] = $url;

						$oldFile = $materi->document;
						if($oldImage != '') :
							unlink(FCPATH. 'assets/backend/tmp/materi/'. $oldFile);
						endif;

						$this->db->update('materi', $data, array('id' => $id)); #metode untuk update data.

						$this->session->set_flashdata("message", '<div class="alert alert-success">Materi Online ID <strong>'.$id.'</strong> Telah Diupdate</div>');
						redirect('administrador/materi');
					else:
						$this->error_upload();
						redirect('administrador/materi/edit/' .$id);
					endif;

				else:
					$this->db->update('materi', $data, array('id' => $id)); #metode untuk update data.

					$this->session->set_flashdata("message", '<div class="alert alert-success">Materi Online ID <strong>'.$id.'</strong> Telah Diupdate</div>');
					redirect('administrador/materi');
				endif;
			endif;
		endif;
	}

	public function destroy($id = null)
	{
		is_auth();
		$materi = $this->getSingle($id);

		$filename = './assets/backend/tmp/materi/'. $materi->document;
		if (file_exists($filename)) :
	    unlink($filename);
	  endif; 

		$this->session->set_flashdata("message", 
			'<div class="alert alert-danger">ID Materi online <strong>'.$id.'</strong> Deleted</div>');
		$this->menu->delete('id', $id, 'materi'); 
		redirect('administrador/materi');
	}


	public function getSingle($id)
	{
		if($id == 0 && empty($id)) redirect("administrador/materi"); 

		$materi = $this->menu->first("materi", 'id', $id);
		if(empty($materi)) redirect("administrador/materi"); 
		return $materi = $materi->row();
	}

}