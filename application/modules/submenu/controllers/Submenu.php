<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('login/Login_db', 'Login');
        $this->load->model('submenu/Submenu_db', 'Submenu');
    }

    public function index()
    {
        $data['user']     = $this->Login->data_user($this->session->userdata('user_id'));
        $data['menu']     = $this->Login->get_array_menu($this->session->userdata('role_id'));
        $data['list']     = $this->Submenu->list_data();
        $data['listmenu'] = $this->Submenu->get_menu();

        $data['content'] = $this->load->view('submenu/submenu.php', $data, true);
        $this->load->view('template/landing_template', $data);
    }

    public function ajax_edit($id)
    {
        $data = $this->Submenu->get_by_id($id);
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
            'menu_id'             => htmlentities($this->input->post('menu')),
            'submenu_title'       => htmlentities($this->input->post('title')),
            'submenu_url'         => htmlentities($this->input->post('url')),
            'submenu_icon'        => htmlentities($this->input->post('icon')),
            'is_active'           => $is_active
        );


        $this->Submenu->save($data);
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
            'menu_id'             => htmlentities($this->input->post('menu')),
            'submenu_title'       => htmlentities($this->input->post('title')),
            'submenu_url'         => htmlentities($this->input->post('url')),
            'submenu_icon'        => htmlentities($this->input->post('icon')),
            'is_active'           => $is_active
        );

        $this->Submenu->update(array('submenu_id' => htmlentities($this->input->post('id'))), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Submenu->get_by_id($id);
        $this->Submenu->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('menu') == '') {
            $data['inputerror'][] = 'menu';
            $data['error_string'][] = 'Wajib dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('title') == '') {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('url') == '') {
            $data['inputerror'][] = 'url';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('icon') == '') {
            $data['inputerror'][] = 'icon';
            $data['error_string'][] = 'Wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
