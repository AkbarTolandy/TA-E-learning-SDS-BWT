<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'Daftar Guru';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/guru/index', $data);
		$this->load->view('backend/templates/footer');
	}

	public function getGuru()
	{
		$result = array('data' => array());

		$data = $this->db->query("SELECT * FROM users WHERE role_id = 2")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			#button action
			$confirm = "return confirm('Are you sure delete this data?')";

			$buttons = '
			<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="'.site_url('administrador/guru/show/'. $value['id']).'" title="Detail Guru" 
			class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>

			<li><a href="'.site_url('administrador/guru/upload-jadwal/'. $value['id']).'" 
			class="dropdown-item"><i class="fas fa-calendar"></i> Upload Jadwal</a></li>

			<li><a href="'.site_url('administrador/guru/edit/'. $value['id']).'" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a></li>
			<li><a href="'.site_url('administrador/guru/destroy/'. $value['id']).'" onclick="'.$confirm.'"
			data-title="'.$value['username'].'" 
			class="dropdown-item"><i class="fas fa-trash"></i> Hapus</a>
			</li>  
			</ul>
			</div>
			';

			$user = $this->db->get_where('guru', ['user_id' => $value['id']])->row_array();

			if($value['is_active'] == 1) :
				$active = '<span class="badge badge-success">Active</span>';
			else:
				$active = '<span class="badge badge-danger">InActive</span>';
			endif;

			$checked = $value['is_active'] ? 'checked' : '';

			$checkbox = '<div class="custom-control custom-checkbox small">
			<input type="checkbox" class="custom-control-input delete_checkbox" 
			id="customCheck-'.$value['id'].'" value="'.$value['id'].'" '.$checked.'>
			<label class="custom-control-label" for="customCheck-'.$value['id'].'"></label>
			</div>';

			$date = date('d F Y H:i:s', strtotime($value['created_at']));
			if(!empty($user['avatar'])) {
				$image = '<img width="100" src="'.base_url('assets/backend/img/profile/') . $user['avatar'].'" alt="'.$user['name'].'">';
			} else {
				$image = '<img width="100" src="'.base_url('assets/backend/img/profile/default.png').'" alt="'.$user['name'].'">';
			}

			$result['data'][$key] = array(
				$no,
				$checkbox,
				$image,
				$user['name']
				."<p class='mt-3'><strong>No Telepon: </strong> <br>".$user['number_phone']."</p>",
				$date,
				$active,
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function store()
	{
		is_admin();
		$data['title'] = 'Tambah <strong>Guru</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->db->select('id, nama_pelajaran');
		$data['pelajaran'] = $this->db->get_where('pelajaran', array('status' => 1))->result_array();

		$this->form_validation->set_rules('username', 'Username', 
			'trim|required|is_unique[users.username]', [
				'is_unique' => 'This Username has already registered!'
			]);

		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|matches[password2]', 
			[
				'matches' => 'Password dont match!',
				'min_length' => 'Password to short' 
			]
		);

		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('number_phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');

		if($this->form_validation->run() === FALSE) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/guru/create', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = [
				'username' => htmlspecialchars($post['username']),
				'password' => password_hash($post['password'], PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => (!empty($post['is_active'])) ? $post['is_active'] : 0,
			];

			$this->db->insert("users", $data); #simpan data
			$_id = $this->db->insert_id();

			$guru = array(
				'name' => $post['name'],
				'user_id' => $_id,
				'gender' => $post['gender'],
				'avatar' => 'default.png',
				'number_phone' => $post['number_phone']
			);

			$this->db->insert("guru", $guru);

			if(!empty($post['pelajaran'])) :
				foreach ($post['pelajaran'] as $value) :
					$pelajaran = [
						'guru_id' => $_id,
						'pelajaran_id' => $value,
						'status' => 1
					];

					$this->db->insert("mengajar", $pelajaran);
				endforeach;
			endif;

			$this->session->set_flashdata("message", '<div class="alert alert-success">ID Guru <strong>'.$_id.'</strong> baru ditambahkan</div>');
			redirect('administrador/guru');
		endif;
	}

	public function show($id = null)
	{
		is_auth();
		$guru = $this->db->query("SELECT b.id as guru_id, b.name, b.gender, b.number_phone, b.avatar, a.* 
			FROM users a JOIN guru b 
			ON a.id = b.user_id AND b.user_id = '$id' ");

		if($guru->num_rows() == 0) redirect("administrador/guru");  
		$guru = $guru->row();

		$data = array('guru' => $guru);

		$data['title'] = 'Detail <strong>Guru</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/guru/show', $data);
		$this->load->view('backend/templates/footer');
	}

	public function edit($id = null)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/guru");

		$guru = $this->db->query("SELECT b.id as guru_id, b.name, b.gender, b.number_phone, b.avatar, a.* 
			FROM users a JOIN guru b 
			ON a.id = b.user_id AND b.user_id = '$id' ");

		if($guru->num_rows() == 0) redirect("administrador/guru"); 

		$guru = $guru->row();
		$data = array('guru' => $guru);

		$data['title'] = 'Edit <strong>Guru</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$user = $data['user'];
		$this->db->select('id, nama_pelajaran');
		$data['pelajaran'] = $this->db->get_where('pelajaran', array('status' => 1))->result_array();

		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('number_phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/guru/edit', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'is_active' => (!empty($post['is_active'])) ? $post['is_active'] : 0
			);

			$this->menu->update('id', $id, $data, 'users'); #metode untuk update data.

			$guru = array(
				'name' => $post['name'],
				'gender' => $post['gender'],
				'updated_at' => date("Y-m-d H:i:s"),
				'number_phone' => $post['number_phone']
			);

			$this->menu->update('user_id', $id, $guru, 'guru'); #metode untuk update data.

			$this->session->set_flashdata("message", '<div class="alert alert-success">ID Guru <strong>'.$id.'</strong> Sudah Diupdated</div>');
			redirect('administrador/guru');
		endif;
	}

	public function destroy($id = null)
	{
		$this->session->set_flashdata("message", 
			'<div class="alert alert-danger">ID Guru <strong>'.$id.'</strong> deleted</div>');
		$this->menu->delete('user_id', $id, 'guru');
		$this->menu->delete('id', $id, 'users'); 
		redirect('administrador/guru');
	}

	public function block($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/guru"); 

		$guru = $this->db->query("SELECT is_active FROM users WHERE id = '$id' ");
		if($guru->num_rows() == 0) redirect("administrador/guru"); 

		$active = $guru->row('is_active');
		$data = array(
			'is_active' => ($active == 1) ? 0 : 1
		);

		$pesan = ($active == 1) ? 'Di Non Aktifkan' : 'Di Aktifkan';

		$this->session->set_flashdata("message", 
			'<div class="alert alert-danger">ID Guru <strong>'.$id.'</strong> Sudah '.$pesan.'</div>');

		$this->menu->update('id', $id, $data, 'users'); #metode untuk update data.
		redirect('administrador/guru');
	}

	public function absen()
	{
		$data['title'] = 'Rekap Absen';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/guru/absen', $data);
		$this->load->view('backend/templates/footer');
	}

	public function getAbsenSiswa()
	{
		$result = array('data' => array());
		$user = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row();

		$this->db->select('pelajaran_id');
		$mengajar = $this->db->get_where('mengajar', ['guru_id' => $user->id])->row();

		$data = $this->db->query("SELECT * FROM absen 
			WHERE pelajaran_id = '$mengajar->pelajaran_id' ")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			$buttons = '
			<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="#" title="Detail Absen" 
			class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
			</ul>
			</div>
			';

			$user = $this->db->get_where('siswa', ['user_id' => $value['siswa_id']])->row_array();

			if($value['status'] == 1) :
				$active = '<span class="badge badge-success">Yes</span>';
			else:
				$active = '<span class="badge badge-danger">No</span>';
			endif;

			$checked = $value['status'] ? 'checked' : '';

			$checkbox = '<div class="custom-control custom-checkbox small">
			<input type="checkbox" class="custom-control-input delete_checkbox" 
			id="customCheck-'.$value['id'].'" value="'.$value['id'].'" '.$checked.'>
			<label class="custom-control-label" for="customCheck-'.$value['id'].'"></label>
			</div>';

			$date = date('d F Y', strtotime($value['tanggal_hadir']));

			$result['data'][$key] = array(
				$no,
				$checkbox,
				$user['name'],
				$value['hari'],
				$value['pukul'],
				$date,
				$active,
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}
	
	public function laporan()
	{
		$data['title'] = 'Laporan Guru';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/guru/laporan', $data);
		$this->load->view('backend/templates/footer');
	}

	public function getLaporanGuru()
	{
		$result = array('data' => array());

		$data = $this->db->query("SELECT * FROM users WHERE role_id = 2")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			$buttons = '
			<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="'.site_url('administrador/guru/show/'. $value['id']).'" title="Detail Trainer" 
			class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
			</ul>
			</div>
			';

			$user = $this->db->get_where('guru', ['user_id' => $value['id']])->row_array();

			if($value['is_active'] == 1) :
				$active = '<span class="badge badge-success">Yes</span>';
			else:
				$active = '<span class="badge badge-danger">No</span>';
			endif;

			$checked = $value['is_active'] ? 'checked' : '';

			$checkbox = '<div class="custom-control custom-checkbox small">
			<input type="checkbox" class="custom-control-input delete_checkbox" 
			id="customCheck-'.$value['id'].'" value="'.$value['id'].'" '.$checked.'>
			<label class="custom-control-label" for="customCheck-'.$value['id'].'"></label>
			</div>';

			$date = date('d F Y H:i:s', strtotime($value['created_at']));
			if(!empty($user['avatar'])) {
				$image = '<img width="100" src="'.base_url('assets/backend/img/profile/') . $user['avatar'].'" alt="'.$user['name'].'">';
			} else {
				$image = '<img width="100" src="'.base_url('assets/backend/img/profile/default.png').'" alt="'.$user['name'].'">';
			}

			$result['data'][$key] = array(
				$no,
				$checkbox,
				$image,
				$user['name']
				."<p class='mt-3'><strong>No Telepon: </strong> <br>".$user['number_phone']."</p>",
				$date,
				$active,
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function cetak_laporan()
	{
		$mpdf = new \Mpdf\Mpdf();

		$data = '<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="UTF-8">
		<title>Daftar Guru</title>
		<style>
		table {
			font-family: sans-serif;
			border:1px solid #ccc;
			width: 100%
		}

		td, th {
			padding: 5px
		}

		tr:nth-child(even) {
			background: #ccc
		}
		</style>
		</head>
		<body>
		<h1>Laporan Data Guru</h1>
		<table>
		<tr>
		<th>No</th>
		<th>Nama</th>
		<th>Nomor Telepon</th>
		<th>Jenis Kelamin</th>
		</tr>';

		$no = 1;
		$guru = $this->db->query("SELECT * FROM guru")->result_array();

		foreach($guru as $g) {

			$gender = $g['gender'] == 'L' ? 'Laki Laki' : 'Perempuan';

			$data .= '<tr>
			<td>'.$no++.'</td>
			<td>' .$g['name'].'</td>
			<td>'.$g['number_phone'].'</td>
			<td>'.$gender.'</td>
			</tr>';
		}

		$data .= '</table>
		</body>
		</html>';


		$mpdf->WriteHTML($data);
		$mpdf->Output('laporan-guru.pdf', \Mpdf\Output\Destination::INLINE);
		exit;
	}

	public function jadwal()
	{
		$data['title'] = 'Jadwal';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/guru/jadwal', $data);
		$this->load->view('backend/templates/footer');
	}

	public function kelas()
	{
		# code...
	}

	public function edit_jadwal($jadwal_id)
	{
		# code...
	}

	public function getJadwal()
	{
		$result = array('data' => array());

		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		$guru_id = $data['user']['id'];

		if($this->session->userdata('role_id') == 1) :
			$data = $this->db->query("SELECT * FROM mengajar")->result_array();
		else:
			$data = $this->db->query("SELECT * FROM mengajar WHERE guru_id = $guru_id")->result_array();
		endif;

		$no = 1;
		foreach ($data as $key => $value) :
			$buttons = '
			<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="'.site_url('administrador/guru/kelas/'. $value['id']).'" 
			class="dropdown-item"><i class="fas fa-eye"></i> Lihat Murid</a></li>

			<li><a href="'.site_url('administrador/guru/edit-jadwal/'. $value['id']).'" 
			class="dropdown-item"><i class="fas fa-edit"></i> Edit</a></li>
			</ul>
			</div>
			';

			$guru_mengajar_id = $value['guru_id'];
			$guru = $this->db->query("SELECT name 
				FROM guru WHERE user_id = '$guru_mengajar_id'")->row_array();

			$this->db->select('nama_pelajaran');
			$pelajaran = $this->db->get_where('pelajaran', ['id' => $value['pelajaran_id']])->row_array();

			if($value['kelas_id'] != 0) :
				$this->db->select('nama_kelas');
				$kelas = $this->db->get_where('kelas', ['id' => $value['kelas_id']])->row_array();
			endif;

			if($value['status'] == 1) :
				$active = '<span class="badge badge-success">Yes</span>';
			else:
				$active = '<span class="badge badge-danger">No</span>';
			endif;

			$checked = $value['status'] ? 'checked' : '';

			$checkbox = '<div class="custom-control custom-checkbox small">
			<input type="checkbox" class="custom-control-input delete_checkbox" 
			id="customCheck-'.$value['id'].'" value="'.$value['id'].'" '.$checked.'>
			<label class="custom-control-label" for="customCheck-'.$value['id'].'"></label>
			</div>';

			$result['data'][$key] = array(
				$no,
				$checkbox,
				$guru['name'],
				$kelas['nama_kelas'],
				$value['hari'],
				$value['waktu_mulai']. " - " .$value['waktu_selesai'],
				$pelajaran['nama_pelajaran'],
				$active,
				$buttons
			);

			$no++;
		endforeach;

		echo json_encode($result);
	}

	public function upload_jadwal($guru_id)
	{
		$data['title'] = 'Upload Jadwal';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->db->select('id, kode_kelas, nama_kelas');
		$data['kelas'] = $this->db->get('kelas')->result_array();

		$this->db->select('pelajaran_id');
		$data['mengajar'] = $this->db->get_where('mengajar', array('guru_id' => $guru_id))->result_array();

		$this->form_validation->set_rules('start_time', 'Waktu Mulai', 'trim|required');
		$this->form_validation->set_rules('end_time', 'Waktu Selesai', 'trim|required');
		$this->form_validation->set_rules('day', 'Hari', 'trim|required');
		$this->form_validation->set_rules('kelas_id', 'Kelas', 'trim|required');
		$this->form_validation->set_rules('pelajaran_id', 'Pelajaran', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/guru/upload', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'waktu_mulai' => $post['start_time'],
				'waktu_selesai' => $post['end_time'],
				'hari' => $post['day'],
				'kelas_id' => $post['kelas_id']
			);

			$this->db->set($data);
			$this->db->where('pelajaran_id', $post['pelajaran_id']); 
			$this->db->where('guru_id', $guru_id); 
			$this->db->update('mengajar');
			#metode untuk update data.

			$this->session->set_flashdata("message", '<div class="alert alert-success">Data Jadwal <strong>'.$id.'</strong> sudah Diupdated</div>');
			redirect('administrador/guru');
		endif;
	}

}