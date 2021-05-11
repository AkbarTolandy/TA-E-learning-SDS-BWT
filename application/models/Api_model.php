<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function register($name, $email, $password) 
	{
		$data = [
			'email' => htmlspecialchars($email),
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'role_id' => 3,
			'is_active' => 0
		];

		$token = $this->generateRandomString(32);
		$user_token = [
			'token' => $token,
			'email' => $email,
			'date' => time()
		];

    $this->db->insert('users', $data);
		$user_id = $this->db->insert_id();

		$siswa['user_id'] = $user_id;
		$siswa['name'] = htmlspecialchars($name);
		$siswa['avatar'] = 'default.png';
		
		$this->db->insert('siswa', $siswa);
		$this->db->insert('user_token', $user_token);

		#kirim email
		$this->_sendEmail($email, $token, 'verify');

		if($user) :
			return [
				'status' => true,
				'id' => $_iduser,
				'message' => 'Congratulation! your account has been created. Please activate your account.'
			];
		endif;
	}

	private function generateRandomString($length = 10) 
	{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
	}

	public function forgot($email) 
	{
		$data = array();
		$token = $this->generateRandomString(32);
		$user_token = [
			'token' => $token,
			'email' => $email,
			'date' => time()
		];	

		$this->db->insert('user_token', $user_token);

		#kirim email
		$this->_sendEmail($email, $token, 'forgot');

		$data['status'] = true;
		$data['message'] = 'Please, check your email to reset your password';
		return $data;
	}

	public function is_login($email, $password)
	{
		$user = $this->get_data('email', $email);
		$hash = $user->password;

		if(password_verify($password, $hash)) :
			return true;
		endif;

		return false;
	}

	public function get_data($key = null, $value = null)
	{
		if($key !== null) :
			$user = $this->db->get_where('users', [$key => $value]);
			return $user->row();
		endif;

		return $this->db->query("SELECT a.id, a.created_at, a.role_id, a.email, b.name, 
			b.avatar, b.address, b.number_phone, b.gender
			FROM users a 
			JOIN siswa b 
			ON a.id = b.user_id")->result();
	}

	public function update($user, $id)
	{
		$detail_user = array(
			'address' => $user['address'],
			'number_phone' => $user['number_phone'],
			'gender' => $user['gender'],
			'name' => $user['name']
		);

		$this->db->where('user_id', $id);
		$update = $this->db->update('siswa', $detail_user);

		if($update) {
			return [
	  		'status' => true,
	  		'message' => 'User has been updated' 
	  	];
		}
	}

	private function _sendEmail($token, $type)
	{
		$email = $this->input->post('email');
		$config = [
		  'mailtype'  => 'html',
		  'charset'   => 'utf-8',
		  'protocol'  => 'smtp',
		  'smtp_host' => 'smtp.gmail.com',
		  'smtp_user' => '#',  #Email GMAIL
		  'smtp_pass'   => '#',  #Password GMAIL
		  'smtp_crypto' => 'ssl',
		  'smtp_port'   => 465,
		  'crlf'    => "\r\n",
		  'newline' => "\r\n"
		];
 
		#Load library email dan konfigurasinya
    $this->load->library('email', $config);
		$this->email->from('no-reply@ruangsiswa.com', 'Ruang Siswa');
		$this->email->to($email);

		if($type == 'verify') :
			$this->email->subject('Account Verification');
		  $body = 'Click the following URL to activate your account: https://ruang.siswa.com/api/user/verify?email=' .$email. '&token=' .$token;
			$this->email->message($body);
		else:
			$this->email->subject('Reset Password');
			$body = 'Click this link to reset your password: https://ruang.siswa.com/api/user/reset-password?email=' .$email. '&token=' .$token;
			
			$this->email->message($body);
		endif;

		if($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}
}