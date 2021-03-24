<?php

function is_logged_in()
{
	$ci = get_instance();

	if ($ci->session->userdata('logged_in') == 0) {
		redirect(base_url() . 'login');
	} else {
		$role = $ci->session->userdata('role_id');
		$menu = $ci->uri->segment('1');

		$queryMenu 	= $ci->db->get_where('user_submenu', ['submenu_url' => $menu])->row_array();
		$menu_id	= $queryMenu['menu_id'];

		$userAccess	= $ci->db->get_where('user_access_menu', ['role_id' => $role, 'menu_id' => $menu_id]);

		if ($userAccess->num_rows() < 1) {
			redirect('blocked');
		}
	}
}

function check_access($role, $menu)
{
	$ci = get_instance();

	$access = $ci->db->get_where('user_access_menu', ['role_id' => $role, 'menu_id' => $menu]);
	if ($access->num_rows() > 0) {
		return "checked";
	}
}
