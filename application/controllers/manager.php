<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('form', 'url', 'date'));
        $this->data = null;
        
        if($this->session->userdata('role') != 2) redirect('login');
    }
    
    function index() {
        $this->load->model('manager_model');
        
        if($this->input->post('update_barang')) {
            $this->manager_model->delete_barang();
        }
        
        $this->manager_model->list_barang();
        
        $this->data['response'] = (!isset($this->data['response'])) ? $this->session->flashdata('response') : $this->data['response'];
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('manager/barang', $this->data);
    }
    
    function edit_barang($id_barang = FALSE) {
        if($this->input->post('edit_barang')) {
            $this->load->model('manager_model');
            $this->manager_model->update_barang($id_barang);
        }
        
        $query = $this->db->get_where('detail_barang', array('id_barang' => $id_barang));
        if($query->num_rows() === 1) {
            $this->data['barang'] = $query->row();
        }
        
        $this->load->view('manager/edit_barang', $this->data);
    }
    
    function input_barang() {
        if($this->input->post('insert_barang')) {
            $this->load->model('manager_model');
            $this->manager_model->input_barang();
        }
        
        $this->load->view('manager/input_barang');
    }
    
    function member() {
        $this->load->model('manager_model');
        
        if($this->input->post('update_member')) {
            $this->manager_model->delete_member();
        }
        
        $this->manager_model->list_member();
        
        $this->data['response'] = (!isset($this->data['response'])) ? $this->session->flashdata('response') : $this->data['response'];
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('manager/member', $this->data);
    }
    
    function input_member() {
        if($this->input->post('insert_member')) {
            $this->load->model('manager_model');
            $this->manager_model->input_member();
        }
        
        $this->load->view('manager/input_member');
    }
    
    function edit_member($id_member = FALSE) {
        if($this->input->post('edit_member')) {
            $this->load->model('manager_model');
            $this->manager_model->update_member($id_member);
        }
        
        $query = $this->db->get_where('member', array('id' => $id_member));
        if($query->num_rows() === 1) {
            $this->data['member'] = $query->row();
        }
        
        $this->load->view('manager/edit_member', $this->data);
    }
    
    function kasir() {
        $this->load->model('manager_model');
        
        if($this->input->post('update_kasir')) {
            $this->manager_model->delete_kasir();
        }
        
        $this->manager_model->list_kasir();
        
        $this->data['response'] = (!isset($this->data['response'])) ? $this->session->flashdata('response') : $this->data['response'];
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('manager/kasir', $this->data);
    }
    
    function input_kasir() {
        if($this->input->post('insert_kasir')) {
            $this->load->model('manager_model');
            $this->manager_model->input_kasir();
        }
        
        $this->load->view('manager/input_kasir');
    }
    
    function edit_kasir($id_kasir = FALSE) {
        if($this->input->post('edit_kasir')) {
            $this->load->model('manager_model');
            $this->manager_model->update_kasir($id_kasir);
        }
        
        $query = $this->db->get_where('user_accounts', array('uacc_id' => $id_kasir));
        if($query->num_rows() === 1) {
            $this->data['kasir'] = $query->row();
        }
        
        $this->load->view('manager/edit_kasir', $this->data);
    }
    
    function profil() {
        $this->load->model('manager_model');
        
        if($this->input->post('update_profil')) {
            $this->manager_model->update_manager();
        }
        
        $this->manager_model->profil();
        
        $this->data['response'] = (!isset($this->data['response'])) ? $this->session->flashdata('response') : $this->data['response'];
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('manager/profil', $this->data);
    }

    function profile1()
    {
        $this->load->model('manager_model');   
        if($this->input->post('update_profil')) {
            $this->manager_model->update_manager();
        }
    }
    
    function password() {
        $this->load->model('manager_model');
        
        if($this->input->post('update_password')) {
            $this->manager_model->change_password();
        }
        
        $this->data['response'] = (!isset($this->data['response'])) ? $this->session->flashdata('response') : $this->data['response'];
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('manager/password', $this->data);
    }
}

/* End of file manager.php */
/* Location: ./application/controllers/manager.php */