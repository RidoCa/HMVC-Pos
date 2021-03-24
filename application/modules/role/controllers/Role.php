<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('role/Role_db', 'Role');
    }

    public function index()
    {
        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list'] = $this->Role->list_data();

        $data['content'] = $this->load->view('role/role.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function access()
    {
        $id = $this->uri->segment(3);

        $data['user'] = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu'] = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['role'] = $this->Role->get_role($id);
        $data['list'] = $this->Role->list_menu();

        $data['content']     = $this->load->view('role/role_access.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_access()
    {
        $role_id = htmlentities($this->input->post('roleId'));
        $menu_id = htmlentities($this->input->post('menuId'));

        $data = array(
                'role_id'     => $role_id,
                'menu_id'     => $menu_id,
            );

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) :
            $this->Role->save_access($data);
        else :
            $this->Role->delete_access($role_id, $menu_id);
        endif;

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->Role->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();

        if (htmlentities($this->input->post('is_active'))) :
            $is_active = htmlentities($this->input->post('is_active'));
        else :
            $is_active = "0";
        endif;


        $data = array(
            'role_id'      => htmlentities($this->input->post('acronim')),
            'role_name'    => htmlentities($this->input->post('role')),
            'is_active'        => $is_active
        );

        $this->Role->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();

        if (htmlentities($this->input->post('is_active'))) :
            $is_active = htmlentities($this->input->post('is_active'));
        else :
            $is_active = "0";
        endif;


        $data = array(
            'role_name'    => htmlentities($this->input->post('role')),
            'is_active'        => $is_active
        );

        $this->Role->update(array('role_id' => htmlentities($this->input->post('acronim'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Role->get_by_id($id);
        $this->Role->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('acronim') == '') {
            $data['inputerror'][] = 'acronim';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('role') == '') {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
