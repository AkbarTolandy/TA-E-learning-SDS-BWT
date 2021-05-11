<?php 

function is_logged_in()
{
	$ci = get_instance();

	if(!$ci->session->userdata('username')) {
		redirect('administrador/auth');
	} else {
		$role_id = $ci->session->userdata('role_id');
		$base_url = current_url();
		$url = str_replace(base_url(), "", $base_url);

		$queryMenu = $ci->db->get_where('user_submenu', [
		 	'url' => $url
		])->row_array();

		$menu_id = $queryMenu['menu_id'];
		$userAccess = $ci->db->get_where('user_access_menu', [
		 	'role_id' => $role_id,
		 	'menu_id' => $menu_id
		]);

		if($userAccess->num_rows() < 1) {
		 	redirect('administrador/auth/blocked');
		}
	}
}

function is_admin()
{
	$ci = get_instance();
	if($ci->session->userdata('role_id') != 1) {
		redirect('administrador/user');
	}
}

function is_user()
{
	$ci = get_instance();
	if($ci->session->userdata('role_id') != 3) {
		redirect('administrador/user');
	}
}

function is_auth()
{
	$ci = get_instance();
	if(!$ci->session->userdata('username')) {
		redirect('administrador');
	}
}

function check_access($role_id, $menu_id) 
{
	$ci = get_instance();

	$ci->db->where('role_id', $role_id);
	$ci->db->where('menu_id', $menu_id);
	$result = $ci->db->get('user_access_menu');

	if($result->num_rows() > 0) :
		return 'checked="checked"';
	endif;
}

 ?>