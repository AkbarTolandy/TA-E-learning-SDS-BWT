<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Menu_model', 'menu');
	}

	public function index()
	{
		is_logged_in();
		$data['title'] = 'Daftar Murid';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/siswa/index', $data);
		$this->load->view('backend/templates/footer');
	}

	public function create()
	{
		is_admin();
		$data['title'] = 'Tambah <strong>Siswa</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$user = $data['user'];
		$this->db->select('id, kode_kelas, nama_kelas');
		$data['kelas'] = $this->db->get('kelas')->result_array();

		$this->db->order_by('id', 'DESC');
		$data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result_array();

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
		$this->form_validation->set_rules('kelas_id', 'Kelas', 'trim|required');
		$this->form_validation->set_rules('tahun_ajaran_id', 'Tahun Ajaran', 'trim|required');

		$this->form_validation->set_rules('number_phone', 'Telepon', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');

		if($this->form_validation->run() === FALSE) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/siswa/save', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'role_id' => 3,
				'username' => $post['username'],
				'is_active' => (!empty($post['is_active'])) ? $post['is_active'] : 0,
				'password' => password_hash($post['password'], PASSWORD_DEFAULT)
			);

			$this->db->insert("users", $data); #simpan data
			$_id = $this->db->insert_id();

			$siswa = array(
				'user_id' => $_id,
				'address' => $post['address'],
				'kelas_id' => $post['kelas_id'],
				'tahun_ajaran_id' => $post['tahun_ajaran_id'],
				'number_phone' => $post['number_phone'],
				'gender' => $post['gender'],
				'name' => $post['name']
			);

			$this->db->insert('siswa', $siswa);

			$absen = array(
				'siswa_id' => $_id
			);

			$this->db->insert('absen', $absen);
			$this->session->set_flashdata("message", '<div class="alert alert-success">ID Siswa <strong>'.$_id.'</strong> Baru Ditambahkan</div>');
			redirect('administrador/siswa');

		endif;
	}

	public function getSiswa()
	{
		$result = array('data' => array());
		
		$data = $this->db->query("SELECT * FROM users WHERE role_id = 3 ORDER BY id DESC")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			$confirm = "return confirm('Are you sure delete this data?')";
			#button action
			$buttons = '
			<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="'.site_url('administrador/siswa/show/'. $value['id']).'" title="Detail siswa" 
			class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
			<li><a href="'.site_url('administrador/siswa/edit/'. $value['id']).'" class="dropdown-item"><i class="fas fa-edit"></i> Edit</a></li>
			<li><a href="'.site_url('administrador/siswa/delete/'. $value['id']).'" onclick="'.$confirm.'" data-title="'.$value['username'].'" 
			class="dropdown-item"><i class="fas fa-trash"></i> Hapus</a>
			</li>
			</ul>
			</div>
			';

			$user = $this->db->get_where('siswa', ['user_id' => $value['id']])->row_array();

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
				$image = '<img width="100" src="'.base_url('assets/backend/img/profile/boy.png').'" alt="'.$user['name'].'">';
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

	public function show($id = 0)
	{
		is_auth();
		if($id == 0 && empty($id)) redirect("administrador/siswa"); 

		$siswa = $this->db->query("SELECT b.avatar, b.name, b.kelas_id, b.tahun_ajaran_id, b.address, b.gender, b.number_phone, 
			a.* FROM users a JOIN siswa b 
			ON a.id = b.user_id 
			AND b.user_id = '$id' ");

		if($siswa->num_rows() == 0) redirect("administrador/siswa"); 
		$siswa = $siswa->row();

		$data = array('siswa' => $siswa);

		$data['title'] = 'Detail <strong>Siswa</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/siswa/detail', $data);
		$this->load->view('backend/templates/footer');
	}

	public function edit($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/siswa");

		$siswa = $this->db->query("SELECT b.name, b.kelas_id, b.tahun_ajaran_id, b.address, 
			b.number_phone, b.gender, a.*
			FROM users a JOIN siswa b 
			ON a.id = b.user_id AND b.user_id = '$id' ");

		if($siswa->num_rows() == 0) redirect("administrador/siswa");  

		$siswa = $siswa->row();
		$data = array('siswa' => $siswa);
		$this->db->select('id, kode_kelas, nama_kelas');
		$data['kelas'] = $this->db->get('kelas')->result_array();

		$this->db->order_by('id', 'DESC');
		$data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result_array();

		$data['title'] = 'Edit <strong>Siswa</strong>';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();
		
		$user = $data['user'];

		$this->form_validation->set_rules('number_phone', 'Telepon', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required');

		if($this->form_validation->run() === false) :
			$this->load->view('backend/templates/header', $data);
			$this->load->view('backend/templates/sidebar', $data);
			$this->load->view('backend/templates/topbar', $data);
			$this->load->view('backend/siswa/edit', $data);
			$this->load->view('backend/templates/footer');
		else:
			$post = $this->input->post();
			$data = array(
				'is_active' => (!empty($post['is_active'])) ? $post['is_active'] : 0
			);

			$this->menu->update('id', $id, $data, 'users'); #metode untuk update data.

			$siswa = array(
				'address' => $post['address'],
				'number_phone' => $post['number_phone'],
				'kelas_id' => $post['kelas_id'],
				'tahun_ajaran_id' => $post['tahun_ajaran_id'],
				'gender' => $post['gender'],
				'name' => $post['name'],
				'updated_at' => date("Y-m-d H:i:s")
			);

			$this->menu->update('user_id', $id, $siswa, 'siswa'); #metode untuk update data.

			$this->session->set_flashdata("message", '<div class="alert alert-success">ID Siswa <strong>'.$id.'</strong> Sudah Diupdated</div>');
			redirect('administrador/siswa');
		endif;
	}

	public function delete($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/siswa"); 

		$this->session->set_flashdata("message", 
			'<div class="alert alert-danger">ID Siswa <strong>'.$id.'</strong> Sudah Deleted</div>');

		$this->menu->delete('user_id', $id, 'siswa'); 
		$this->menu->delete('id', $id, 'users'); 
		redirect('administrador/siswa');
	}

	public function block($id = 0)
	{
		is_admin();
		if($id == 0 && empty($id)) redirect("administrador/siswa"); 

		$siswa = $this->db->query("SELECT is_active FROM users WHERE id = '$id' ");
		if($siswa->num_rows() == 0) redirect("administrador/siswa"); 

		$active = $siswa->row('is_active');
		$data = array(
			'is_active' => ($active == 1) ? 0 : 1
		);

		$pesan = ($active == 1) ? 'Di Non Aktifkan' : 'Di Aktifkan';

		$this->session->set_flashdata("message", 
			'<div class="alert alert-danger">ID Siswa <strong>'.$id.'</strong> Sudah '.$pesan.'</div>');

		$this->menu->update('id', $id, $data, 'users'); #metode untuk update data.
		redirect('administrador/siswa');
	}

	public function laporan()
	{
		$data['title'] = 'Laporan Siswa';
		$data['user'] = $this->db->get_where('users', 
			['username' => $this->session->userdata('username')])->row_array();

		$this->load->view('backend/templates/header', $data);
		$this->load->view('backend/templates/sidebar', $data);
		$this->load->view('backend/templates/topbar', $data);
		$this->load->view('backend/siswa/laporan', $data);
		$this->load->view('backend/templates/footer');
	}

	public function getLaporanSiswa()
	{
		$result = array('data' => array());
		
		$data = $this->db->query("SELECT * FROM users WHERE role_id = 3 ORDER BY id DESC")->result_array();

		$no = 1;
		foreach ($data as $key => $value) :
			#button action
			$buttons = '
			<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
			<li><a href="'.site_url('administrador/siswa/show/'. $value['id']).'" title="Detail siswa" 
			class="dropdown-item"><i class="fas fa-eye"></i> Detail</a></li>
			</ul>
			</div>
			';

			$user = $this->db->get_where('siswa', ['user_id' => $value['id']])->row_array();

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
		<title>Daftar Siswa</title>
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
		<h1>Laporan Data Siswa</h1>
		<table>
		<tr>
		<th>No</th>
		<th>Nama</th>
		<th>Nomor Telepon</th>
		<th>Kelas</th>
		<th>Jenis Kelamin</th>
		</tr>';

		$no = 1;
		$siswa = $this->db->query("SELECT * FROM siswa")->result_array();
		
		
		foreach($siswa as $s) {
			$kelas_id = $s['kelas_id'];

			$kelas = $this->db->query("SELECT * FROM kelas WHERE id = $kelas_id")->row_array();
			$gender = $s['gender'] == 'L' ? 'Laki Laki' : 'Perempuan';

			$data .= '<tr>
			<td>'.$no++.'</td>
			<td>' .$s['name'].'</td>
			<td>'.$s['number_phone'].'</td>
			<td>'.$kelas['nama_kelas'].'</td>
			<td>'.$gender.'</td>
			</tr>';
		}

		$data .= '</table>
		</body>
		</html>';


		$mpdf->WriteHTML($data);
		$mpdf->Output('laporan-siswa.pdf', \Mpdf\Output\Destination::INLINE);
		exit;
	}

}